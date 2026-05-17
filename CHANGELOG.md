# Changelog

All notable changes to this plugin will be documented here.
Format loosely based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

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
