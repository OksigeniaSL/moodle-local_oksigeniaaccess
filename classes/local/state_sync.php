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

namespace local_oksigeniaaccess\local;

/**
 * Keeps a signed-in user's panel settings in their Moodle account.
 *
 * The web component stores the settings in the browser. For a signed-in user
 * (not a guest) the page also hands the account copy back as initial-state and
 * listens for oksiac:change to save it again, so the settings follow the user
 * across devices. Guests keep theirs in the browser only.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class state_sync {
    /** @var string User preference holding the panel settings (JSON). */
    public const PREFERENCE = 'local_oksigeniaaccess_state';

    /** @var int Largest JSON accepted, in bytes. A full state is ~300. */
    public const MAX_BYTES = 4096;

    /** @var array Multi-step controls and their highest level (0 = off). */
    private const LEVELS = ['zoom' => 4, 'lh' => 3, 'align' => 3, 'ls' => 3, 'colorblind' => 3];

    /** @var string[] On/off controls. */
    private const TOGGLES = [
        'font', 'dyslexia', 'contrast', 'hideImages', 'highlightLinks', 'bigCursor',
        'pauseAnim', 'focusOutline', 'grayOverlay', 'readingGuide', 'readingMask', 'bigTargets',
    ];

    /**
     * Whether the settings should be kept in the current user's account.
     *
     * Needs the admin setting on (the default), a real signed-in user and no
     * "log in as" session, so an admin never overwrites someone else's choice.
     *
     * @param \stdClass $config Plugin config from get_config().
     * @return bool
     */
    public static function is_active(\stdClass $config): bool {
        if (isset($config->syncprefs) && empty($config->syncprefs)) {
            return false;
        }
        if (!isloggedin() || isguestuser()) {
            return false;
        }
        return !\core\session\manager::is_loggedinas();
    }

    /**
     * Turn a stored value into a clean state JSON, or null when it isn't one.
     *
     * Only a JSON object up to MAX_BYTES is accepted. Unknown keys and
     * out-of-range values are dropped; only the active settings are kept.
     *
     * @param string|null $raw Raw preference value.
     * @return string|null Clean JSON object (possibly "{}"), or null.
     */
    public static function clean(?string $raw): ?string {
        if ($raw === null || $raw === '' || strlen($raw) > self::MAX_BYTES) {
            return null;
        }
        $decoded = json_decode($raw);
        if (!($decoded instanceof \stdClass)) {
            return null;
        }
        $clean = [];
        foreach (self::LEVELS as $key => $max) {
            $value = $decoded->$key ?? null;
            if (is_int($value) && $value > 0 && $value <= $max) {
                $clean[$key] = $value;
            }
        }
        foreach (self::TOGGLES as $key) {
            $value = $decoded->$key ?? null;
            if ($value === true || $value === 1) {
                $clean[$key] = true;
            }
        }
        return empty($clean) ? '{}' : json_encode($clean);
    }

    /**
     * The current user's saved settings, cleaned, or null if there are none.
     *
     * @return string|null
     */
    public static function initial_state(): ?string {
        return self::clean(get_user_preferences(self::PREFERENCE, null));
    }

    /**
     * Load the small script that saves each change to the user's account.
     *
     * Inline AMD so there is no build step to keep in sync across Moodle
     * versions. Saves through core_user_set_user_preferences, which checks
     * the preference definition in lib.php (own user only), one second after
     * the last change, and flushes a pending change when the page goes away.
     *
     * @param \moodle_page $page Page being rendered.
     * @param int $userid Current user id.
     * @return void
     */
    public static function require_js(\moodle_page $page, int $userid): void {
        $js = <<<'JS'
require(['core/ajax'], function(Ajax) {
    var userid = __USERID__;
    var timer = null;
    var pending = null;
    var flush = function() {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
        if (pending === null) {
            return;
        }
        var value = pending;
        pending = null;
        Ajax.call([{
            methodname: 'core_user_set_user_preferences',
            args: {preferences: [{name: '__PREF__', value: value, userid: userid}]}
        }])[0].catch(function() {
            // Not fatal: the browser copy still holds the settings.
        });
    };
    document.addEventListener('oksiac:change', function(e) {
        var state = e.detail && e.detail.state;
        if (!state || typeof state !== 'object') {
            return;
        }
        var active = {};
        Object.keys(state).forEach(function(key) {
            var value = state[key];
            if (value === true || (typeof value === 'number' && value > 0)) {
                active[key] = value;
            }
        });
        pending = JSON.stringify(active);
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(flush, 1000);
    });
    window.addEventListener('pagehide', flush);
});
JS;
        $page->requires->js_amd_inline(str_replace(['__USERID__', '__PREF__'], [(string) $userid, self::PREFERENCE], $js));
    }

    /**
     * Permission check for the preference: users can only change their own.
     *
     * @param \stdClass $user User whose preference is being changed.
     * @return bool
     */
    public static function can_edit(\stdClass $user): bool {
        global $USER;
        if (!isloggedin() || isguestuser() || \core\session\manager::is_loggedinas()) {
            return false;
        }
        return (int) $user->id === (int) $USER->id;
    }
}
