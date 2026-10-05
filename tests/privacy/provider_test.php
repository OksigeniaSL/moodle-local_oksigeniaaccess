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

use core_privacy\local\metadata\collection;
use core_privacy\local\request\writer;
use local_oksigeniaaccess\local\state_sync;

/**
 * Tests for the privacy provider: the panel settings kept in the user's account.
 *
 * @package    local_oksigeniaaccess
 * @category   test
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_oksigeniaaccess\privacy\provider
 */
#[\PHPUnit\Framework\Attributes\CoversClass(provider::class)]
final class provider_test extends \core_privacy\tests\provider_testcase {
    /**
     * The metadata declares the user preference with an existing string.
     *
     * @return void
     */
    public function test_get_metadata(): void {
        $collection = provider::get_metadata(new collection('local_oksigeniaaccess'));
        $items = $collection->get_collection();

        $this->assertCount(1, $items);
        $item = reset($items);
        $this->assertInstanceOf(\core_privacy\local\metadata\types\user_preference::class, $item);
        $this->assertSame(state_sync::PREFERENCE, $item->get_name());
        $this->assertTrue(get_string_manager()->string_exists($item->get_summary(), 'local_oksigeniaaccess'));
    }

    /**
     * Saved settings are exported for their owner.
     *
     * @return void
     */
    public function test_export_user_preferences(): void {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();
        set_user_preference(state_sync::PREFERENCE, '{"zoom":2}', $user);

        provider::export_user_preferences((int) $user->id);

        $writer = writer::with_context(\context_system::instance());
        $this->assertTrue($writer->has_any_data());
        $prefs = $writer->get_user_preferences('local_oksigeniaaccess');
        $this->assertSame('{"zoom":2}', $prefs->{state_sync::PREFERENCE}->value);
    }

    /**
     * Nothing is exported for a user without saved settings.
     *
     * @return void
     */
    public function test_export_nothing_without_preference(): void {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();

        provider::export_user_preferences((int) $user->id);

        $this->assertFalse(writer::with_context(\context_system::instance())->has_any_data());
    }
}
