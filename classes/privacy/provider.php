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
 * Privacy provider.
 *
 * Guests' panel settings stay in their browser. For signed-in users, when the
 * admin keeps "Keep the panel settings in the user's account" on, the settings
 * are also stored as a user preference so they follow the user across devices.
 * Core deletes user preferences along with the user.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_oksigeniaaccess\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\writer;
use local_oksigeniaaccess\local\state_sync;

/**
 * Privacy provider for local_oksigeniaaccess.
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\user_preference_provider {
    /**
     * Describe the user preference this plugin keeps.
     *
     * @param collection $collection The collection to add to.
     * @return collection The updated collection.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_user_preference(state_sync::PREFERENCE, 'privacy:metadata:preference:state');
        return $collection;
    }

    /**
     * Export the panel settings kept in the user's account, if any.
     *
     * @param int $userid The user whose preferences are exported.
     * @return void
     */
    public static function export_user_preferences(int $userid) {
        $value = get_user_preferences(state_sync::PREFERENCE, null, $userid);
        if ($value !== null) {
            writer::export_user_preference(
                'local_oksigeniaaccess',
                state_sync::PREFERENCE,
                $value,
                get_string('privacy:preference:state', 'local_oksigeniaaccess')
            );
        }
    }
}
