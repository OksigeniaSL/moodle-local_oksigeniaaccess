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
 * Privacy provider — null implementation.
 *
 * The plugin does not store any personal data on the server. Visitor
 * preferences for the accessibility panel are persisted in the browser's
 * localStorage only and never transmitted.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oksigeniaaccess\privacy;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy null provider for local_oksigeniaaccess.
 */
class provider implements \core_privacy\local\metadata\null_provider {
    /**
     * Return the language string explaining why this plugin stores no personal data.
     *
     * @return string The lang string identifier.
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
