# Screenshots

PNGs used in the moodle.org/plugins listing carousel, in display order.

| # | File | What it shows | Why it's here |
|---|---|---|---|
| 1 | `01-panel-open.png` | Floating panel opened on a fresh Moodle dashboard. All three sections (Text, Visual, Orientation) visible, no controls active yet. | First-impression UI — "this is what your visitors get". |
| 2 | `02-high-contrast.png` | Full Moodle page rendered in High Contrast mode (yellow on black). Trigger sits at the left edge with the green active-state badge. | Shows that a single control transforms the whole site, end-to-end. The dramatic one. |
| 3 | `03-text-spacing.png` | Course page with Line Height and Letter Spacing controls active. The text reflows visibly: monospaced readable font + wider gaps. | Proves the controls actually mutate the page; not a fake overlay. |
| 4 | `04-highlight-links.png` | Course page with Highlight Links active. Anchor texts get a yellow background highlight. | Another control, another visible effect. Reinforces "real DOM/CSS changes". |
| 5 | `05-reading-guide.png` | Course page with the Reading Guide overlay active. | Extra; shows the orientation-axis tools (cursor guide, big cursor). |
| 6 | `06-admin-settings.png` | The plugin's Site administration settings page, full height. Compliance disclaimer at the top, then the five setting groups (General, Visibility & scope, Trigger appearance with the color pickers expanded, Appearance, Behaviour). | What the admin sees when configuring the plugin. |

## How to refresh

Take new screenshots from `campus.oksigenia.com` after a plugin upgrade if the panel UI changes (e.g. new control, redesigned trigger, settings reorganised). Match the naming convention above so the carousel order on moodle.org stays the same.

Target dimensions: 1100-1900 px wide, PNG, under 500 KB each. Crop or scale down before committing if larger.
