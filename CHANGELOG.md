# Changelog

All notable changes to this plugin will be documented here.
Format loosely based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

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
