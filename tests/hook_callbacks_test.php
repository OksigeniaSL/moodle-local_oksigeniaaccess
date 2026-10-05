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

/**
 * Tests for the panel injection (hook on 4.4+, legacy callback before that).
 *
 * @package    local_oksigeniaaccess
 * @category   test
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_oksigeniaaccess\local\hook_callbacks
 */
final class hook_callbacks_test extends \advanced_testcase {

    /**
     * Fresh page on the front page, plugin enabled, logged in as a plain user.
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
        $this->setUser($this->getDataGenerator()->create_user());
    }

    /**
     * The enabled plugin renders the script and the custom element.
     *
     * @return void
     */
    public function test_panel_is_injected_when_enabled(): void {
        $html = hook_callbacks::get_footer_html();

        $this->assertStringContainsString('<oksigenia-access-panel', $html);
        $this->assertStringContainsString('/local/oksigeniaaccess/js/web-component.js?v=', $html);
        $this->assertStringContainsString('type="module"', $html);
    }

    /**
     * Nothing is rendered when the master toggle is off.
     *
     * @return void
     */
    public function test_nothing_when_disabled(): void {
        set_config('enabled', 0, 'local_oksigeniaaccess');

        $this->assertSame('', hook_callbacks::get_footer_html());
    }

    /**
     * Nothing is rendered for a user whose role lacks local/oksigeniaaccess:view.
     *
     * @return void
     */
    public function test_nothing_without_capability(): void {
        global $CFG;

        assign_capability('local/oksigeniaaccess:view', CAP_PROHIBIT, $CFG->defaultuserroleid,
            \context_system::instance()->id, true);
        accesslib_clear_all_caches_for_unit_testing();

        $this->assertSame('', hook_callbacks::get_footer_html());
    }

    /**
     * Defaults: every control ticked means no controls attribute, presets shown.
     *
     * @return void
     */
    public function test_default_attributes(): void {
        $html = hook_callbacks::get_footer_html();

        $this->assertStringNotContainsString(' controls="', $html);
        $this->assertStringNotContainsString(' presets="', $html);
        $this->assertStringNotContainsString(' nudge=', $html);
        $this->assertStringContainsString(' locale="en"', $html);
    }

    /**
     * The admin settings end up as attributes and CSS variables on the element.
     *
     * @return void
     */
    public function test_attributes_follow_settings(): void {
        set_config('position', 'bottom-right', 'local_oksigeniaaccess');
        set_config('position_mobile', 'top-left', 'local_oksigeniaaccess');
        set_config('trigger_icon', 'eye', 'local_oksigeniaaccess');
        set_config('controls', 'text-size,contrast', 'local_oksigeniaaccess');
        set_config('show_presets', 0, 'local_oksigeniaaccess');
        set_config('allow_nudge', 1, 'local_oksigeniaaccess');
        set_config('locale_mode', 'force', 'local_oksigeniaaccess');
        set_config('locale_override', 'fr', 'local_oksigeniaaccess');
        set_config('btn_bg', '#123456', 'local_oksigeniaaccess');
        set_config('btn_size', '60px', 'local_oksigeniaaccess');

        $html = hook_callbacks::get_footer_html();

        $this->assertStringContainsString(' position="bottom-right"', $html);
        $this->assertStringContainsString(' position-mobile="top-left"', $html);
        $this->assertStringContainsString(' trigger-icon="eye"', $html);
        $this->assertStringContainsString(' controls="text-size,contrast"', $html);
        $this->assertStringContainsString(' presets="none"', $html);
        $this->assertStringContainsString(' nudge=""', $html);
        $this->assertStringContainsString(' locale="fr"', $html);
        $this->assertStringContainsString('--oks-bg:#123456;', $html);
        $this->assertStringContainsString('--oks-btn-size:60px;', $html);
    }

    /**
     * Values that are not valid CSS never reach the inline style.
     *
     * @return void
     */
    public function test_invalid_css_values_are_dropped(): void {
        set_config('btn_bg', 'red;}</style><script>', 'local_oksigeniaaccess');
        set_config('btn_size', '60px; color: red', 'local_oksigeniaaccess');

        $html = hook_callbacks::get_footer_html();

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringNotContainsString('--oks-bg', $html);
        $this->assertStringNotContainsString('--oks-btn-size', $html);
    }

    /**
     * Excluded course ids hide the panel inside those courses only.
     *
     * @return void
     */
    public function test_excluded_course(): void {
        global $PAGE;

        $excluded = $this->getDataGenerator()->create_course();
        $other = $this->getDataGenerator()->create_course();
        set_config('excluded_course_ids', $excluded->id . ', 9999', 'local_oksigeniaaccess');

        $PAGE = new \moodle_page();
        $PAGE->set_url(new \moodle_url('/course/view.php', ['id' => $excluded->id]));
        $PAGE->set_course($excluded);
        $this->assertSame('', hook_callbacks::get_footer_html());

        $PAGE = new \moodle_page();
        $PAGE->set_url(new \moodle_url('/course/view.php', ['id' => $other->id]));
        $PAGE->set_course($other);
        $this->assertStringContainsString('<oksigenia-access-panel', hook_callbacks::get_footer_html());
    }

    /**
     * The hide-on-admin toggle only affects pages under /admin/.
     *
     * @return void
     */
    public function test_hide_on_admin(): void {
        global $PAGE;

        set_config('hide_on_admin', 1, 'local_oksigeniaaccess');
        $PAGE->set_url(new \moodle_url('/admin/search.php'));
        $this->assertSame('', hook_callbacks::get_footer_html());

        set_config('hide_on_admin', 0, 'local_oksigeniaaccess');
        $this->assertStringContainsString('<oksigenia-access-panel', hook_callbacks::get_footer_html());
    }

    /**
     * The "all pages except login" scope hides the panel under /login/.
     *
     * @return void
     */
    public function test_scope_without_login(): void {
        global $PAGE;

        set_config('scope', 'no_login', 'local_oksigeniaaccess');
        $PAGE->set_url(new \moodle_url('/login/index.php'));
        $this->assertSame('', hook_callbacks::get_footer_html());

        $PAGE = new \moodle_page();
        $PAGE->set_url(new \moodle_url('/'));
        $PAGE->set_context(\context_system::instance());
        $this->assertStringContainsString('<oksigenia-access-panel', hook_callbacks::get_footer_html());
    }

    /**
     * The legacy before_footer callback (Moodle 4.1–4.3) returns the same markup.
     *
     * @covers ::local_oksigeniaaccess_before_footer
     * @return void
     */
    public function test_legacy_callback(): void {
        global $CFG;
        require_once($CFG->dirroot . '/local/oksigeniaaccess/lib.php');

        $this->assertSame(hook_callbacks::get_footer_html(), local_oksigeniaaccess_before_footer());
        $this->assertStringContainsString('<oksigenia-access-panel', local_oksigeniaaccess_before_footer());
    }

    /**
     * On Moodle 4.4+ the hook carries the markup into the footer.
     *
     * @return void
     */
    public function test_hook_adds_html(): void {
        global $PAGE;

        $hookclass = '\core\hook\output\before_footer_html_generation';
        if (!class_exists($hookclass)) {
            $this->markTestSkipped('The before_footer_html_generation hook exists from Moodle 4.4.');
        }

        $hook = new $hookclass($PAGE->get_renderer('core'));
        hook_callbacks::before_footer_html_generation($hook);

        $this->assertStringContainsString('<oksigenia-access-panel', $hook->get_output());
    }
}
