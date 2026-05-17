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

/**
 * Language strings for local_oksigeniaaccess (English).
 *
 * Keys are sorted alphabetically as required by Moodle's LangFilesOrdering
 * sniff. Logical grouping (general / appearance / scope / behaviour /
 * colors / disclaimer / locales / icons / positions) is documented in the
 * settings page itself via admin_setting_heading entries.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['btn_bg'] = 'Idle background';
$string['btn_bg_desc'] = 'Background color of the trigger button at rest. Default <code>#000</code>.';
$string['btn_h_bg'] = 'Hover background';
$string['btn_h_bg_desc'] = 'Background color of the trigger button on hover. Default <code>#fff</code>.';
$string['btn_h_icon'] = 'Hover icon color';
$string['btn_h_icon_desc'] = 'Color of the icon inside the trigger button on hover. Default <code>#000</code>.';
$string['btn_icon'] = 'Idle icon color';
$string['btn_icon_desc'] = 'Color of the icon inside the trigger button at rest. Default <code>#fff</code>.';
$string['btn_size'] = 'Button size';
$string['btn_size_desc'] = 'CSS size (with unit, e.g. <code>60px</code>) of the floating button. Default <code>55px</code>. Leave empty to use the default.';
$string['disclaimer_heading'] = 'Compliance notice';
$string['disclaimer_html'] = '<p>Oksigenia Access gives the visitor 15 controls to adapt the site to their needs: text size, contrast, dyslexia font, color-blind modes, reading guide, big cursor, pause animations, and others. Preferences are stored only in the visitor\'s browser, never on the server.</p><p><strong>This plugin does not audit or auto-fix the content of your Moodle.</strong> Complying with WCAG 2.1, EU Directive 2016/2102, the European Accessibility Act 2025 or Spain\'s RD 1112/2018 requires editorial work on your courses: alt text on images, video transcripts, color contrast, correct HTML semantics, labelled forms, keyboard navigation, and so on. None of that is fixed by a floating widget.</p><p>For signed documentary evidence in an official audit, we offer a separate professional audit + certificate service at <a href="https://sponsor.oksigenia.com" target="_blank" rel="noopener noreferrer">sponsor.oksigenia.com</a>.</p>';
$string['enabled'] = 'Enable accessibility panel';
$string['enabled_desc'] = 'When enabled, the floating accessibility panel is injected into every page of this site.';
$string['excluded_course_ids'] = 'Excluded course IDs';
$string['excluded_course_ids_desc'] = 'Comma- or space-separated list of course IDs where the panel should NOT be injected (e.g. <code>12, 34, 78</code>). Useful for specific courses with their own accessibility scaffolding or third-party tooling. Leave empty to inject in every course.';
$string['hide_on_admin'] = 'Hide on admin pages';
$string['hide_on_admin_desc'] = 'When enabled, the panel is not injected into Site administration URLs (/admin/...). Recommended ON: admins use their own accessibility tooling and the panel may overlap settings UI.';
$string['icon_eye'] = 'Eye';
$string['icon_universal'] = 'Universal access';
$string['icon_vitruvian'] = 'Vitruvian man (default)';
$string['icon_wheelchair'] = 'Wheelchair';
$string['locale_de'] = 'German (de)';
$string['locale_en'] = 'English (en)';
$string['locale_es'] = 'Spanish (es)';
$string['locale_fr'] = 'French (fr)';
$string['locale_gn'] = 'Guarani (gn)';
$string['locale_it'] = 'Italian (it)';
$string['locale_mode'] = 'Locale source';
$string['locale_mode_auto'] = 'Auto (follow Moodle language)';
$string['locale_mode_desc'] = 'Auto follows Moodle\'s current language; Force ignores Moodle and uses the locale you pick.';
$string['locale_mode_force'] = 'Force a specific locale';
$string['locale_nl'] = 'Dutch (nl)';
$string['locale_override'] = 'Forced locale';
$string['locale_override_desc'] = 'Used only when "Locale source" is set to "Force".';
$string['locale_sv'] = 'Swedish (sv)';
$string['oksigeniaaccess:view'] = 'See the accessibility panel';
$string['pluginname'] = 'Oksigenia Access';
$string['pos_bottom_left'] = 'Bottom left';
$string['pos_bottom_right'] = 'Bottom right';
$string['pos_inherit'] = 'Inherit from desktop';
$string['pos_mid_left'] = 'Middle left';
$string['pos_mid_right'] = 'Middle right';
$string['pos_top_left'] = 'Top left';
$string['pos_top_right'] = 'Top right';
$string['position'] = 'Trigger position (desktop)';
$string['position_desc'] = 'Where the floating trigger button appears on viewports wider than 768 px.';
$string['position_mobile'] = 'Trigger position (mobile)';
$string['position_mobile_desc'] = 'Optional override for viewports up to 768 px. Useful when the desktop position overlaps mobile hero CTAs. Leave on "inherit" to use the same as desktop.';
$string['privacy:metadata'] = 'The Oksigenia Access plugin does not store or transmit any personal data. User preferences for the accessibility panel are persisted in the visitor\'s browser localStorage only and never reach the server.';
$string['scope'] = 'Page scope';
$string['scope_all'] = 'All pages';
$string['scope_desc'] = 'Broad rule for where to inject the panel.';
$string['scope_no_login'] = 'All pages except login/signup';
$string['settings_appearance'] = 'Appearance';
$string['settings_behaviour'] = 'Behaviour';
$string['settings_colors'] = 'Trigger appearance';
$string['settings_colors_desc'] = 'Customise the floating trigger button to blend with your Moodle theme. Leave any field empty to use the default value baked into the web component. Colors are CSS color values: hex (<code>#00d4ff</code>), <code>rgb()</code>, <code>hsl()</code> or a named color.';
$string['settings_general'] = 'General';
$string['settings_scope'] = 'Visibility & scope';
$string['trigger_icon'] = 'Trigger icon';
$string['trigger_icon_desc'] = 'Icon shown on the floating trigger button.';
$string['trigger_zindex'] = 'Trigger z-index';
$string['trigger_zindex_desc'] = 'CSS z-index for the floating trigger button. Leave empty to use the web component\'s built-in default (<code>9999999</code>). Set a positive integer to override — raise it if the trigger gets covered by another floating widget (theme scrolltop, chat bubble, cookie banner...). Backed by the web component\'s <code>--oks-z</code> CSS variable since v0.3.0 — deterministic across browsers.';
