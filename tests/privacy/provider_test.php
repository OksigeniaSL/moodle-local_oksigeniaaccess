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

namespace local_oksigeniaaccess\privacy;

/**
 * Tests for the privacy provider: the plugin keeps no personal data.
 *
 * @package    local_oksigeniaaccess
 * @category   test
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_oksigeniaaccess\privacy\provider
 */
final class provider_test extends \advanced_testcase {

    /**
     * The provider is a null provider.
     *
     * @return void
     */
    public function test_is_null_provider(): void {
        $this->assertContains(
            \core_privacy\local\metadata\null_provider::class,
            class_implements(provider::class)
        );
    }

    /**
     * The reason points at an existing language string.
     *
     * @return void
     */
    public function test_get_reason(): void {
        $reason = provider::get_reason();

        $this->assertSame('privacy:metadata', $reason);
        $this->assertTrue(get_string_manager()->string_exists($reason, 'local_oksigeniaaccess'));
        $this->assertNotEmpty(get_string($reason, 'local_oksigeniaaccess'));
    }
}
