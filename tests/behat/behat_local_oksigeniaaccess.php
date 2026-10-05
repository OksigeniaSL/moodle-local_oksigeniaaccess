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

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Mink\Exception\ExpectationException;

/**
 * Steps for the accessibility panel, which lives inside a shadow root.
 *
 * @package    local_oksigeniaaccess
 * @category   test
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_local_oksigeniaaccess extends behat_base {
    /**
     * Wait until the custom element is defined and has rendered its panel.
     *
     * @return void
     */
    protected function wait_for_panel(): void {
        $this->getSession()->wait(10000,
            "(function() {
                var el = document.querySelector('oksigenia-access-panel');
                return !!(el && el.shadowRoot && el.shadowRoot.getElementById('oks-panel'));
            })()");
    }

    /**
     * Start counting the requests that save the panel settings to the account.
     *
     * @Given /^I start watching the accessibility panel saves$/
     * @return void
     */
    public function i_start_watching_the_accessibility_panel_saves(): void {
        // Core's AJAX layer posts to lib/ajax/service.php; count each request,
        // once, whose URL or body names the preference-saving function.
        $this->getSession()->executeScript(
            "window.oksSaves = 0;
            var open = XMLHttpRequest.prototype.open;
            var send = XMLHttpRequest.prototype.send;
            XMLHttpRequest.prototype.open = function(method, url) {
                this.oksUrl = String(url);
                return open.apply(this, arguments);
            };
            XMLHttpRequest.prototype.send = function(body) {
                var fn = 'core_user_set_user_preferences';
                if (this.oksUrl.indexOf(fn) !== -1 || (typeof body === 'string' && body.indexOf(fn) !== -1)) {
                    this.addEventListener('loadend', function() { window.oksSaves++; });
                }
                return send.apply(this, arguments);
            };
            if (window.fetch) {
                var origfetch = window.fetch;
                window.fetch = function(input, init) {
                    var fn = 'core_user_set_user_preferences';
                    var url = String(input && input.url ? input.url : input);
                    var body = init && typeof init.body === 'string' ? init.body : '';
                    var p = origfetch.apply(this, arguments);
                    if (url.indexOf(fn) !== -1 || body.indexOf(fn) !== -1) {
                        p.then(function() { window.oksSaves++; }, function() { window.oksSaves++; });
                    }
                    return p;
                };
            }"
        );
    }

    /**
     * Click a control of the accessibility panel by its data-prefix or data-class.
     *
     * @When /^I click the accessibility panel control "(?P<control>[^"]*)"$/
     * @param string $control e.g. oks-zoom or oks-a11y-contrast.
     * @return void
     */
    public function i_click_the_accessibility_panel_control(string $control): void {
        $this->wait_for_panel();
        $selector = json_encode('[data-prefix="' . $control . '"], [data-class="' . $control . '"]');
        $this->getSession()->executeScript(
            "document.querySelector('oksigenia-access-panel').shadowRoot.querySelector($selector).click();"
        );
    }

    /**
     * Forget whatever this browser remembers about the panel.
     *
     * @When /^I clear the accessibility panel settings in this browser$/
     * @return void
     */
    public function i_clear_the_accessibility_panel_settings_in_this_browser(): void {
        $this->getSession()->executeScript("localStorage.clear();");
    }

    /**
     * Check a class the panel puts on the page body.
     *
     * @Then /^the page body should have the class "(?P<class>[^"]*)"$/
     * @param string $class e.g. oks-zoom-1.
     * @return void
     */
    public function the_page_body_should_have_the_class(string $class): void {
        $this->wait_for_panel();
        $has = $this->getSession()->evaluateScript(
            "return document.body.classList.contains(" . json_encode($class) . ");"
        );
        if (!$has) {
            throw new ExpectationException("The page body does not have the class '$class'", $this->getSession());
        }
    }

    /**
     * Check the number of saves to the account since watching started.
     *
     * @Then /^the accessibility panel should have saved to the account "(?P<count>\d+)" times?$/
     * @param int $count Expected number of requests.
     * @return void
     */
    public function the_accessibility_panel_should_have_saved(int $count): void {
        $saves = (int) $this->getSession()->evaluateScript("return window.oksSaves || 0;");
        if ($saves !== $count) {
            throw new ExpectationException("Expected $count saves to the account, got $saves", $this->getSession());
        }
    }

    /**
     * Check the panel settings stored in a user's account.
     *
     * @Then /^the accessibility panel settings of "(?P<username>[^"]*)" should be '(?P<json>[^']*)'$/
     * @param string $username User whose preference is checked.
     * @param string $json Expected JSON.
     * @return void
     */
    public function the_accessibility_panel_settings_should_be(string $username, string $json): void {
        global $DB;
        $userid = $DB->get_field('user', 'id', ['username' => $username], MUST_EXIST);
        $value = $DB->get_field('user_preferences', 'value',
            ['userid' => $userid, 'name' => 'local_oksigeniaaccess_state']);
        if ($value !== $json) {
            throw new ExpectationException(
                "Expected the account to hold '$json', found '" . var_export($value, true) . "'",
                $this->getSession()
            );
        }
    }
}
