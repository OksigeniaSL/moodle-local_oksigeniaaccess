# Contributing to local_oksigeniaaccess

Thanks for taking the time. This plugin is FOSS and we want it to stay simple
and usable. Below are the few things to keep in mind before opening a PR.

## Code style

- PHP follows the Moodle Coding Style: <https://moodledev.io/general/development/policies/codingstyle>.
- License header: GPL v3 or later, copyright `Oksigenia <dev@oksigenia.cc>`.
- All identifiers, comments and commit messages in **English**. Lang files
  carry the localised strings; everything else stays in English.

## Translations

We accept new translations as pull requests. To add a locale:

1. Copy `lang/en/local_oksigeniaaccess.php` to `lang/<locale>/local_oksigeniaaccess.php`
   using a valid Moodle locale code (e.g. `ca`, `gl`, `eu`, `pt_br`, `de`).
2. Translate every `$string[...]` value, keeping the keys, the placeholders
   (`{$a->...}`, `<code>...</code>`, `<a href=...>...</a>`) and the HTML in the
   `disclaimer_html` string intact.
3. Open a PR with a single commit titled `Add <Language> translation`.

The plugin is on the [Moodle Marketplace](https://marketplace.moodle.com/plugins/local_oksigeniaaccess),
so translations into other languages go through **AMOS**, Moodle's translation
tool, at <https://lang.moodle.org>: they reach every Moodle site with the
language packs. GitHub PRs are for the English strings and for fixes.

## Tests

GitHub Actions runs `moodle-plugin-ci` on every push and pull request, on
every supported Moodle branch from 4.1 to 5.3 (plus `main` as an
allowed-failure job): validate, lint, code checker, PHPDoc, Mustache,
Grunt, PHPUnit and Behat. A PR is ready when that run is green. New
behaviour comes with its PHPUnit test, and a Behat scenario when it shows
in the browser.

## Pull requests

- One topic per PR. Mixed feature + refactor PRs get split before review.
- Reference an issue when one exists.
- Keep diffs small. Anything that touches the bundled web component (the
  vendored `js/web-component.js`) belongs upstream at
  <https://github.com/OksigeniaSL/oksigenia-web-libs> first, not here.

## Reporting bugs

Open an issue with: Moodle version, PHP version, theme, browser, and a
minimal reproduction. A screenshot of the floating panel state and the
browser console helps.

## Roadmap (high level)

- **v0.x** — feature parity with the WordPress and npm variants of
  Oksigenia Access, dogfooded on `campus.oksigenia.com`, published on the
  Moodle plugins directory.
- **v1.0 (stable, 2026-10-05)** — after months of real use, with zero
  critical open issues and `moodle-plugin-ci` (PHPUnit and Behat included)
  passing on Moodle 4.1 to 5.3.
- Post-1.0 — feature requests prioritised by sponsors (see
  <https://oksigenia.com/en/open-source#sponsor>).

## License

By contributing you agree your changes are licensed under GPL v3 or later,
the same license as the plugin.
