<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_oksigeniaaccess\local;

use core\hook\output\before_footer_html_generation;

/**
 * Injects the @oksigenia/access-panel web component into Moodle pages.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /** @var string[] Locales supported by the bundled web component. */
    private const SUPPORTED_LOCALES = ['es', 'en', 'gn', 'fr', 'it', 'de', 'nl', 'sv'];

    /** @var string[] Atomic control ids understood by the web component (controls="..."). */
    private const CONTROL_IDS = [
        'text-size', 'line-height', 'text-align', 'readable-font', 'dyslexia-font', 'letter-spacing',
        'contrast', 'grayscale', 'hide-images', 'highlight-links', 'colorblind',
        'reading-guide', 'reading-mask', 'big-cursor', 'big-targets', 'pause-anim', 'focus',
    ];

    /**
     * Append the panel markup just before the footer is generated.
     *
     * @param before_footer_html_generation $hook Hook instance carrying the buffer.
     * @return void
     */
    public static function before_footer_html_generation(before_footer_html_generation $hook): void {
        global $CFG, $PAGE;

        $config = get_config('local_oksigeniaaccess');

        if (empty($config->enabled)) {
            return;
        }

        if (!self::current_user_can_view()) {
            return;
        }

        if (self::should_skip_for_scope($config, $PAGE)) {
            return;
        }

        if (self::should_skip_for_admin($config, $PAGE)) {
            return;
        }

        if (self::should_skip_for_course($config, $PAGE)) {
            return;
        }

        $version = (int) get_config('local_oksigeniaaccess', 'version');
        $script  = $CFG->wwwroot . '/local/oksigeniaaccess/js/web-component.js?v=' . $version;

        $attrs = [
            'position'     => $config->position ?? 'mid-left',
            'trigger-icon' => $config->trigger_icon ?? 'vitruvian',
            'locale'       => self::resolve_locale($config),
        ];

        if (!empty($config->position_mobile) && $config->position_mobile !== 'inherit') {
            $attrs['position-mobile'] = $config->position_mobile;
        }

        // Control curation: emit controls="..." only when the admin curated a
        // real subset. All/none selected ⇒ omit ⇒ the component shows all 17.
        $controls = self::resolve_controls($config);
        if ($controls !== null) {
            $attrs['controls'] = $controls;
        }

        // Drop the profile presets row when the admin turned it off.
        if (isset($config->show_presets) && (int) $config->show_presets === 0) {
            $attrs['presets'] = 'none';
        }

        // Let visitors reposition the trigger within bounds (drag / arrow keys).
        if (!empty($config->allow_nudge)) {
            $attrs['nudge'] = '';
        }

        $cssvars = self::build_css_vars($config);

        $hook->add_html(self::render($script, $attrs, $cssvars));
    }

    /**
     * Check the capability against the current user at system context.
     *
     * Admins running CLI without a user fall back to true (defensive default
     * for cron / scheduled tasks rendering pages on behalf of the system).
     *
     * @return bool True if the current user is allowed to see the panel.
     */
    private static function current_user_can_view(): bool {
        global $PAGE;
        // Pre-auth pages (login / signup / forgot password all use the 'login'
        // pagelayout) evaluate the capability against the "not logged in" role,
        // which lacks it by default — silently hiding the panel exactly where a
        // visitor needs it to read the form. Bypass the capability there; the
        // "Page scope" setting (all vs. except-login) still controls whether the
        // panel shows on login.
        if (isset($PAGE) && $PAGE->pagelayout === 'login') {
            return true;
        }
        if (!function_exists('has_capability')) {
            return true;
        }
        try {
            return has_capability('local/oksigeniaaccess:view', \context_system::instance());
        } catch (\Throwable $e) {
            return true;
        }
    }

    /**
     * Decide whether the page falls under the "exclude login" scope rule.
     *
     * @param \stdClass     $config Plugin config from get_config().
     * @param \moodle_page  $page   Current Moodle page being rendered.
     * @return bool True if the panel must be skipped on this page.
     */
    private static function should_skip_for_scope(\stdClass $config, \moodle_page $page): bool {
        if (($config->scope ?? 'all') !== 'no_login') {
            return false;
        }
        // Login, signup and forgot-password live under /login/ in the URL.
        $url = $page->url->out_as_local_url(false);
        return str_starts_with($url, '/login/');
    }

    /**
     * Decide whether the page is under /admin/ and the hide-on-admin toggle is on.
     *
     * @param \stdClass     $config Plugin config from get_config().
     * @param \moodle_page  $page   Current Moodle page being rendered.
     * @return bool True if the panel must be skipped on this page.
     */
    private static function should_skip_for_admin(\stdClass $config, \moodle_page $page): bool {
        if (empty($config->hide_on_admin)) {
            return false;
        }
        $url = $page->url->out_as_local_url(false);
        // Moodle 4.x lays admin under /admin/. Moodle 5.x served webroot moved
        // to /public/ but the URL path the browser sees is still /admin/...
        return str_starts_with($url, '/admin/');
    }

    /**
     * Decide whether the current course is in the configured exclusion list.
     *
     * @param \stdClass     $config Plugin config from get_config().
     * @param \moodle_page  $page   Current Moodle page being rendered.
     * @return bool True if the panel must be skipped on this page.
     */
    private static function should_skip_for_course(\stdClass $config, \moodle_page $page): bool {
        $excluded = self::parse_course_ids($config->excluded_course_ids ?? '');
        if (empty($excluded)) {
            return false;
        }
        $courseid = (int) ($page->course->id ?? 0);
        if ($courseid <= 1) {
            // 0 or 1 (site) means we are not inside a real course context.
            return false;
        }
        return in_array($courseid, $excluded, true);
    }

    /**
     * Parse a comma/space/newline-separated list of course IDs into ints.
     *
     * @param string $raw Raw textarea value from the plugin setting.
     * @return int[] Unique positive course IDs (skips 0 and 1 which are not real courses).
     */
    private static function parse_course_ids(string $raw): array {
        if ($raw === '') {
            return [];
        }
        $parts = preg_split('/[\s,]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
        $ids = [];
        foreach ($parts as $p) {
            $n = (int) $p;
            if ($n > 1) {
                $ids[] = $n;
            }
        }
        return array_values(array_unique($ids));
    }

    /**
     * Resolve which locale code (one of SUPPORTED_LOCALES) to pass to the web component.
     *
     * Auto mode reads Moodle's current language and normalises regional variants
     * (e.g. `es_mx` → `es`). Force mode uses the admin-picked locale, falling
     * back to English if the override is somehow invalid.
     *
     * @param \stdClass $config Plugin config from get_config().
     * @return string A locale code supported by the bundled web component.
     */
    private static function resolve_locale(\stdClass $config): string {
        if (($config->locale_mode ?? 'auto') === 'force') {
            $forced = $config->locale_override ?? 'es';
            return in_array($forced, self::SUPPORTED_LOCALES, true) ? $forced : 'en';
        }

        // Auto: follow Moodle's current language, normalised to the component's locales.
        $current = current_language();
        $base = strtolower(explode('_', $current)[0]);
        return in_array($base, self::SUPPORTED_LOCALES, true) ? $base : 'en';
    }

    /**
     * Resolve the controls="..." attribute from the admin multicheckbox.
     *
     * The setting stores a comma-separated list of the ticked control ids.
     * When the admin leaves all (or none) ticked we return null so the
     * attribute is omitted and the web component falls back to all 17 controls
     * — a panel with no controls would be pointless, so unticking everything
     * resets to the full set rather than hiding the lot.
     *
     * @param \stdClass $config Plugin config from get_config().
     * @return string|null The curated controls list, or null to show all.
     */
    private static function resolve_controls(\stdClass $config): ?string {
        $raw = $config->controls ?? '';
        if (!is_string($raw) || $raw === '') {
            return null;
        }
        $selected = array_values(array_intersect(
            self::CONTROL_IDS,
            array_map('trim', explode(',', $raw))
        ));
        $count = count($selected);
        if ($count === 0 || $count === count(self::CONTROL_IDS)) {
            return null;
        }
        return implode(',', $selected);
    }

    /**
     * Build the map of CSS custom properties to apply on the host element.
     *
     * Empty values fall through so the web component uses its built-in
     * defaults (black / white / 55px / 9999999). Values are sanitised here
     * even though Moodle's settings already validate them — admin context
     * is trusted but defence in depth is cheap.
     *
     * @param \stdClass $config Plugin config from get_config().
     * @return array Map of CSS variable name to value, ready to render.
     */
    private static function build_css_vars(\stdClass $config): array {
        $vars = [];

        $zraw = trim((string) ($config->trigger_zindex ?? ''));
        if ($zraw !== '' && ctype_digit($zraw) && (int) $zraw >= 1) {
            $vars['--oks-z'] = $zraw;
        }

        $size = self::sanitise_css_size((string) ($config->btn_size ?? ''));
        if ($size !== '') {
            $vars['--oks-btn-size'] = $size;
        }

        $colormap = [
            'btn_bg'     => '--oks-bg',
            'btn_icon'   => '--oks-icon',
            'btn_h_bg'   => '--oks-h-bg',
            'btn_h_icon' => '--oks-h-icon',
        ];
        foreach ($colormap as $key => $cssvar) {
            $color = self::sanitise_css_color((string) ($config->$key ?? ''));
            if ($color !== '') {
                $vars[$cssvar] = $color;
            }
        }

        return $vars;
    }

    /**
     * Accept hex / rgb[a] / hsl[a] / named CSS colors. Reject anything else.
     *
     * @param string $raw Raw color string from the plugin setting.
     * @return string The sanitised color or '' if the input is not a valid CSS color.
     */
    private static function sanitise_css_color(string $raw): string {
        $raw = trim($raw);
        if ($raw === '') {
            return '';
        }
        if (preg_match('/^#[0-9a-f]{3,8}$/i', $raw)) {
            return $raw;
        }
        if (preg_match('/^rgba?\(\s*\d{1,3}(\s*,\s*\d{1,3}){2,3}\s*\)$/i', $raw)) {
            return $raw;
        }
        if (preg_match('/^hsla?\(\s*\d{1,3}\s*,\s*\d{1,3}%\s*,\s*\d{1,3}%(\s*,\s*[\d\.]+)?\s*\)$/i', $raw)) {
            return $raw;
        }
        if (preg_match('/^[a-z]{3,20}$/i', $raw)) {
            return strtolower($raw);
        }
        return '';
    }

    /**
     * Accept a positive number with a CSS unit (px/em/rem/vw/vh/%). Reject the rest.
     *
     * @param string $raw Raw size string from the plugin setting.
     * @return string The sanitised size or '' if the input is not a valid CSS length.
     */
    private static function sanitise_css_size(string $raw): string {
        $raw = trim($raw);
        if ($raw === '') {
            return '';
        }
        if (preg_match('/^[0-9]+(\.[0-9]+)?(px|em|rem|vw|vh|%)$/i', $raw)) {
            return strtolower($raw);
        }
        return '';
    }

    /**
     * Build the markup injected before the closing body tag.
     *
     * CSS custom properties are applied via an inline <style> on the host
     * custom element. Since the bundled @oksigenia/access-panel v0.3.0+
     * exposes --oks-z, --oks-btn-size, --oks-bg, --oks-icon, --oks-h-bg and
     * --oks-h-icon, these propagate through the Shadow DOM boundary and
     * change the trigger's z-index, size and colors deterministically.
     *
     * @param string $scripturl Absolute URL of the vendored web component script.
     * @param array  $attrs     Attributes (name => value) to render on <oksigenia-access-panel>.
     * @param array  $cssvars   CSS variables (--name => value) to set on the host element.
     * @return string The HTML fragment to inject before the footer.
     */
    private static function render(string $scripturl, array $attrs, array $cssvars): string {
        $attrhtml = '';
        foreach ($attrs as $name => $value) {
            $attrhtml .= ' ' . $name . '="' . s($value) . '"';
        }

        $style = '';
        if (!empty($cssvars)) {
            $decls = '';
            foreach ($cssvars as $name => $value) {
                // Names are hardcoded; values are pre-sanitised. s() escapes
                // for HTML context (no quotes break <style>).
                $decls .= $name . ':' . $value . ';';
            }
            $style = '<style id="oks-access-vars">oksigenia-access-panel{' . $decls . '}</style>';
        }

        return "\n" . $style
             . "\n<script type=\"module\" src=\"" . s($scripturl) . "\"></script>"
             . "\n<oksigenia-access-panel" . $attrhtml . "></oksigenia-access-panel>\n";
    }
}
