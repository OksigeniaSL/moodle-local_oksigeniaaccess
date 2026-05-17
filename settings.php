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

// --- Appearance ---
$settings->add(new admin_setting_heading(
    'local_oksigeniaaccess/heading_appearance',
    new lang_string('settings_appearance', 'local_oksigeniaaccess'),
    ''
));

$positionoptions = [
    'top-left'     => new lang_string('pos_top_left', 'local_oksigeniaaccess'),
    'top-right'    => new lang_string('pos_top_right', 'local_oksigeniaaccess'),
    'mid-left'     => new lang_string('pos_mid_left', 'local_oksigeniaaccess'),
    'mid-right'    => new lang_string('pos_mid_right', 'local_oksigeniaaccess'),
    'bottom-left'  => new lang_string('pos_bottom_left', 'local_oksigeniaaccess'),
    'bottom-right' => new lang_string('pos_bottom_right', 'local_oksigeniaaccess'),
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
];
$settings->add(new admin_setting_configselect(
    'local_oksigeniaaccess/trigger_icon',
    new lang_string('trigger_icon', 'local_oksigeniaaccess'),
    new lang_string('trigger_icon_desc', 'local_oksigeniaaccess'),
    'vitruvian',
    $iconoptions
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
