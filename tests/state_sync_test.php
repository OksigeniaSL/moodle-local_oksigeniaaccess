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

namespace local_oksigeniaaccess;

use local_oksigeniaaccess\local\hook_callbacks;
use local_oksigeniaaccess\local\state_sync;

/**
 * Tests for keeping the panel settings in the user's account.
 *
 * @package    local_oksigeniaaccess
 * @category   test
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_oksigeniaaccess\local\state_sync
 */
#[\PHPUnit\Framework\Attributes\CoversClass(state_sync::class)]
final class state_sync_test extends \advanced_testcase {
    /**
     * Fresh page on the front page with the plugin enabled.
     *
     * @return void
     */
    protected function setUp(): void {
        global $PAGE;
        parent::setUp();
        $this->resetAfterTest();

        $PAGE = new \moodle_page();
        $PAGE->set_url(new \moodle_url('/'));
        $PAGE->set_context(\context_system::instance());

        set_config('enabled', 1, 'local_oksigeniaaccess');
    }

    /**
     * Pull the initial-state attribute out of the rendered markup, decoded.
     *
     * @param string $html Markup returned by get_footer_html().
     * @return string|null The attribute value, or null when it is absent.
     */
    private function initial_state_of(string $html): ?string {
        if (!preg_match('/ initial-state="([^"]*)"/', $html, $m)) {
            return null;
        }
        return html_entity_decode($m[1], ENT_QUOTES);
    }

    /**
     * Inline AMD code queued on the page so far.
     *
     * @return string
     */
    private function amd_code(): string {
        global $PAGE;
        $prop = new \ReflectionProperty($PAGE->requires, 'amdjscode');
        $prop->setAccessible(true);
        return implode("\n", (array) $prop->getValue($PAGE->requires));
    }

    /**
     * A signed-in user with saved settings gets them back as initial-state.
     *
     * @return void
     */
    public function test_initial_state_for_signed_in_user(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        set_user_preference(state_sync::PREFERENCE, '{"zoom":2,"dyslexia":true}');

        $html = hook_callbacks::get_footer_html();

        $this->assertSame('{"zoom":2,"dyslexia":true}', $this->initial_state_of($html));
    }

    /**
     * Without saved settings there is no initial-state, but the sync still loads.
     *
     * @return void
     */
    public function test_no_initial_state_without_preference(): void {
        $this->setUser($this->getDataGenerator()->create_user());

        $html = hook_callbacks::get_footer_html();

        $this->assertNull($this->initial_state_of($html));
        $this->assertStringContainsString('oksiac:change', $this->amd_code());
    }

    /**
     * Guests never get initial-state nor the saving script.
     *
     * @return void
     */
    public function test_never_for_guests(): void {
        $this->setGuestUser();
        set_user_preference(state_sync::PREFERENCE, '{"zoom":2}');

        $html = hook_callbacks::get_footer_html();

        $this->assertStringContainsString('<oksigenia-access-panel', $html);
        $this->assertNull($this->initial_state_of($html));
        $this->assertStringNotContainsString('oksiac:change', $this->amd_code());
    }

    /**
     * Visitors who are not signed in keep everything in the browser.
     *
     * @return void
     */
    public function test_never_when_not_logged_in(): void {
        $this->setUser(0);

        $html = hook_callbacks::get_footer_html();

        $this->assertNull($this->initial_state_of($html));
        $this->assertStringNotContainsString('oksiac:change', $this->amd_code());
    }

    /**
     * With the setting off, signed-in users are treated like everyone else.
     *
     * @return void
     */
    public function test_setting_off(): void {
        set_config('syncprefs', 0, 'local_oksigeniaaccess');
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        set_user_preference(state_sync::PREFERENCE, '{"zoom":2}');

        $html = hook_callbacks::get_footer_html();

        $this->assertNull($this->initial_state_of($html));
        $this->assertStringNotContainsString('oksiac:change', $this->amd_code());
    }

    /**
     * Only clean JSON objects up to the size limit make it to the page.
     *
     * @return void
     */
    public function test_clean_rejects_bad_values(): void {
        $this->assertNull(state_sync::clean(null));
        $this->assertNull(state_sync::clean(''));
        $this->assertNull(state_sync::clean('{not json'));
        $this->assertNull(state_sync::clean('[1,2]'));
        $this->assertNull(state_sync::clean('"zoom"'));
        $this->assertNull(state_sync::clean('42'));
        $this->assertNull(state_sync::clean('{"zoom":1,"pad":"' . str_repeat('x', state_sync::MAX_BYTES) . '"}'));
    }

    /**
     * Unknown keys and out-of-range values are dropped; only active settings stay.
     *
     * @return void
     */
    public function test_clean_sanitises(): void {
        $this->assertSame(
            '{"zoom":2,"dyslexia":true}',
            state_sync::clean('{"zoom":2,"lh":9,"align":-1,"dyslexia":true,"contrast":"yes","evil":"<script>"}')
        );
        $this->assertSame('{}', state_sync::clean('{}'));
        $this->assertSame('{"font":true}', state_sync::clean('{"font":1}'));
    }

    /**
     * Whatever is stored, the attribute stays inside its quotes.
     *
     * @return void
     */
    public function test_attribute_is_escaped(): void {
        $this->setUser($this->getDataGenerator()->create_user());
        set_user_preference(state_sync::PREFERENCE, '{"zoom":1}');

        $html = hook_callbacks::get_footer_html();

        $this->assertStringContainsString(' initial-state="{&quot;zoom&quot;:1}"', $html);
    }

    /**
     * The preference is declared and only its owner may change it.
     *
     * @return void
     */
    public function test_permission_callback(): void {
        $owner = $this->getDataGenerator()->create_user();
        $other = $this->getDataGenerator()->create_user();

        $this->setUser($owner);
        $this->assertTrue(\core_user::can_edit_preference(state_sync::PREFERENCE, $owner));
        $this->assertFalse(\core_user::can_edit_preference(state_sync::PREFERENCE, $other));

        $this->setGuestUser();
        $this->assertFalse(state_sync::can_edit(\core_user::get_user($owner->id)));
    }
}
