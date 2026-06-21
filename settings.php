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
 * Site admin settings page for local_oksigeniaaccess.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia SL <dev@oksigenia.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (!$hassiteconfig) {
    return;
}

$settings = new admin_settingpage(
    'local_oksigeniaaccess',
    new lang_string('pluginname', 'local_oksigeniaaccess')
);
$ADMIN->add('localplugins', $settings);

// --- Compliance disclaimer (always at the top) ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/disclaimer',
    new lang_string('disclaimer_heading', 'local_oksigeniaaccess'),
    new lang_string('disclaimer_html', 'local_oksigeniaaccess')
));

// --- General ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_general',
    new lang_string('settings_general', 'local_oksigeniaaccess'),
    ''
));

$settings->add(new admin_setting_configcheckbox(
    'local_oksigeniaaccess/enabled',
    new lang_string('enabled', 'local_oksigeniaaccess'),
    new lang_string('enabled_desc', 'local_oksigeniaaccess'),
    1
));

// --- Visibility & scope ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_scope',
    new lang_string('settings_scope', 'local_oksigeniaaccess'),
    ''
));

$scopeoptions = [
    'all'      => new lang_string('scope_all', 'local_oksigeniaaccess'),
    'no_login' => new lang_string('scope_no_login', 'local_oksigeniaaccess'),
];
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/scope',
    new lang_string('scope', 'local_oksigeniaaccess'),
    new lang_string('scope_desc', 'local_oksigeniaaccess'),
    'all',
    $scopeoptions
));

$settings->add(new admin_setting_configcheckbox(
    'local_oksigeniaaccess/hide_on_admin',
    new lang_string('hide_on_admin', 'local_oksigeniaaccess'),
    new lang_string('hide_on_admin_desc', 'local_oksigeniaaccess'),
    1
));

$settings->add(new admin_setting_configtext(
    'local_oksigeniaaccess/excluded_course_ids',
    new lang_string('excluded_course_ids', 'local_oksigeniaaccess'),
    new lang_string('excluded_course_ids_desc', 'local_oksigeniaaccess'),
    '',
    PARAM_RAW_TRIMMED
));

$settings->add(new admin_setting_configtext(
    'local_oksigeniaaccess/trigger_zindex',
    new lang_string('trigger_zindex', 'local_oksigeniaaccess'),
    new lang_string('trigger_zindex_desc', 'local_oksigeniaaccess'),
    '',
    PARAM_RAW_TRIMMED
));

// --- Trigger appearance ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_colors',
    new lang_string('settings_colors', 'local_oksigeniaaccess'),
    new lang_string('settings_colors_desc', 'local_oksigeniaaccess')
));

$settings->add(new admin_setting_configtext(
    'local_oksigeniaaccess/btn_size',
    new lang_string('btn_size', 'local_oksigeniaaccess'),
    new lang_string('btn_size_desc', 'local_oksigeniaaccess'),
    '',
    PARAM_RAW_TRIMMED
));

$settings->add(new admin_setting_configcolourpicker(
    'local_oksigeniaaccess/btn_bg',
    new lang_string('btn_bg', 'local_oksigeniaaccess'),
    new lang_string('btn_bg_desc', 'local_oksigeniaaccess'),
    ''
));

$settings->add(new admin_setting_configcolourpicker(
    'local_oksigeniaaccess/btn_icon',
    new lang_string('btn_icon', 'local_oksigeniaaccess'),
    new lang_string('btn_icon_desc', 'local_oksigeniaaccess'),
    ''
));

$settings->add(new admin_setting_configcolourpicker(
    'local_oksigeniaaccess/btn_h_bg',
    new lang_string('btn_h_bg', 'local_oksigeniaaccess'),
    new lang_string('btn_h_bg_desc', 'local_oksigeniaaccess'),
    ''
));

$settings->add(new admin_setting_configcolourpicker(
    'local_oksigeniaaccess/btn_h_icon',
    new lang_string('btn_h_icon', 'local_oksigeniaaccess'),
    new lang_string('btn_h_icon_desc', 'local_oksigeniaaccess'),
    ''
));

// --- Appearance ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_appearance',
    new lang_string('settings_appearance', 'local_oksigeniaaccess'),
    ''
));

$positionoptions = [
    'top-left'      => new lang_string('pos_top_left', 'local_oksigeniaaccess'),
    'top-center'    => new lang_string('pos_top_center', 'local_oksigeniaaccess'),
    'top-right'     => new lang_string('pos_top_right', 'local_oksigeniaaccess'),
    'mid-left'      => new lang_string('pos_mid_left', 'local_oksigeniaaccess'),
    'mid-center'    => new lang_string('pos_mid_center', 'local_oksigeniaaccess'),
    'mid-right'     => new lang_string('pos_mid_right', 'local_oksigeniaaccess'),
    'bottom-left'   => new lang_string('pos_bottom_left', 'local_oksigeniaaccess'),
    'bottom-center' => new lang_string('pos_bottom_center', 'local_oksigeniaaccess'),
    'bottom-right'  => new lang_string('pos_bottom_right', 'local_oksigeniaaccess'),
];
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/position',
    new lang_string('position', 'local_oksigeniaaccess'),
    new lang_string('position_desc', 'local_oksigeniaaccess'),
    'mid-left',
    $positionoptions
));

$positionmobileoptions = ['inherit' => new lang_string('pos_inherit', 'local_oksigeniaaccess')] + $positionoptions;
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/position_mobile',
    new lang_string('position_mobile', 'local_oksigeniaaccess'),
    new lang_string('position_mobile_desc', 'local_oksigeniaaccess'),
    'inherit',
    $positionmobileoptions
));

$iconoptions = [
    'vitruvian'  => new lang_string('icon_vitruvian', 'local_oksigeniaaccess'),
    'wheelchair' => new lang_string('icon_wheelchair', 'local_oksigeniaaccess'),
    'eye'        => new lang_string('icon_eye', 'local_oksigeniaaccess'),
    'universal'  => new lang_string('icon_universal', 'local_oksigeniaaccess'),
    'porthole'   => new lang_string('icon_porthole', 'local_oksigeniaaccess'),
];
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/trigger_icon',
    new lang_string('trigger_icon', 'local_oksigeniaaccess'),
    new lang_string('trigger_icon_desc', 'local_oksigeniaaccess'),
    'vitruvian',
    $iconoptions
));

$settings->add(new admin_setting_configcheckbox(
    'local_oksigeniaaccess/allow_nudge',
    new lang_string('allow_nudge', 'local_oksigeniaaccess'),
    new lang_string('allow_nudge_desc', 'local_oksigeniaaccess'),
    0
));

// --- Controls & profiles ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_controls',
    new lang_string('settings_controls', 'local_oksigeniaaccess'),
    new lang_string('settings_controls_desc', 'local_oksigeniaaccess')
));

// One checkbox per atomic control. The key is the control id the web component
// understands (controls="..."); unticking a control hides it for visitors.
$controllangkeys = [
    'text-size'       => 'ctrl_text_size',
    'line-height'     => 'ctrl_line_height',
    'text-align'      => 'ctrl_text_align',
    'readable-font'   => 'ctrl_readable_font',
    'dyslexia-font'   => 'ctrl_dyslexia_font',
    'letter-spacing'  => 'ctrl_letter_spacing',
    'contrast'        => 'ctrl_contrast',
    'grayscale'       => 'ctrl_grayscale',
    'hide-images'     => 'ctrl_hide_images',
    'highlight-links' => 'ctrl_highlight_links',
    'colorblind'      => 'ctrl_colorblind',
    'reading-guide'   => 'ctrl_reading_guide',
    'reading-mask'    => 'ctrl_reading_mask',
    'big-cursor'      => 'ctrl_big_cursor',
    'big-targets'     => 'ctrl_big_targets',
    'pause-anim'      => 'ctrl_pause_anim',
    'focus'           => 'ctrl_focus',
];
$controlchoices = [];
$controldefaults = [];
foreach ($controllangkeys as $id => $langkey) {
    $controlchoices[$id] = new lang_string($langkey, 'local_oksigeniaaccess');
    $controldefaults[$id] = 1;
}
$settings->add(new admin_setting_configmulticheckbox(
    'local_oksigeniaaccess/controls',
    new lang_string('controls', 'local_oksigeniaaccess'),
    new lang_string('controls_desc', 'local_oksigeniaaccess'),
    $controldefaults,
    $controlchoices
));

$settings->add(new admin_setting_configcheckbox(
    'local_oksigeniaaccess/show_presets',
    new lang_string('show_presets', 'local_oksigeniaaccess'),
    new lang_string('show_presets_desc', 'local_oksigeniaaccess'),
    1
));

// --- Behaviour ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_behaviour',
    new lang_string('settings_behaviour', 'local_oksigeniaaccess'),
    ''
));

$localemodeoptions = [
    'auto'  => new lang_string('locale_mode_auto', 'local_oksigeniaaccess'),
    'force' => new lang_string('locale_mode_force', 'local_oksigeniaaccess'),
];
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/locale_mode',
    new lang_string('locale_mode', 'local_oksigeniaaccess'),
    new lang_string('locale_mode_desc', 'local_oksigeniaaccess'),
    'auto',
    $localemodeoptions
));

$localeoptions = [];
foreach (['es', 'en', 'gn', 'fr', 'it', 'de', 'nl', 'sv'] as $code) {
    $localeoptions[$code] = new lang_string('locale_' . $code, 'local_oksigeniaaccess');
}
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/locale_override',
    new lang_string('locale_override', 'local_oksigeniaaccess'),
    new lang_string('locale_override_desc', 'local_oksigeniaaccess'),
    'es',
    $localeoptions
));
