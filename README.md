# Oksigenia Access for Moodle

[![Moodle Plugin CI](https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess/actions/workflows/moodle-ci.yml/badge.svg)](https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess/actions/workflows/moodle-ci.yml)
[![License: GPLv3](https://img.shields.io/badge/license-GPLv3+-blue.svg)](LICENSE)
![Moodle](https://img.shields.io/badge/Moodle-4.5%20LTS%20%7C%205.x-orange)
![Status](https://img.shields.io/badge/status-alpha-yellow)
[![Bundled web component](https://img.shields.io/npm/v/@oksigenia/access-panel?label=%40oksigenia%2Faccess-panel&color=6d4aff)](https://www.npmjs.com/package/@oksigenia/access-panel)
[![Sponsor](https://img.shields.io/badge/sponsor-Oksigenia-00d4ff)](https://sponsor.oksigenia.com)
[![Roadmap](https://img.shields.io/badge/roadmap-public-00f5d4)](https://github.com/orgs/OksigeniaSL/projects/4)

A privacy-first accessibility panel for Moodle. Floating button with 15 user-side
controls — text size, line height, dyslexia font, contrast, colorblind filters,
reading guide, big cursor, pause animations and more. 8 locales including Guaraní.

Local plugin (`local_oksigeniaaccess`) — works with any theme. Powered by the
[`@oksigenia/access-panel`](https://www.npmjs.com/package/@oksigenia/access-panel)
web component (MIT), bundled inside the plugin so the installation is fully
self-contained: no Node, no build step, no CDN.

## What this is and isn't

This panel does **not** "fix" your Moodle automatically. There is no auto-rewrite
of alt text, no opaque overlay claiming WCAG compliance. It gives the visitor 15
real controls to adapt the page to their needs, and persists their choice in
their own browser. Real a11y still requires real work on your content.

The same product also ships as:
- a [WordPress plugin](https://wordpress.org/plugins/oksigenia-access/) (GPLv2+);
- a [framework-agnostic web component on npm](https://www.npmjs.com/package/@oksigenia/access-panel) (MIT).

## Requirements

- Moodle 4.5 LTS or later (uses the Hook API introduced in 4.4 and stabilised in 4.5).
- PHP 8.1+ (whatever your Moodle requires).
- Any theme. The panel renders inside Shadow DOM and only injects a single
  scoped `<style id="oksigenia-access-effects">` into the document head for the
  body-level effects (zoom, contrast, etc.). It will not collide with your theme CSS.

## Install

### From ZIP

1. Download the latest release ZIP from the Releases page.
2. In Moodle: *Site administration → Plugins → Install plugins → Choose file* and pick the ZIP.
3. Confirm install. Moodle runs the upgrade automatically (no DB tables created — this plugin only stores settings).

### From Git

```bash
cd /path/to/moodle/public/local/
git clone https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess.git oksigeniaaccess
```

Then visit *Site administration → Notifications* in Moodle to finish the install.

## Configuration

*Site administration → Plugins → Local plugins → Oksigenia Access*

| Setting | Default | Notes |
|---|---|---|
| Enable accessibility panel | On | Master toggle. |
| Page scope | All pages | Or "All pages except login/signup". |
| Hide on admin pages | On | Skips injection on URLs under `/admin/`. Admins use their own a11y tooling. |
| Excluded course IDs | *(empty)* | Comma- or space-separated list of course IDs to skip, e.g. `12, 34, 78`. |
| Trigger z-index | *(empty)* | Empty = `9999999` (web component default). Raise it if another floating widget covers the trigger. Backed by the web component's `--oks-z` CSS variable since v0.3.0 (deterministic across browsers). |
| Button size | *(empty)* | CSS length with unit (e.g. `60px`). Empty = `55px` default. |
| Idle background | *(empty)* | Color of the trigger button at rest. Empty = `#000` default. |
| Idle icon color | *(empty)* | Color of the icon at rest. Empty = `#fff` default. |
| Hover background | *(empty)* | Color of the trigger button on hover. Empty = `#fff` default. |
| Hover icon color | *(empty)* | Color of the icon on hover. Empty = `#000` default. |
| Trigger position (desktop) | Middle left | 6 positions. |
| Trigger position (mobile) | Inherit | Optional override for ≤768 px viewports. |
| Trigger icon | Vitruvian man | 4 icons (Vitruvian, Wheelchair, Eye, Universal access). |
| Locale source | Auto | Auto follows Moodle's current language; Force lets you pin one. |
| Forced locale | Spanish | Only used when Locale source = Force. |

The panel UI itself is in 8 locales: `es`, `en`, `gn` (Guaraní), `fr`, `it`,
`de`, `nl`, `sv`. Regional variants like `es-PY` or `pt-BR` are normalised to
the base language (and fall back to English if unsupported).

### Role-based visibility

Visibility of the panel is gated by the capability
`local/oksigeniaaccess:view`. Default policy is permissive — every role
(`guest`, `user`, `student`, `teacher`, `editingteacher`, `coursecreator`,
`manager`) sees the panel. To restrict it (for example, hide the panel from
`guest`, or only show it to a specific cohort), override the capability under
*Site administration → Users → Permissions → Define roles*.

## Privacy

The plugin does not store or transmit any personal data. Visitor preferences
for the panel (which controls are on, at what level) are persisted in their
browser's `localStorage` under the `oksiacSettings` key and never reach the
server. The plugin does not phone home and does not load anything from CDNs
or third-party origins — the web component bundle is vendored under
`js/web-component.js` and served from your Moodle.

**Cookie banners and consent**: storing user preferences in `localStorage`
for the very feature the user is asking for ("make this page readable for
me") falls under "strictly necessary" processing per ePrivacy / GDPR
guidance from European data-protection authorities. No consent banner is
required for the plugin itself. If your Moodle uses a cookie-management
plugin, you can safely leave Oksigenia Access outside of it.

A formal Moodle Privacy provider statement is implemented under
`classes/privacy/provider.php` (`null_provider` — no personal data
collected). It shows up at *Site administration → Users → Privacy and
policies → Data registry* and is what auditors typically check.

## Limitations

- **Moodle Mobile App**: the official Ionic-based mobile app does not use
  the theme web layer — it renders natively. The panel is therefore not
  available inside the app. Visitors who need accessibility adjustments on
  mobile should rely on the operating-system-level tools (iOS
  Accessibility, Android Accessibility Suite, GrapheneOS hardening, etc.).
- **Custom themes that disable footer hooks**: the plugin attaches to
  `\core\hook\output\before_footer_html_generation`. A theme that bypasses
  the standard footer pipeline may also bypass this hook. Stick to themes
  that respect Moodle's rendering contract (Boost, Boost Union and most
  community themes do).
- **Z-index conflicts**: see the *Trigger z-index* setting. Some plugins
  use very high z-indexes; raise the value if the trigger gets covered.

## Theming the trigger button

The trigger button colors are exposed as CSS custom properties on the host
element. Add a custom CSS rule from your theme:

```css
oksigenia-access-panel {
  --oks-btn-size: 60px;    /* default 55px */
  --oks-bg:       #be5d38; /* idle bg      */
  --oks-icon:     #ffffff; /* idle icon    */
  --oks-h-bg:     #ffffff; /* hover bg     */
  --oks-h-icon:   #be5d38; /* hover icon   */
}
```

The panel internals (cards, levels, contrast modes) are intentionally locked to
neutral greys/blacks. The panel is a tool the user expects to recognise across
sites, not a branded surface.

## License

GPL v3 or later for the plugin code itself.

The bundled web component under `js/web-component.js` is MIT-licensed; see
`LICENSE.web-component.MIT` and upstream at
<https://github.com/OksigeniaSL/oksigenia-web-libs>.

## Sponsorship & professional audit

This plugin is FOSS and will stay FOSS without crippleware. If your
institution relies on it for accessibility compliance (EAA 2025, EU
Directive 2016/2102, Spanish RD 1112/2018, etc.), consider sponsoring its
development at <https://sponsor.oksigenia.com>.

### What sponsorship gets you

- Logo and link in the README and on `sponsor.oksigenia.com`.
- Priority in issue triage.
- Weight in the roadmap (the plugin stays general, but feature requests
  from sponsors are evaluated first).
- (Gold tier) a semi-annual 1:1 with the maintainer.

### Technical accessibility evaluation (separate, contractable)

For Moodle installations that want a first technical screening of their
accessibility status, we offer a one-off evaluation: automated checks
(axe-core, Lighthouse, WAVE) plus manual review of the typical pain points
(text alternatives, heading structure, contrast, keyboard navigation,
forms), and a written report with findings prioritised by impact and a
concrete remediation plan. Delivered as PDF signed by Oksigenia SL.

This service covers the technical operational layer: detect,
prioritise, remediate. Formal accreditation for inspection dossiers
under EAA 2025 / RD 1112/2018 is handled separately by ENAC-accredited
bodies.

See the sponsor page for details.

### What this plugin does NOT do

The panel is a user adaptation tool. WCAG / EAA compliance is achieved
with editorial work on your courses: alt text on images, video
transcripts, correct semantics, keyboard navigability, color contrast,
labelled forms.

## Support and contributions

- **Bugs and features**: [Issues](https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess/issues/new/choose) with templates for bug reports and feature requests.
- **How-to questions, theming help, general feedback**: [Discussions](https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess/discussions).
- **Security vulnerabilities**: report privately — see [`SECURITY.md`](SECURITY.md).
- **Roadmap**: public board at [github.com/orgs/OksigeniaSL/projects/4](https://github.com/orgs/OksigeniaSL/projects/4). Sponsors influence the order; see the project readme for how.
- **Code contributions**: read [`CONTRIBUTING.md`](CONTRIBUTING.md) for code style, translation policy and PR conventions. The CI workflow at [`.github/workflows/moodle-ci.yml`](.github/workflows/moodle-ci.yml) runs `moodle-plugin-ci` across Moodle 4.5 LTS / 5.0 / 5.1 / 5.2 on every push and PR, so contributors get the same feedback as the maintainer.
- **Code of Conduct**: [`CODE_OF_CONDUCT.md`](CODE_OF_CONDUCT.md) (Contributor Covenant 2.1).

## Credits

Developed by [Oksigenia SL](https://oksigenia.com).
