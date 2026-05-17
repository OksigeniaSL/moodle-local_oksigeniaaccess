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
 * @copyright  2026 Oksigenia SL <dev@oksigenia.com>
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

        if (self::should_skip_for_scope($config, $PAGE)) {
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

        $hook->add_html(self::render($script, $attrs));
    }

    private static function should_skip_for_scope(\stdClass $config, \moodle_page $page): bool {
        if (($config->scope ?? 'all') !== 'no_login') {
            return false;
        }
        // Login, signup and forgot-password live under /login/ in the URL.
        $url = $page->url->out_as_local_url(false);
        return str_starts_with($url, '/login/');
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

    private static function render(string $scripturl, array $attrs): string {
        $attrhtml = '';
        foreach ($attrs as $name => $value) {
            $attrhtml .= ' ' . $name . '="' . s($value) . '"';
        }

        return "\n<script type=\"module\" src=\"" . s($scripturl) . "\"></script>"
             . "\n<oksigenia-access-panel" . $attrhtml . "></oksigenia-access-panel>\n";
    }
}
