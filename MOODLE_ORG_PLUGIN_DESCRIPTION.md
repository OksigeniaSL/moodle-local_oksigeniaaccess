<p>Oksigenia Access adds a small floating button to every Moodle page. The visitor clicks it and gets 17 real controls to adapt the site to their needs: text size (4 levels), line height, alignment, readable font, dyslexia font, letter spacing, high contrast, grayscale, hide images, highlight links, color-blind filters (3 types), reading guide, reading mask, big cursor, big targets, pause animations, and focus outlines. Four profile presets (Low Vision, Dyslexia, Motor, No Distractions) apply a sensible bundle of those controls in one click, and the visitor can fine-tune from there.</p>
<p>Preferences live in the visitor's localStorage only. Nothing is sent to your server. No cookies, no telemetry, no external CDNs, no account required.</p>
<h3>Scope</h3>
<p>The panel gives visitors a familiar, predictable set of adaptation controls. WCAG / EAA 2025 / EU Directive 2016/2102 / Spanish RD 1112/2018 compliance is achieved with editorial work on your courses: alt text, transcripts, contrast, semantic HTML, labelled forms, keyboard navigation.</p>
<h3>Theme-agnostic</h3>
<p>The panel renders inside a Shadow DOM, so its CSS doesn't collide with Boost, Boost Union, Classic, or any custom theme. The only thing it injects into <code>document.head</code> is a single scoped <code>&lt;style id="oksigenia-access-effects"&gt;</code> for body-level effects (zoom, contrast, dyslexia font…).</p>
<h3>Configuration</h3>
<p>The settings page under <em>Site administration → Plugins → Local plugins → Oksigenia Access</em> gives you:</p>
<ul>
<li>Master enable toggle.</li>
<li>Scope: all pages, or all pages except login/signup.</li>
<li>Hide on admin pages toggle (recommended on).</li>
<li>Excluded course IDs (CSV).</li>
<li>Trigger z-index, position (desktop and mobile, 6 anchors each), and icon (Vitruvian, Wheelchair, Eye, Universal Access).</li>
<li>Five appearance fields (button size + idle/hover background + idle/hover icon color) for matching your Moodle theme.</li>
<li>Locale source: auto-follow Moodle's current language, or force a specific locale.</li>
</ul>
<p>Visibility is gated by the capability <code>local/oksigeniaaccess:view</code>, permissive by default for every archetype. Override it from <em>Site administration → Users → Permissions → Define roles</em> if you want to restrict the panel to specific roles.</p>
<h3>Eight locales</h3>
<p>Spanish, English, Guaraní, French, Italian, German, Dutch and Swedish out of the box. Regional variants (es-PY, pt-BR…) normalize to their base language with English as a final fallback.</p>
<h3>Three distributions of the same engine</h3>
<p>The accessibility panel ships from a shared web component (<code>@oksigenia/access-panel</code>, MIT) so the WordPress plugin (<code>oksigenia-access</code>, GPLv2+), this Moodle plugin (GPLv3+) and any modern site that imports the npm package all share the same UI and locales. Whatever you fix or improve in one variant tends to land in the others.</p>
<h3>Sponsorship</h3>
<p>The plugin is FOSS and stays FOSS. If your institution depends on it for accessibility, sponsor its development at <a href="https://sponsor.oksigenia.com">sponsor.oksigenia.com</a>. Sponsorship gets you logo placement, priority issue triage and weight in the public roadmap.</p>
<h3>Accessibility evaluation service</h3>
<p>Optional one-off service for institutions that want a technical reading of their Moodle's accessibility status: automated checks (axe-core, Lighthouse, WAVE), manual review of the typical pain points (text alternatives, heading structure, contrast, keyboard navigation, forms), and a written report with prioritised findings and a concrete remediation plan. The service covers the technical operational layer; formal accreditation for inspection dossiers under EAA 2025 / RD 1112/2018 is handled separately by ENAC-accredited bodies.</p>
<p>Details at <a href="https://sponsor.oksigenia.com">sponsor.oksigenia.com</a>.</p>
<h3>Requirements</h3>
<ul>
<li>Moodle 4.5 LTS or later (uses the Hook API stabilized in 4.5).</li>
<li>PHP 8.1+.</li>
<li>Any modern browser with Custom Elements v1 support (all current ones).</li>
</ul>
<h3>License</h3>
<p>Plugin code: GPL v3 or later. Bundled web component under <code>js/web-component.js</code>: MIT (see <code>LICENSE.web-component.MIT</code>).</p>
