# Security policy

## Reporting a vulnerability

If you find a security issue in `local_oksigeniaaccess`, **do not open a
public GitHub issue**. Use one of these instead:

1. **GitHub private vulnerability reporting** (preferred):
   <https://github.com/OksigeniaSL/moodle-local_oksigeniaaccess/security/advisories/new>
   This sends the report straight to the maintainer with no public exposure.

2. **Email**: `dev@oksigenia.cc` (PGP key
   [fingerprint `4D0E 67BD 1935 3CE2 A8E8  267F 8290 9111 546B AD97`](https://sponsor.oksigenia.com),
   public key on [oksigenia.com](https://oksigenia.com/wp-content/uploads/2026/02/contacto_publickey.asc)).

Please include:

- Affected version(s) of the plugin.
- Moodle version, PHP version, theme.
- A minimal proof of concept or reproduction steps.
- Your assessment of impact and any suggested mitigation.

## Response timeline

| Step | Target |
|---|---|
| Acknowledgement of the report | Within 5 business days |
| Initial assessment + severity rating | Within 10 business days |
| Patched release | Depends on severity; critical issues get out-of-band releases |

If the vulnerability affects the bundled web component
[`@oksigenia/access-panel`](https://github.com/OksigeniaSL/oksigenia-web-libs)
rather than the Moodle plugin shell itself, the fix lands upstream first and
this plugin re-vendors the patched bundle in a follow-up release.

## Supported versions

Security patches land on the latest released line. Older minor versions
are not back-patched.

| Plugin version | Status |
|---|---|
| `0.3.x` | ✅ Supported |
| `< 0.3` | ❌ Unsupported — upgrade |

For supported Moodle versions, see `version.php` and the GitHub Actions matrix
in `.github/workflows/moodle-ci.yml`. The plugin requires Moodle 4.5 LTS or
later and is tested against 4.5 LTS / 5.0 / 5.1 / 5.2.

## Scope

This policy covers code shipped in this repository:

- The `local_oksigeniaaccess` plugin shell (PHP).
- The vendored `js/web-component.js` bundle (upstream
  [`@oksigenia/access-panel`](https://www.npmjs.com/package/@oksigenia/access-panel)).

It does **not** cover Moodle core itself. For Moodle core security issues,
follow the
[official Moodle security process](https://docs.moodle.org/en/Reporting_security_issues).

## Coordinated disclosure

We follow responsible disclosure. Once a fix is released we publish a
GitHub Security Advisory with credit to the reporter (unless the reporter
prefers to remain anonymous), CVE if applicable, and details of the
mitigation.

## Out of scope

The following are not considered security issues for this plugin:

- Configuration mistakes by the site administrator (e.g. capability
  overrides that grant the panel to roles you did not intend).
- Visual collisions with site-specific themes or other third-party
  plugins (file as a bug, not a vulnerability).
- The trigger button being covered by another floating widget — use the
  `trigger_zindex` setting.
