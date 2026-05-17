# Oksigenia Access for Moodle

[![License: GPLv3](https://img.shields.io/badge/license-GPLv3+-blue.svg)](LICENSE)
![Moodle](https://img.shields.io/badge/Moodle-4.5%20LTS%20%7C%205.x-orange)
![Status](https://img.shields.io/badge/status-alpha-yellow)

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
| Show on | All pages | Or "All pages except login/signup". |
| Trigger position (desktop) | Middle left | 6 positions. |
| Trigger position (mobile) | Inherit | Optional override for ≤768 px viewports. |
| Trigger icon | Vitruvian man | 4 icons (Vitruvian, Wheelchair, Eye, Universal access). |
| Locale source | Auto | Auto follows Moodle's current language; Force lets you pin one. |
| Forced locale | Spanish | Only used when Locale source = Force. |

The panel UI itself is in 8 locales: `es`, `en`, `gn` (Guaraní), `fr`, `it`,
`de`, `nl`, `sv`. Regional variants like `es-PY` or `pt-BR` are normalised to
the base language (and fall back to English if unsupported).

## Privacy

The plugin does not store or transmit any personal data. Visitor preferences
for the panel (which controls are on, at what level) are persisted in their
browser's `localStorage` under the `oksiacSettings` key and never reach the
server. The plugin does not phone home and does not load anything from CDNs
or third-party origins — the web component bundle is vendored under
`js/web-component.js` and served from your Moodle.

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

## Sponsorship

This plugin is FOSS and will stay FOSS without crippleware. If your institution
relies on it for accessibility compliance (EAA 2025, EU Directive 2016/2102,
Spanish RD 1112/2018, etc.), consider sponsoring its development:
<https://oksigenia.com/sponsor>.

A separate, contractable service is available for institutions that need a
signed accessibility audit and certificate for their Moodle (one-off, not a
subscription) — see the sponsor page for details.

## Support and contributions

Issues and PRs welcome at the
[GitHub repo](https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess).
Please open an issue before sending a PR for non-trivial changes.

## Credits

Developed by [Oksigenia SL](https://oksigenia.com).
