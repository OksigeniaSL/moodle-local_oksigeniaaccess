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

    /** Locales supported by the bundled web component. */
    private const SUPPORTED_LOCALES = ['es', 'en', 'gn', 'fr', 'it', 'de', 'nl', 'sv'];

    /**
     * Append the panel markup just before the footer is generated.
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

        $zindex = self::resolve_zindex($config);

        $hook->add_html(self::render($script, $attrs, $zindex));
    }

    /**
     * Check the capability against the current user at system context.
     * Admins running CLI without a user fall back to true (defensive default
     * for cron / scheduled tasks rendering pages on behalf of the system).
     */
    private static function current_user_can_view(): bool {
        if (!function_exists('has_capability')) {
            return true;
        }
        try {
            return has_capability('local/oksigeniaaccess:view', \context_system::instance());
        } catch (\Throwable $e) {
            return true;
        }
    }

    private static function should_skip_for_scope(\stdClass $config, \moodle_page $page): bool {
        if (($config->scope ?? 'all') !== 'no_login') {
            return false;
        }
        // Login, signup and forgot-password live under /login/ in the URL.
        $url = $page->url->out_as_local_url(false);
        return str_starts_with($url, '/login/');
    }

    private static function should_skip_for_admin(\stdClass $config, \moodle_page $page): bool {
        if (empty($config->hide_on_admin)) {
            return false;
        }
        $url = $page->url->out_as_local_url(false);
        // Moodle 4.x lays admin under /admin/. Moodle 5.x served webroot moved
        // to /public/ but the URL path the browser sees is still /admin/...
        return str_starts_with($url, '/admin/');
    }

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

    private static function resolve_zindex(\stdClass $config): int {
        $z = (int) ($config->trigger_zindex ?? 99999);
        if ($z < 1) {
            $z = 99999;
        }
        return $z;
    }

    /**
     * Build the markup injected before the closing body tag.
     *
     * The z-index is applied via an inline <style> on the host custom
     * element. Browsers inherit the stacking context, and since the bundled
     * web component renders its trigger as `position: fixed` inside its
     * Shadow DOM, the host's z-index governs where it stacks relative to
     * other floating widgets in the host page.
     */
    private static function render(string $scripturl, array $attrs, int $zindex): string {
        $attrhtml = '';
        foreach ($attrs as $name => $value) {
            $attrhtml .= ' ' . $name . '="' . s($value) . '"';
        }

        $style = '<style id="oks-access-zindex">oksigenia-access-panel{position:relative;z-index:' . $zindex . ';}</style>';

        return "\n" . $style
             . "\n<script type=\"module\" src=\"" . s($scripturl) . "\"></script>"
             . "\n<oksigenia-access-panel" . $attrhtml . "></oksigenia-access-panel>\n";
    }
}
