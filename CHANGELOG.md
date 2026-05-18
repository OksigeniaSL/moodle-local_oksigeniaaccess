# Changelog

All notable changes to this plugin will be documented here.
Format loosely based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

## [0.3.3] - 2026-05-18

### Fixed
- **Reading Guide + High Contrast collision**: re-vendors [`@oksigenia/access-panel@0.3.1`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.3.1), which fixes a bug where the reading guide painted a solid black band over the text when High Contrast was also active. The wildcard `body.oks-a11y-contrast *` selector in the web component was catching `.oks-reading-guide` and overriding its translucent yellow with opaque black. Upstream fix preserves the overlay's intended look in high-contrast mode.

No other functional changes in the plugin shell. Existing settings are preserved on upgrade.

## [0.3.2] - 2026-05-18

### Added
- **GitHub Actions CI** (`.github/workflows/moodle-ci.yml`) running `moodle-plugin-ci` on every push and PR across the four currently supported Moodle branches: 4.5 LTS, 5.0, 5.1, 5.2. Pairs each branch with the matching PHP and Node version. Steps: validate, phplint, phpmd, codechecker, phpdoc, savepoints, mustache, grunt. No PHPUnit/Behat yet (the plugin has no tests of its own).

### Fixed
- **Lang files**: keys reordered alphabetically as required by Moodle's `LangFilesOrdering` sniff. Comments between strings removed; logical grouping is documented in the settings page via `admin_setting_heading` entries instead.
- **Missing docblocks** added to the `provider` class and four methods of `hook_callbacks` (`should_skip_for_scope`, `should_skip_for_admin`, `should_skip_for_course`, `resolve_locale`) flagged by `moodle.Commenting.MissingDocblock`.
- **Empty line after class opening brace** removed in `provider.php` and `hook_callbacks.php` per `PSR12.Classes.OpeningBraceSpace`.
- **PHPDoc generic-array syntax** (`array<string,string>`) replaced with plain `array` so Moodle's PHPDoc Checker counts parameters correctly. Description in the docblock retains the structure information.
- Copyright header in `version.php` aligned with the `OksigeniaSL/*` convention (`Oksigenia <dev@oksigenia.cc>`).

### Validated
- `moodle-plugin-ci install + validate + phplint + phpmd + codechecker + phpdoc + savepoints + mustache + grunt` PASS on **MOODLE_405_STABLE**, **MOODLE_500_STABLE**, **MOODLE_501_STABLE** and **MOODLE_502_STABLE** via the local docker runner on the Oksigenia VPS.

## [0.3.1] - 2026-05-18

### Changed
- `Trigger z-index` accepts an empty value to mean "use the web component's built-in default" (matches the behaviour of the other Trigger appearance fields added in v0.3.0). Previously typed as `PARAM_INT`, which forced `0` for "no override" — confusing UX. The setting is now `PARAM_RAW_TRIMMED` and the PHP hook validates with `ctype_digit` before injecting `--oks-z`.

## [0.3.0] - 2026-05-18

### Added
- **Trigger appearance settings** — five new fields under *Visibility & scope → Trigger appearance*: button size, idle background, idle icon color, hover background and hover icon color. All are optional; leaving a field empty falls back to the bundled web component default. Colors use Moodle's native `admin_setting_configcolourpicker`; size accepts any CSS length with unit.
- Backed by [`@oksigenia/access-panel@0.3.0`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.3.0), bundled fresh under `js/web-component.js`. The new upstream exposes `--oks-z` as a CSS custom property, which makes the **Trigger z-index** setting deterministic across browsers (previously it relied on stacking-context inheritance through the Shadow DOM and was best-effort).

### Changed
- `Trigger z-index` default raised from `99999` to `9999999` to match the web component's internal default. Existing custom values are kept; only fresh installs get the new default.
- Hook callback rewrites the inline `<style>` from a single `z-index` rule to a multi-property block on the host element. Values are sanitised in PHP (hex / rgb / hsl / named for colors; CSS length with unit for size) — defence in depth on top of Moodle's own settings validation.

### Upstream
- This release pairs with `@oksigenia/access-panel@0.3.0` (npm). The web component change is a pure addition (`--oks-z` defaults to `9999999`, matching prior behaviour) and is fully compatible with previous consumers.

## [0.2.0] - 2026-05-18

### Added
- **Capability `local/oksigeniaaccess:view`** (`db/access.php`) for role-based visibility. Default policy is permissive — every archetype is allowed; sites that want to restrict the panel can override the capability from *Site administration → Users → Permissions → Define roles*.
- **Setting "Hide on admin pages"** (default ON): the panel is no longer injected into URLs under `/admin/`. Admins use their own accessibility tooling and the panel was overlapping settings UI.
- **Setting "Excluded course IDs"**: comma- or space-separated list of course IDs where the panel should NOT be injected. Useful for courses with their own a11y scaffolding or third-party tooling.
- **Setting "Trigger z-index"** (default 99999): configurable CSS z-index for the floating trigger, applied via an inline `<style>` on the host custom element. Raise it if the trigger gets covered by another floating widget (theme scrolltop, chat bubble, cookie banner, etc.).
- **Compliance disclaimer** rendered at the top of the settings page making it explicit that this plugin does not audit or auto-fix Moodle content — WCAG / EAA / Directive (EU) 2016/2102 / RD 1112/2018 compliance requires editorial work on courses. Mention of the separate professional audit + certificate service at <https://sponsor.oksigenia.com>.
- **Formal privacy provider class** (`classes/privacy/provider.php`) implementing `\core_privacy\local\metadata\null_provider`, in addition to the existing `privacy:metadata` string.
- **CONTRIBUTING.md** documenting code style, translation policy (GitHub PRs now, AMOS once approved on moodle.org/plugins), tests and roadmap.
- README sections: *Privacy*, *Limitations* (incl. Moodle Mobile App), *Sponsorship & Audit*.

### Changed
- Settings page reorganised: new "Visibility & scope" group containing scope, hide-on-admin, excluded course IDs and trigger z-index. Removes the previous flat structure.
- Copyright lines updated to `Oksigenia <dev@oksigenia.cc>` per the canonical convention for `OksigeniaSL/*` repositories.

## [0.1.0] - 2026-05-17

### Added
- Initial alpha release of `local_oksigeniaaccess`.
- Injects the `@oksigenia/access-panel` v0.2.0 web component (bundled under `js/web-component.js`) into every Moodle page via the `before_footer_html_generation` hook.
- Admin settings page under *Site administration → Plugins → Local plugins → Oksigenia Access*: enabled toggle, scope (all pages / exclude login), desktop and mobile position, trigger icon, locale source (auto/force) and forced locale.
- Locale auto-mode follows Moodle's `current_language()` and normalises regional variants (`es_mx` → `es`) to the 8 locales supported by the web component (`es`, `en`, `gn`, `fr`, `it`, `de`, `nl`, `sv`), falling back to English.
- Privacy provider statement (no personal data stored or transmitted; visitor preferences live in browser `localStorage` only).
- English and Spanish language packs.

### Requirements
- Moodle 4.5 LTS or later.
