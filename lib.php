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
 * Legacy callbacks for local_oksigeniaaccess.
 *
 * Moodle 4.4+ injects the panel through the before_footer_html_generation hook
 * (db/hooks.php) and skips this callback because the hook replaces it. It is
 * only here so Moodle 4.1–4.3, which predate the hook, get the panel too.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Add the accessibility panel before the page footer (Moodle 4.1–4.3).
 *
 * @return string HTML fragment, or an empty string when the panel must not show.
 */
function local_oksigeniaaccess_before_footer(): string {
    return \local_oksigeniaaccess\local\hook_callbacks::get_footer_html();
}
