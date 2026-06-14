# Changelog

All notable changes to this plugin will be documented here.
Format loosely based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

## [0.4.6] - 2026-06-14

### Accessibility
- Re-vendors [`@oksigenia/access-panel@0.4.4`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.4.4):
  - Multi-step controls (text size, line height, alignment, letter spacing, color-blind) now announce their current level to screen readers via a localized aria-label ("Size, level 2 of 4") instead of only an on/off state.
  - The panel's own transitions and hover transforms are disabled under `prefers-reduced-motion`.

## [0.4.5] - 2026-06-10

### Changed
- The compliance notice on the settings page (`disclaimer_html`, en/es) is now purely informative: it describes what the panel does and what real compliance work involves, without promoting external services in-app — in line with the Moodle Marketplace Provider Terms (clause 2.3). The accessibility evaluation service remains documented in the README and the plugin directory listing.
- Updated control counts everywhere: the notice and the directory description said "15 controls"; since 0.4.0 the panel ships 17 atomic controls plus 4 profile presets.

## [0.4.4] - 2026-06-10

### Fixed
- Re-vendors [`@oksigenia/access-panel@0.4.3`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.4.3) with two fixes:
  - **Body class cleanup**: the panel cleans its `oks-*` classes off `<body>` token by token via `classList`. The previous regex split two-hyphen classes (`oks-a11y-font` → a stray `-font` token), leaving junk piling up on the body `class` attribute with every click while such an effect was active.
  - **Focus trap covers the footer link**: the branding link is now part of the Tab cycle inside the open panel. Before, the trap only cycled `button` elements, so keyboard users could never reach the link — and if it got focus by pointer, Tab escaped the panel.

## [0.4.3] - 2026-06-07

### Added
- `thirdpartylibs.xml` documenting the bundled `@oksigenia/access-panel` web component (`js/web-component.js`, MIT), as required by the Moodle plugins directory review (CONTRIB-10542). No functional change to the plugin or the bundled component.

## [0.4.2] - 2026-06-05

### Fixed
- **`aria-hidden-focus` (accessibility)**: re-vendors [`@oksigenia/access-panel@0.4.2`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.4.2). While closed, the panel kept `aria-hidden="true"` but still held focusable controls — axe and Lighthouse flag this as `aria-hidden-focus` (serious), since a keyboard or screen-reader user could reach controls inside something hidden from assistive tech, and it contradicted `aria-modal`. The closed state now uses the `inert` attribute instead, removing the panel from both the tab order and the accessibility tree. No change when the panel is open; the focus trap, Escape-to-close and focus return were already in place.

## [0.4.0] - 2026-05-25

### Added
- **Reading Mask** (Orientation): re-vendors [`@oksigenia/access-panel@0.4.0`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.4.0). A dark overlay with a lit reading band that follows the cursor — more restrictive than the existing Reading Guide when the surroundings are visually noisy. Implemented with `clip-path` and a CSS variable updated on `mousemove` / `touchmove`.
- **Big Targets** (Orientation): bumps interactive hit-areas (links, buttons, form controls) to 44×44 minimum (WCAG 2.5.5 / 2.5.8). Adjusts `padding` and `min-*` only, never `display`, so host themes that rely on inline flow or grid placement keep working.
- **4 profile presets** at the top of the panel: Low Vision, Dyslexia, Motor, No Distractions. Each one applies a bundle of related toggles in one click. Additive — pressing several unions their flags. A 250 ms flash gives click feedback without a persistent "active preset" state, because users can adjust individual toggles afterwards and a sticky indicator would lie about the current configuration.

### Fixed
- **Shadow DOM event-target bug**: the document-level "click outside the panel" handler used `panel.contains(e.target)`, which returns false for any click inside the Shadow DOM because the target is retargeted to the host element when the event crosses the shadow boundary. The panel would close on its own button clicks under certain timings. Replaced with `e.composedPath()`, which is shadow-aware.

### Notes
- 17 atomic controls + 4 presets. 7 new translation keys (mask, targets, presets, pLow, pDys, pMot, pCalm) across the 8 locales bundled in the web component.
- No plugin shell changes, no new admin settings, no `db/upgrade.php` migration needed (the bundle change is the entire delta).

## [0.3.5] - 2026-05-21

### Fixed
- **Mobile panel anchored off-screen**: re-vendors [`@oksigenia/access-panel@0.3.8`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.3.8). The bundled web component injected dynamic position rules (`top: 50%; left: 90px; transform: translateY(-50%)` for `mid-left`, etc.) **after** the mobile `@media (max-width: 768px)` block that puts the panel fullscreen. Same specificity, later in the stylesheet, so on mobile the dynamic rules overrode `top`/`left`/`transform` and the panel ended up `width: 100%` anchored at `left: 90px` — clipping its right side by 90 px on narrow viewports. Upstream wraps the panel position rules in `@media (min-width: 769px)` so they only apply on desktop.

### Changed
- **"Big cursor" option hidden on touch devices**: `[data-class="oks-big-cursor"] { display: none }` inside `(max-width: 768px)`. The option is useless without a mouse and was eating one grid row on every phone. The orientation section's last option (`oks-a11y-focus`) spans both columns so the grid stays even.
- **Compact mobile layout**: option `min-height` 88 → 72 px (still above WCAG 2.5.5's 44×44 minimum), tighter paddings and icons. All 14 controls now fit a typical mobile screen (~640–844 px) without scrolling.

No plugin shell changes, no new settings.

## [0.3.4] - 2026-05-18

### Fixed
- **Text-size levels (1-4) blew up the layout exponentially**: re-vendors [`@oksigenia/access-panel@0.3.3`](https://www.npmjs.com/package/@oksigenia/access-panel/v/0.3.3). The previous `oks-zoom-*` rules in the bundled web component applied `font-size: 1.20em !important` to every descendant of `<body>` via the universal selector. Since `em` is parent-relative, the factor compounded at each nesting level — a heading three levels deep ended up at `1.20³ = 1.73×` its intended size, which blew up the layout at level 3 and made the page unusable at level 4. New rules target `<body>` only with percentage values (10 / 20 / 35 / 50%), so `em`/`rem` descendants scale exactly once.

No plugin shell changes, no new settings.

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
