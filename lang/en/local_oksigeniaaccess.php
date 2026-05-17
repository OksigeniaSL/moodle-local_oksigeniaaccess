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
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia SL <dev@oksigenia.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Oksigenia Access';

$string['settings_general']        = 'General';
$string['enabled']                 = 'Enable accessibility panel';
$string['enabled_desc']            = 'When enabled, the floating accessibility panel is injected into every page of this site.';

$string['settings_appearance']     = 'Appearance';
$string['position']                = 'Trigger position (desktop)';
$string['position_desc']           = 'Where the floating trigger button appears on viewports wider than 768 px.';
$string['position_mobile']         = 'Trigger position (mobile)';
$string['position_mobile_desc']    = 'Optional override for viewports up to 768 px. Useful when the desktop position overlaps mobile hero CTAs. Leave on "inherit" to use the same as desktop.';
$string['trigger_icon']            = 'Trigger icon';
$string['trigger_icon_desc']       = 'Icon shown on the floating trigger button.';

$string['settings_behaviour']      = 'Behaviour';
$string['locale_mode']             = 'Locale source';
$string['locale_mode_desc']        = 'Auto follows Moodle\'s current language; Force ignores Moodle and uses the locale you pick.';
$string['locale_mode_auto']        = 'Auto (follow Moodle language)';
$string['locale_mode_force']       = 'Force a specific locale';
$string['locale_override']         = 'Forced locale';
$string['locale_override_desc']    = 'Used only when "Locale source" is set to "Force".';
$string['scope']                   = 'Show on';
$string['scope_desc']              = 'Where to inject the panel.';
$string['scope_all']               = 'All pages';
$string['scope_no_login']          = 'All pages except login/signup';

// Position values (shared between desktop and mobile selects).
$string['pos_top_left']            = 'Top left';
$string['pos_top_right']           = 'Top right';
$string['pos_mid_left']            = 'Middle left';
$string['pos_mid_right']           = 'Middle right';
$string['pos_bottom_left']         = 'Bottom left';
$string['pos_bottom_right']        = 'Bottom right';
$string['pos_inherit']             = 'Inherit from desktop';

// Trigger icons.
$string['icon_vitruvian']          = 'Vitruvian man (default)';
$string['icon_wheelchair']         = 'Wheelchair';
$string['icon_eye']                = 'Eye';
$string['icon_universal']          = 'Universal access';

// Locale options (only those supported by the web component).
$string['locale_es']               = 'Spanish (es)';
$string['locale_en']               = 'English (en)';
$string['locale_gn']               = 'Guarani (gn)';
$string['locale_fr']               = 'French (fr)';
$string['locale_it']               = 'Italian (it)';
$string['locale_de']               = 'German (de)';
$string['locale_nl']               = 'Dutch (nl)';
$string['locale_sv']               = 'Swedish (sv)';

// Privacy provider strings (no personal data stored or transmitted).
$string['privacy:metadata'] = 'The Oksigenia Access plugin does not store or transmit any personal data. User preferences for the accessibility panel are persisted in the visitor\'s browser localStorage only and never reach the server.';
