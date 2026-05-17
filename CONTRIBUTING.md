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

When the plugin is approved on **moodle.org/plugins** (planned once it has
2–3 months of real use, see roadmap below) translations will additionally be
picked up by **AMOS**, Moodle's translation tooling, automatically. Until
then, GitHub PRs are the canonical way.

## Tests

Local validation runs through `moodle-plugin-ci` on a docker stack — see
the project's internal docs. CI on GitHub Actions will be added when we
publish on moodle.org. Until then, please run at minimum:

```bash
docker exec moodle-app php -l <changed_file.php>
```

for syntax checks. Behat scenarios under `tests/behat/` (when present) must
all pass.

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

- **v0.x (alpha)** — feature parity with the WordPress and npm variants of
  Oksigenia Access. Dogfooded on `campus.oksigenia.com`.
- **v1.0** — submission to `moodle.org/plugins`. Gate: 2–3 months of real
  use, at least one tagged release with zero critical open issues, validation
  against Moodle 4.5 LTS / 5.0 / 5.1 / 5.2 via `moodle-plugin-ci`.
- Post-1.0 — feature requests prioritised by sponsors (see
  <https://sponsor.oksigenia.com>).

## License

By contributing you agree your changes are licensed under GPL v3 or later,
the same license as the plugin.
