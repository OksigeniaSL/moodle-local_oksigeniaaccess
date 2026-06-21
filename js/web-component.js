// src/controls.ts
var ALL_CONTROLS = [
  "text-size",
  "line-height",
  "text-align",
  "readable-font",
  "dyslexia-font",
  "letter-spacing",
  "contrast",
  "grayscale",
  "hide-images",
  "highlight-links",
  "colorblind",
  "reading-guide",
  "reading-mask",
  "big-cursor",
  "big-targets",
  "pause-anim",
  "focus"
];
var CONTROL_STATE_KEY = {
  "text-size": "zoom",
  "line-height": "lh",
  "text-align": "align",
  "readable-font": "font",
  "dyslexia-font": "dyslexia",
  "letter-spacing": "ls",
  "contrast": "contrast",
  "grayscale": "grayOverlay",
  "hide-images": "hideImages",
  "highlight-links": "highlightLinks",
  "colorblind": "colorblind",
  "reading-guide": "readingGuide",
  "reading-mask": "readingMask",
  "big-cursor": "bigCursor",
  "big-targets": "bigTargets",
  "pause-anim": "pauseAnim",
  "focus": "focusOutline"
};
var STATE_KEY_CONTROL = Object.fromEntries(
  Object.entries(CONTROL_STATE_KEY).map(([control, key]) => [key, control])
);
var PRESETS = {
  lowvision: { zoom: 2, contrast: true, highlightLinks: true, bigCursor: true, focusOutline: true },
  dyslexia: { dyslexia: true, lh: 2, ls: 2, readingGuide: true },
  motor: { bigCursor: true, bigTargets: true, focusOutline: true },
  calm: { hideImages: true, pauseAnim: true }
};
var PRESET_IDS = ["lowvision", "dyslexia", "motor", "calm"];
function presetControlIds(id) {
  return Object.keys(PRESETS[id]).map((k) => STATE_KEY_CONTROL[k]);
}
function resolveEnabledControls(controlsAttr, excludeAttr) {
  const valid = new Set(ALL_CONTROLS);
  const parse = (raw) => (raw ?? "").split(",").map((s) => s.trim().toLowerCase()).filter((s) => valid.has(s));
  const whitelist = controlsAttr != null ? parse(controlsAttr) : null;
  let enabled = whitelist && whitelist.length > 0 ? new Set(whitelist) : new Set(ALL_CONTROLS);
  if (excludeAttr != null) {
    for (const id of parse(excludeAttr)) enabled.delete(id);
  }
  return enabled;
}
function filterPresetForEnabled(id, enabled) {
  const out = {};
  for (const [k, v] of Object.entries(PRESETS[id])) {
    if (enabled.has(STATE_KEY_CONTROL[k])) out[k] = v;
  }
  return out;
}
function presetIsAvailable(id, enabled) {
  return presetControlIds(id).filter((c) => enabled.has(c)).length >= 2;
}

// src/icons.ts
var ICON_TXT = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M2.5,4v3h5v12h3V7h5V4H2.5z M21.5,9h-9v3h3v7h3v-7h3V9z"/></svg>';
var ICON_LH = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6,7h2.5L5,3.5L1.5,7H4v10H1.5L5,20.5L8.5,17H6V7z M10,5v2h12V5H10z M10,19h12v-2H10V19z M10,13h12v-2H10V13z"/></svg>';
var ICON_ALIGN = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3,21h18v-2H3V21z M3,17h12v-2H3V17z M3,13h18v-2H3V13z M3,9h12V7H3V9z M3,3v2h18V3H3z"/></svg>';
var ICON_FONT = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9.93,13.5h4.14L12,7.98L9.93,13.5z M5,18l2.25-6h9.5L19,18h3L14.75,3h-5.5L2,18H5z"/></svg>';
var ICON_DYSLEXIA = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M5,18 L7.5,12 L16.5,12 L19,18 L22,18 L13.5,3 L10.5,3 L2,18 L5,18 Z M12,5.5 L15.5,10 L8.5,10 L12,5.5 Z"/></svg>';
var ICON_CONTRAST = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20V4c4.41,0,8,3.59,8,8 S16.41,20,12,20z"/></svg>';
var ICON_GRAY = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18L2 12C2 6.48 6.48 2 12 2v18z"/></svg>';
var ICON_HIDE = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75C21.27 10.61 17 7.5 12 7.5c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78 3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>';
var ICON_LINK = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>';
var ICON_GUIDE = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h18v-2H3v2zm-2 4h22v-2H1v2zM1 7v2h22V7H1z"/></svg>';
var ICON_CURSOR = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M5.5 3.21V20.8l4.51-4.52 2.13 5.2h2.29l-2.14-5.2H17L5.5 3.21z"/></svg>';
var ICON_PAUSE = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>';
var ICON_LS = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 5v14h2V5H5zm4 0v14h2V5H9zm4 4v6h2V9h-2zm4-4v14h2V5h-2z"/></svg>';
var ICON_COLORBLIND = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>';
var ICON_FOCUS = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 7V3h4v2H5v2H3zm14-4h4v4h-2V5h-2V3zm4 14v4h-4v-2h2v-2h2zM7 21H3v-4h2v2h2v2z"/></svg>';
var ICON_MASK = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M2 4h20v6H2zm0 10h20v6H2zm2-9v4h16V5zm0 10v4h16v-4z" opacity=".55"/><rect x="2" y="10" width="20" height="4"/></svg>';
var ICON_TARGETS = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h4v2H5v2H3zm14 0h4v4h-2V5h-2zm0 18v-2h2v-2h2v4zM3 21v-4h2v2h2v2zM12 8a4 4 0 100 8 4 4 0 000-8zm0 2a2 2 0 110 4 2 2 0 010-4z"/></svg>';
var UNIVERSAL_GLYPH = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/></svg>';
var TRIGGER_ICONS = {
  vitruvian: '<svg viewBox="0 0 122.88 122.88" fill="currentColor"><path d="M61.44,0A61.46,61.46,0,1,1,18,18,61.21,61.21,0,0,1,61.44,0Zm-.39,74.18L52.1,98.91a4.94,4.94,0,0,1-2.58,2.83A5,5,0,0,1,42.7,95.5l6.24-17.28a26.3,26.3,0,0,0,1.17-4,40.64,40.64,0,0,0,.54-4.18c.24-2.53.41-5.27.54-7.9s.22-5.18.29-7.29c.09-2.63-.62-2.8-2.73-3.3l-.44-.1-18-3.39A5,5,0,0,1,27.08,46a5,5,0,0,1,5.05-7.74l19.34,3.63c.77.07,1.52.16,2.31.25a57.64,57.64,0,0,0,7.18.53A81.13,81.13,0,0,0,69.9,42c.9-.1,1.75-.21,2.6-.29l18.25-3.42A5,5,0,0,1,94.5,39a5,5,0,0,1,1.3,7,5,5,0,0,1-3.21,2.09L75.15,51.37c-.58.13-1.1.22-1.56.29-1.82.31-2.72.47-2.61,3.06.08,1.89.31,4.15.61,6.51.35,2.77.81,5.71,1.29,8.4.31,1.77.6,3.19,1,4.55s.79,2.75,1.39,4.42l6.11,16.9a5,5,0,0,1-6.82,6.24,4.94,4.94,0,0,1-2.58-2.83L63,74.23,62,72.4l-1,1.78Zm.39-53.52a8.83,8.83,0,1,1-6.24,2.59,8.79,8.79,0,0,1,6.24-2.59Zm36.35,4.43a51.42,51.42,0,1,0,15,36.35,51.27,51.27,0,0,0-15-36.35Z"/></svg>',
  wheelchair: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13v-2c-1.54.02-3.09-.75-4.07-1.83l-1.29-1.43c-.17-.19-.38-.34-.61-.45-.01 0-.01-.01-.02-.01H13c-.35-.2-.75-.3-1.19-.26C10.76 7.11 10 8.04 10 9.09V15c0 1.1.9 2 2 2h5v5h2v-5.5c0-1.1-.9-2-2-2h-3v-3.45c1.29 1.07 3.25 1.94 5 1.95zm-6.17 5c-.41 1.16-1.52 2-2.83 2-1.66 0-3-1.34-3-3 0-1.31.84-2.41 2-2.83V12.1c-2.28.46-4 2.48-4 4.9 0 2.76 2.24 5 5 5 2.42 0 4.44-1.72 4.9-4h-2.07zM12 6c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg>',
  eye: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>',
  universal: UNIVERSAL_GLYPH,
  porthole: UNIVERSAL_GLYPH
};
var ICON_CLOSE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
var COLORBLIND_FILTERS_SVG = '<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden;" aria-hidden="true"><defs><filter id="oks-filter-protanopia"><feColorMatrix type="matrix" values="0.567 0.433 0 0 0  0.558 0.442 0 0 0  0 0.242 0.758 0 0  0 0 0 1 0"/></filter><filter id="oks-filter-deuteranopia"><feColorMatrix type="matrix" values="0.625 0.375 0 0 0  0.7 0.3 0 0 0  0 0.3 0.7 0 0  0 0 0 1 0"/></filter><filter id="oks-filter-tritanopia"><feColorMatrix type="matrix" values="0.95 0.05 0 0 0  0 0.433 0.567 0 0  0 0.475 0.525 0 0  0 0 0 1 0"/></filter></defs></svg>';

// src/render.ts
var PRESET_ICON = {
  lowvision: ICON_CONTRAST,
  dyslexia: ICON_DYSLEXIA,
  motor: ICON_CURSOR,
  calm: ICON_HIDE
};
function buildPanelHtml(opts) {
  const { t, triggerIcon } = opts;
  const enabled = opts.enabled ?? new Set(ALL_CONTROLS);
  const showTrigger = opts.showTrigger ?? true;
  const showPresets = opts.showPresets ?? true;
  const trig = TRIGGER_ICONS[triggerIcon];
  const multi = (id, prefix, levels, label, icon, full = false) => {
    if (!enabled.has(id)) return "";
    const action = id === "colorblind" ? "colorblind" : "multi";
    const fullClass = full ? " full-width" : "";
    const dots = Array.from({ length: levels }, () => "<span></span>").join("");
    return `<button class="oks-access-opt multi-step${fullClass}" data-control="${id}" data-action="${action}" data-prefix="${prefix}" data-levels="${levels}" aria-pressed="false" type="button"><span class="oks-icon">${icon}</span><span class="oks-label">${label}</span><div class="oks-levels">${dots}</div></button>`;
  };
  const toggle = (id, klass, label, icon) => {
    if (!enabled.has(id)) return "";
    return `<button class="oks-access-opt" data-control="${id}" data-action="toggle" data-class="${klass}" aria-pressed="false" type="button"><span class="oks-icon">${icon}</span><span class="oks-label">${label}</span></button>`;
  };
  const overlay = (id, target, label, icon) => {
    if (!enabled.has(id)) return "";
    return `<button class="oks-access-opt" data-control="${id}" data-action="overlay" data-target="${target}" aria-pressed="false" type="button"><span class="oks-icon">${icon}</span><span class="oks-label">${label}</span></button>`;
  };
  const simple = (id, action, label, icon) => {
    if (!enabled.has(id)) return "";
    return `<button class="oks-access-opt" data-control="${id}" data-action="${action}" aria-pressed="false" type="button"><span class="oks-icon">${icon}</span><span class="oks-label">${label}</span></button>`;
  };
  const preset = (id, label) => `<button class="oks-preset" data-action="preset" data-preset="${id}" type="button"><span class="oks-icon">${PRESET_ICON[id]}</span><span class="oks-label">${label}</span></button>`;
  const section = (title, rows) => {
    const kept = rows.filter(Boolean);
    if (kept.length === 0) return "";
    return `<h4 class="oks-access-title">${escapeHtml(title)}</h4><div class="oks-access-grid">${kept.join("")}</div>`;
  };
  const presetLabels = {
    lowvision: t.pLow,
    dyslexia: t.pDys,
    motor: t.pMot,
    calm: t.pCalm
  };
  const presetButtons = showPresets ? PRESET_IDS.filter((id) => presetIsAvailable(id, enabled)).map((id) => preset(id, presetLabels[id])) : [];
  const presetsBlock = presetButtons.length ? `<h4 class="oks-access-title">${escapeHtml(t.presets)}</h4><div class="oks-access-presets">${presetButtons.join("")}</div>` : "";
  const triggerBlock = showTrigger ? `
<div class="oks-access-wrapper" id="oks-wrapper" data-position="${opts.position}">
  <button class="oks-access-btn" id="oks-trigger" part="trigger" data-trigger-icon="${triggerIcon}" aria-label="${escapeAttr(t.title)}" aria-expanded="false" aria-controls="oks-panel" type="button">
    ${trig}
  </button>
  <span class="oks-active-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg></span>
</div>` : "";
  return `${triggerBlock}
<div class="oks-access-panel" id="oks-panel" role="dialog" aria-modal="true" aria-labelledby="oks-panel-title" inert>
  <div class="oks-access-header">
    <h3 id="oks-panel-title">${escapeHtml(t.title)}</h3>
    <button class="oks-access-close" id="oks-close" aria-label="${escapeAttr(t.close)}" type="button">${ICON_CLOSE}</button>
  </div>
  <div class="oks-access-content">
    ${presetsBlock}
    ${section(t.txt, [
    multi("text-size", "oks-zoom", 4, t.size, ICON_TXT),
    multi("line-height", "oks-lh", 3, t.lh, ICON_LH),
    multi("text-align", "oks-align", 3, t.align, ICON_ALIGN),
    toggle("readable-font", "oks-a11y-font", t.font, ICON_FONT),
    toggle("dyslexia-font", "oks-dyslexia", t.dyslexia, ICON_DYSLEXIA),
    multi("letter-spacing", "oks-ls", 3, t.ls, ICON_LS)
  ])}
    ${section(t.vis, [
    toggle("contrast", "oks-a11y-contrast", t.contrast, ICON_CONTRAST),
    overlay("grayscale", "oks-overlay-gray", t.gray, ICON_GRAY),
    toggle("hide-images", "oks-a11y-hide", t.hide, ICON_HIDE),
    toggle("highlight-links", "oks-a11y-links", t.links, ICON_LINK),
    multi("colorblind", "oks-colorblind", 3, t.cb, ICON_COLORBLIND, true)
  ])}
    ${section(t.ori, [
    simple("reading-guide", "guide", t.guide, ICON_GUIDE),
    simple("reading-mask", "mask", t.mask, ICON_MASK),
    toggle("big-cursor", "oks-big-cursor", t.cursor, ICON_CURSOR),
    toggle("big-targets", "oks-a11y-bigtargets", t.targets, ICON_TARGETS),
    toggle("pause-anim", "oks-a11y-pause", t.pause, ICON_PAUSE),
    toggle("focus", "oks-a11y-focus", t.focus, ICON_FOCUS)
  ])}
  </div>
  <div class="oks-access-footer">
    <button class="oks-access-reset" id="oks-reset" type="button">${escapeHtml(t.reset)}</button>
    <div class="oks-access-branding">${escapeHtml(t.dev)} <a href="https://oksigenia.com" target="_blank" rel="noopener noreferrer">Oksigenia</a></div>
  </div>
</div>
`;
}
function escapeHtml(s) {
  return s.replace(/[&<>"]/g, (c) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;"
  })[c] ?? c);
}
function escapeAttr(s) {
  return escapeHtml(s).replace(/'/g, "&#39;");
}
function positionRules(position) {
  switch (position) {
    case "top-left":
      return { wrap: "top: 20px; left: 20px;", panel: "top: 80px; left: 20px;" };
    case "top-center":
      return { wrap: "top: 20px; left: 50%; transform: translateX(-50%);", panel: "top: 80px; left: 50%; transform: translateX(-50%);" };
    case "top-right":
      return { wrap: "top: 20px; right: 20px;", panel: "top: 80px; right: 20px;" };
    case "mid-left":
      return { wrap: "top: 50%; left: 20px; transform: translateY(-50%);", panel: "top: 50%; left: 90px; transform: translateY(-50%);" };
    case "mid-center":
      return { wrap: "top: 50%; left: 50%; transform: translate(-50%, -50%);", panel: "top: 50%; left: 50%; transform: translate(-50%, -50%);" };
    case "mid-right":
      return { wrap: "top: 50%; right: 20px; transform: translateY(-50%);", panel: "top: 50%; right: 90px; transform: translateY(-50%);" };
    case "bottom-left":
      return { wrap: "bottom: 20px; left: 20px;", panel: "bottom: 100px; left: 20px;" };
    case "bottom-center":
      return { wrap: "bottom: 20px; left: 50%; transform: translateX(-50%);", panel: "bottom: 100px; left: 50%; transform: translateX(-50%);" };
    case "bottom-right":
      return { wrap: "bottom: 20px; right: 20px;", panel: "bottom: 100px; right: 20px;" };
  }
}
function positionCss(position, mobile) {
  const d = positionRules(position);
  let css = `.oks-access-wrapper { ${d.wrap} }`;
  css += `@media (min-width: 769px) { .oks-access-panel { ${d.panel} } }`;
  if (mobile && mobile !== position) {
    const m = positionRules(mobile);
    css += `@media (max-width: 768px) { .oks-access-wrapper { top: auto; right: auto; bottom: auto; left: auto; transform: none; ${m.wrap} } }`;
  }
  return css;
}

// src/state.ts
var DEFAULT_STATE = Object.freeze({
  zoom: 0,
  lh: 0,
  align: 0,
  ls: 0,
  colorblind: 0,
  font: false,
  dyslexia: false,
  contrast: false,
  hideImages: false,
  highlightLinks: false,
  bigCursor: false,
  pauseAnim: false,
  focusOutline: false,
  grayOverlay: false,
  readingGuide: false,
  readingMask: false,
  bigTargets: false
});
function loadState(key) {
  if (typeof localStorage === "undefined") return { ...DEFAULT_STATE };
  try {
    const raw = localStorage.getItem(key);
    if (!raw) return { ...DEFAULT_STATE };
    const parsed = JSON.parse(raw);
    if (!parsed || typeof parsed !== "object") return { ...DEFAULT_STATE };
    return { ...DEFAULT_STATE, ...parsed };
  } catch {
    return { ...DEFAULT_STATE };
  }
}
function saveState(key, state) {
  if (typeof localStorage === "undefined") return;
  try {
    const out = {};
    for (const [k, v] of Object.entries(state)) {
      if (typeof v === "number" && v > 0) out[k] = v;
      else if (typeof v === "boolean" && v) out[k] = v;
    }
    if (Object.keys(out).length === 0) {
      localStorage.removeItem(key);
    } else {
      localStorage.setItem(key, JSON.stringify(out));
    }
  } catch {
  }
}
function isStateEmpty(state) {
  return state.zoom === 0 && state.lh === 0 && state.align === 0 && state.ls === 0 && state.colorblind === 0 && !state.font && !state.dyslexia && !state.contrast && !state.hideImages && !state.highlightLinks && !state.bigCursor && !state.pauseAnim && !state.focusOutline && !state.grayOverlay && !state.readingGuide && !state.readingMask && !state.bigTargets;
}

// src/translations.ts
var DICT = {
  es: { title: "Accesibilidad", close: "Cerrar", txt: "Texto", size: "Tama\xF1o", lh: "Interlineado", align: "Alineaci\xF3n", font: "Legible", dyslexia: "Fuente Dislexia", vis: "Visual", contrast: "Contraste", gray: "Grises", hide: "Ocultar Img", links: "Links", ori: "Orientaci\xF3n", guide: "Gu\xEDa", mask: "M\xE1scara", targets: "\xC1reas Grandes", cursor: "Cursor Grande", pause: "Parar Animac.", reset: "Restablecer Todo", dev: "Desarrollado por", ls: "Espaciado", cb: "Daltonismo", focus: "Foco", presets: "Perfiles", pLow: "Baja Visi\xF3n", pDys: "Dislexia", pMot: "Motor", pCalm: "Sin Distrac.", level: (l, n, m) => `${l}, nivel ${n} de ${m}` },
  en: { title: "Accessibility", close: "Close", txt: "Text", size: "Size", lh: "Line Height", align: "Align", font: "Readable Font", dyslexia: "Dyslexia Font", vis: "Visual", contrast: "Contrast", gray: "Grayscale", hide: "Hide Images", links: "Highlight Links", ori: "Orientation", guide: "Reading Guide", mask: "Reading Mask", targets: "Big Targets", cursor: "Big Cursor", pause: "Pause Anim.", reset: "Reset All", dev: "Developed by", ls: "Letter Spacing", cb: "Color Blind", focus: "Focus", presets: "Profiles", pLow: "Low Vision", pDys: "Dyslexia", pMot: "Motor", pCalm: "No Distract.", level: (l, n, m) => `${l}, level ${n} of ${m}` },
  gn: { title: "Oikeha (Accesibilidad)", close: "Mboty", txt: "Mo\xF1e'\u1EBDr\xE3", size: "Tuichakue", lh: "Jei", align: "Mbojoja", font: "Letra Por\xE3", dyslexia: "Dislexia", vis: "Hechapy", contrast: "Sa'y", gray: "H\u0169 ha T\u0129", hide: "Moka\xF1y Ta'anga", links: "Joajuha", ori: "S\xE3mbyhy", guide: "S\xE3mbyhyha", mask: "Mbohov\xE1i", targets: "Tenda Guasu", cursor: "Cursor Guasu", pause: "Mboopyta", reset: "Mbojevy", dev: "Apojare", ls: "Rapykue", cb: "Sa'yvy", focus: "\xD1emoha", presets: "Tekor\xE3", pLow: "Hechapy Vai", pDys: "Dislexia", pMot: "Po-rehegua", pCalm: "Py\u02BCa Guapy", level: (l, n, m) => `${l}, ${n}/${m}` },
  fr: { title: "Accessibilit\xE9", close: "Fermer", txt: "Texte", size: "Taille", lh: "Interligne", align: "Alignement", font: "Police Lisible", dyslexia: "Police Dyslexie", vis: "Visuel", contrast: "Contraste", gray: "Niveaux Gris", hide: "Masquer Img", links: "Liens", ori: "Orientation", guide: "Guide Lecture", mask: "Masque Lecture", targets: "Grandes Cibles", cursor: "Grand Curseur", pause: "Pause Anim.", reset: "R\xE9initialiser", dev: "D\xE9velopp\xE9 par", ls: "Espacement", cb: "Daltonisme", focus: "Focus", presets: "Profils", pLow: "Basse Vision", pDys: "Dyslexie", pMot: "Moteur", pCalm: "Sans Distrac.", level: (l, n, m) => `${l}, niveau ${n} sur ${m}` },
  it: { title: "Accessibilit\xE0", close: "Chiudi", txt: "Testo", size: "Dimensione", lh: "Interlinea", align: "Allineamento", font: "Leggibile", dyslexia: "Font Dislessia", vis: "Visivo", contrast: "Contrasto", gray: "Scala Grig.", hide: "Nascondi Img", links: "Link", ori: "Orientamento", guide: "Guida", mask: "Maschera", targets: "Aree Grandi", cursor: "Cursore Grande", pause: "Pausa Anim.", reset: "Reimposta", dev: "Sviluppato da", ls: "Spaziatura", cb: "Daltonismo", focus: "Focus", presets: "Profili", pLow: "Ipovisione", pDys: "Dislessia", pMot: "Motorio", pCalm: "No Distraz.", level: (l, n, m) => `${l}, livello ${n} di ${m}` },
  de: { title: "Barrierefreiheit", close: "Schlie\xDFen", txt: "Text", size: "Gr\xF6\xDFe", lh: "Zeilenh\xF6he", align: "Ausrichtung", font: "Lesbar", dyslexia: "Dyslexie", vis: "Visuell", contrast: "Kontrast", gray: "Graustufen", hide: "Bilder Aus", links: "Links", ori: "Orientierung", guide: "Lesehilfe", mask: "Lesemaske", targets: "Gro\xDFe Ziele", cursor: "Gro\xDFer Cursor", pause: "Anim. Stopp", reset: "Zur\xFCcksetzen", dev: "Entwickelt von", ls: "Buchst.abst.", cb: "Farbblindheit", focus: "Fokus", presets: "Profile", pLow: "Sehschw\xE4che", pDys: "Dyslexie", pMot: "Motorik", pCalm: "Ohne Ablenk.", level: (l, n, m) => `${l}, Stufe ${n} von ${m}` },
  nl: { title: "Toegankelijkheid", close: "Sluiten", txt: "Tekst", size: "Grootte", lh: "Regelhoogte", align: "Uitlijning", font: "Leesbaar", dyslexia: "Dyslexie", vis: "Visueel", contrast: "Contrast", gray: "Grijstinten", hide: "Verberg Afb.", links: "Links", ori: "Ori\xEBntatie", guide: "Leesgids", mask: "Leesmasker", targets: "Grote Doelen", cursor: "Grote Cursor", pause: "Anim. Pauze", reset: "Resetten", dev: "Ontwikkeld door", ls: "Letterspatie", cb: "Kleurenblind", focus: "Focus", presets: "Profielen", pLow: "Slechtziend", pDys: "Dyslexie", pMot: "Motoriek", pCalm: "Geen Afleid.", level: (l, n, m) => `${l}, niveau ${n} van ${m}` },
  sv: { title: "Tillg\xE4nglighet", close: "St\xE4ng", txt: "Text", size: "Storlek", lh: "Radh\xF6jd", align: "Justering", font: "L\xE4sbar", dyslexia: "Dyslexi", vis: "Visuell", contrast: "Kontrast", gray: "Gr\xE5skala", hide: "D\xF6lj Bilder", links: "L\xE4nkar", ori: "Orientering", guide: "L\xE4slinjal", mask: "L\xE4smask", targets: "Stora Ytor", cursor: "Stor Mark\xF6r", pause: "Pausa Anim.", reset: "\xC5terst\xE4ll", dev: "Utvecklad av", ls: "Bokstavsavst.", cb: "F\xE4rgblindhet", focus: "Fokus", presets: "Profiler", pLow: "Synneds\xE4tt.", pDys: "Dyslexi", pMot: "Motorik", pCalm: "Inga Distrak.", level: (l, n, m) => `${l}, niv\xE5 ${n} av ${m}` }
};
function getTranslation(locale) {
  const lc = locale.toLowerCase();
  if (lc === "gn" || lc.startsWith("gn-") || lc.startsWith("gn_")) return DICT.gn;
  const base = lc.split(/[-_]/)[0];
  return DICT[base] ?? DICT.en;
}

// src/behavior.ts
var MULTI_KEYS = {
  "oks-zoom": "zoom",
  "oks-lh": "lh",
  "oks-align": "align",
  "oks-ls": "ls",
  "oks-colorblind": "colorblind"
};
var MULTI_LEVELS = {
  "oks-zoom": 4,
  "oks-lh": 3,
  "oks-align": 3,
  "oks-ls": 3,
  "oks-colorblind": 3
};
var TOGGLE_KEYS = {
  "oks-a11y-font": "font",
  "oks-dyslexia": "dyslexia",
  "oks-a11y-contrast": "contrast",
  "oks-a11y-hide": "hideImages",
  "oks-a11y-links": "highlightLinks",
  "oks-big-cursor": "bigCursor",
  "oks-a11y-pause": "pauseAnim",
  "oks-a11y-focus": "focusOutline",
  "oks-a11y-bigtargets": "bigTargets"
};
function noopController() {
  return Object.assign(() => {
  }, { open() {
  }, close() {
  }, toggle() {
  } });
}
function deepActiveElement() {
  let a = document.activeElement;
  while (a?.shadowRoot?.activeElement) a = a.shadowRoot.activeElement;
  return a;
}
function bindPanelBehavior(root, opts = {}) {
  const storageKey = opts.storageKey ?? "oksiacSettings";
  const t = getTranslation(opts.locale ?? "en");
  const enabled = opts.enabled ?? new Set(ALL_CONTROLS);
  const nudgeMax = Math.max(0, opts.nudgeMax ?? 0);
  const trigger = root.getElementById("oks-trigger");
  const panel = root.getElementById("oks-panel");
  const closeBtn = root.getElementById("oks-close");
  const resetBtn = root.getElementById("oks-reset");
  const wrapper = root.getElementById("oks-wrapper");
  const opts$ = Array.from(root.querySelectorAll(".oks-access-opt, .oks-preset"));
  if (!panel || !closeBtn || !resetBtn) {
    return noopController();
  }
  let state = loadState(storageKey);
  function applyState() {
    const body = document.body;
    const rootEl = document.documentElement;
    for (const cls of Array.from(body.classList)) {
      if (cls.startsWith("oks-")) body.classList.remove(cls);
    }
    [1, 2, 3].forEach((l) => rootEl.classList.remove(`oks-colorblind-${l}`));
    if (state.zoom > 0) body.classList.add(`oks-zoom-${state.zoom}`);
    if (state.lh > 0) body.classList.add(`oks-lh-${state.lh}`);
    if (state.align > 0) body.classList.add(`oks-align-${state.align}`);
    if (state.ls > 0) body.classList.add(`oks-ls-${state.ls}`);
    if (state.colorblind > 0) rootEl.classList.add(`oks-colorblind-${state.colorblind}`);
    if (state.font) body.classList.add("oks-a11y-font");
    if (state.dyslexia) body.classList.add("oks-dyslexia");
    if (state.contrast) body.classList.add("oks-a11y-contrast");
    if (state.hideImages) body.classList.add("oks-a11y-hide");
    if (state.highlightLinks) body.classList.add("oks-a11y-links");
    if (state.bigCursor) body.classList.add("oks-big-cursor");
    if (state.pauseAnim) body.classList.add("oks-a11y-pause");
    if (state.focusOutline) body.classList.add("oks-a11y-focus");
    if (state.readingGuide) body.classList.add("oks-a11y-guide");
    if (state.readingMask) body.classList.add("oks-a11y-mask");
    if (state.bigTargets) body.classList.add("oks-a11y-bigtargets");
    const overlay = ensureOverlay();
    overlay.classList.toggle("is-active", state.grayOverlay);
    syncButtonsFromState();
    wrapper?.classList.toggle("has-active", !isStateEmpty(state));
  }
  function syncButtonsFromState() {
    for (const btn of opts$) {
      const action = btn.getAttribute("data-action");
      if (action === "multi" || action === "colorblind") {
        const prefix = btn.getAttribute("data-prefix") ?? "";
        const key = MULTI_KEYS[prefix];
        if (!key) continue;
        const lvl = state[key];
        btn.setAttribute("data-level", String(lvl));
        btn.classList.toggle("is-active", lvl > 0);
        btn.setAttribute("aria-pressed", lvl > 0 ? "true" : "false");
        const max = parseInt(btn.getAttribute("data-levels") ?? "0", 10);
        const lbl = btn.querySelector(".oks-label")?.textContent?.trim() ?? "";
        if (lvl > 0 && max > 0) btn.setAttribute("aria-label", t.level(lbl, lvl, max));
        else btn.removeAttribute("aria-label");
      } else if (action === "toggle") {
        const klass = btn.getAttribute("data-class") ?? "";
        const key = TOGGLE_KEYS[klass];
        if (!key) continue;
        const val = state[key];
        btn.classList.toggle("is-active", val);
        btn.setAttribute("aria-pressed", val ? "true" : "false");
      } else if (action === "overlay") {
        btn.classList.toggle("is-active", state.grayOverlay);
        btn.setAttribute("aria-pressed", state.grayOverlay ? "true" : "false");
      } else if (action === "guide") {
        btn.classList.toggle("is-active", state.readingGuide);
        btn.setAttribute("aria-pressed", state.readingGuide ? "true" : "false");
      } else if (action === "mask") {
        btn.classList.toggle("is-active", state.readingMask);
        btn.setAttribute("aria-pressed", state.readingMask ? "true" : "false");
      }
    }
  }
  const onOptClick = (e) => {
    const btn = e.currentTarget;
    const action = btn.getAttribute("data-action");
    if (action === "multi") {
      const prefix = btn.getAttribute("data-prefix") ?? "";
      const key = MULTI_KEYS[prefix];
      const max = MULTI_LEVELS[prefix] ?? 0;
      if (!key) return;
      const lvl = (state[key] + 1) % (max + 1);
      state[key] = lvl;
    } else if (action === "colorblind") {
      state.colorblind = (state.colorblind + 1) % 4;
    } else if (action === "toggle") {
      const klass = btn.getAttribute("data-class") ?? "";
      const key = TOGGLE_KEYS[klass];
      if (!key) return;
      state[key] = !state[key];
      if (klass === "oks-a11y-contrast" && state.contrast) state.grayOverlay = false;
    } else if (action === "overlay") {
      state.grayOverlay = !state.grayOverlay;
      if (state.grayOverlay) state.contrast = false;
    } else if (action === "guide") {
      state.readingGuide = !state.readingGuide;
    } else if (action === "mask") {
      state.readingMask = !state.readingMask;
    } else if (action === "preset") {
      const id = btn.getAttribute("data-preset");
      if (id && PRESETS[id]) Object.assign(state, filterPresetForEnabled(id, enabled));
      btn.classList.add("is-flashing");
      setTimeout(() => btn.classList.remove("is-flashing"), 250);
    }
    applyState();
    saveState(storageKey, state);
  };
  const onReset = () => {
    state = { ...DEFAULT_STATE };
    applyState();
    saveState(storageKey, state);
  };
  let opener = null;
  let ignoreDocClose = false;
  const openPanel = () => {
    if (panel.classList.contains("is-open")) return;
    opener = deepActiveElement();
    panel.classList.add("is-open");
    panel.removeAttribute("inert");
    trigger?.setAttribute("aria-expanded", "true");
    ignoreDocClose = true;
    setTimeout(() => {
      ignoreDocClose = false;
    }, 0);
    const first = panel.querySelector("button:not([disabled])");
    first?.focus();
  };
  const closePanel = () => {
    if (!panel.classList.contains("is-open")) return;
    panel.classList.remove("is-open");
    panel.setAttribute("inert", "");
    trigger?.setAttribute("aria-expanded", "false");
    if (trigger) trigger.focus();
    else if (opener?.isConnected) opener.focus();
    opener = null;
  };
  const togglePanel = () => {
    if (panel.classList.contains("is-open")) closePanel();
    else openPanel();
  };
  let suppressClick = false;
  const onTriggerClick = (e) => {
    e.stopPropagation();
    if (suppressClick) {
      suppressClick = false;
      return;
    }
    togglePanel();
  };
  const onDocClick = (e) => {
    if (!panel.classList.contains("is-open")) return;
    if (ignoreDocClose) return;
    const path = e.composedPath();
    if (path.includes(panel)) return;
    if (trigger && path.includes(trigger)) return;
    if (wrapper && path.includes(wrapper)) return;
    closePanel();
  };
  const onKeyDown = (e) => {
    if (!panel.classList.contains("is-open")) return;
    if (e.key === "Escape") {
      closePanel();
      return;
    }
    if (e.key !== "Tab") return;
    const focusable = Array.from(panel.querySelectorAll("button:not([disabled]), a[href]"));
    if (focusable.length === 0) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    const active = root.activeElement;
    if (e.shiftKey) {
      if (active === first) {
        e.preventDefault();
        last.focus();
      }
    } else {
      if (active === last) {
        e.preventDefault();
        first.focus();
      }
    }
  };
  const NUDGE_KEY = `${storageKey}::pos`;
  const clampMax = (v) => Math.max(-nudgeMax, Math.min(nudgeMax, v));
  let nudge = { x: 0, y: 0 };
  const loadNudge = () => {
    if (nudgeMax <= 0) return;
    try {
      const raw = localStorage.getItem(NUDGE_KEY);
      if (!raw) return;
      const p = JSON.parse(raw);
      if (typeof p?.x === "number" && typeof p?.y === "number") {
        nudge = { x: clampMax(p.x), y: clampMax(p.y) };
      }
    } catch {
    }
  };
  const saveNudge = () => {
    try {
      if (nudge.x === 0 && nudge.y === 0) localStorage.removeItem(NUDGE_KEY);
      else localStorage.setItem(NUDGE_KEY, JSON.stringify(nudge));
    } catch {
    }
  };
  const applyNudge = () => {
    if (wrapper) wrapper.style.translate = `${nudge.x}px ${nudge.y}px`;
  };
  const clampOffset = (x, y) => {
    x = clampMax(x);
    y = clampMax(y);
    if (wrapper) {
      const r = wrapper.getBoundingClientRect();
      const pad = 4;
      const baseLeft = r.left - nudge.x;
      const baseTop = r.top - nudge.y;
      const vw = window.innerWidth || 0;
      const vh = window.innerHeight || 0;
      if (r.width > 0 && vw > 0) x = Math.max(pad - baseLeft, Math.min(vw - pad - r.width - baseLeft, x));
      if (r.height > 0 && vh > 0) y = Math.max(pad - baseTop, Math.min(vh - pad - r.height - baseTop, y));
    }
    return { x, y };
  };
  let dragStart = null;
  let didDrag = false;
  const DRAG_THRESHOLD = 4;
  const onPointerDown = (e) => {
    if (nudgeMax <= 0 || e.button !== 0) return;
    dragStart = { px: e.clientX, py: e.clientY, ox: nudge.x, oy: nudge.y };
    didDrag = false;
    trigger?.setPointerCapture?.(e.pointerId);
  };
  const onPointerMove = (e) => {
    if (!dragStart) return;
    const dx = e.clientX - dragStart.px;
    const dy = e.clientY - dragStart.py;
    if (!didDrag && Math.hypot(dx, dy) < DRAG_THRESHOLD) return;
    didDrag = true;
    nudge = clampOffset(dragStart.ox + dx, dragStart.oy + dy);
    applyNudge();
    e.preventDefault();
  };
  const onPointerUp = () => {
    if (!dragStart) return;
    dragStart = null;
    if (didDrag) {
      saveNudge();
      suppressClick = true;
    }
  };
  const onTriggerKey = (e) => {
    if (nudgeMax <= 0) return;
    const step = e.shiftKey ? 1 : 10;
    let dx = 0;
    let dy = 0;
    if (e.key === "ArrowLeft") dx = -step;
    else if (e.key === "ArrowRight") dx = step;
    else if (e.key === "ArrowUp") dy = -step;
    else if (e.key === "ArrowDown") dy = step;
    else return;
    e.preventDefault();
    nudge = clampOffset(nudge.x + dx, nudge.y + dy);
    applyNudge();
    saveNudge();
  };
  const onMove = (e) => {
    if (!state.readingGuide && !state.readingMask) return;
    const y = e.touches?.[0]?.clientY ?? e.clientY;
    if (typeof y !== "number") return;
    if (state.readingGuide) {
      const guide = document.getElementById("oks-reading-guide");
      if (guide) guide.style.top = `${y}px`;
    }
    if (state.readingMask) {
      const mask = document.getElementById("oks-reading-mask");
      if (mask) mask.style.setProperty("--oks-mask-y", `${y}px`);
    }
  };
  trigger?.addEventListener("click", onTriggerClick);
  closeBtn.addEventListener("click", closePanel);
  resetBtn.addEventListener("click", onReset);
  for (const btn of opts$) btn.addEventListener("click", onOptClick);
  document.addEventListener("click", onDocClick);
  document.addEventListener("keydown", onKeyDown);
  document.addEventListener("mousemove", onMove);
  document.addEventListener("touchmove", onMove, { passive: true });
  if (nudgeMax > 0 && trigger) {
    loadNudge();
    applyNudge();
    trigger.style.cursor = "grab";
    trigger.style.touchAction = "none";
    trigger.addEventListener("pointerdown", onPointerDown);
    document.addEventListener("pointermove", onPointerMove);
    document.addEventListener("pointerup", onPointerUp);
    trigger.addEventListener("keydown", onTriggerKey);
  }
  applyState();
  const dispose = () => {
    trigger?.removeEventListener("click", onTriggerClick);
    closeBtn.removeEventListener("click", closePanel);
    resetBtn.removeEventListener("click", onReset);
    for (const btn of opts$) btn.removeEventListener("click", onOptClick);
    document.removeEventListener("click", onDocClick);
    document.removeEventListener("keydown", onKeyDown);
    document.removeEventListener("mousemove", onMove);
    document.removeEventListener("touchmove", onMove);
    trigger?.removeEventListener("pointerdown", onPointerDown);
    document.removeEventListener("pointermove", onPointerMove);
    document.removeEventListener("pointerup", onPointerUp);
    trigger?.removeEventListener("keydown", onTriggerKey);
  };
  return Object.assign(dispose, { open: openPanel, close: closePanel, toggle: togglePanel });
}
function ensureOverlay() {
  let el = document.getElementById("oks-overlay-gray");
  if (!el) {
    el = document.createElement("div");
    el.id = "oks-overlay-gray";
    el.className = "oks-overlay-effect";
    document.body.appendChild(el);
  }
  return el;
}

// src/styles.ts
var PANEL_CSS = `
:host {
  --oks-btn-size: 55px;
  --oks-bg: #000;
  --oks-icon: #fff;
  --oks-h-bg: #fff;
  --oks-h-icon: #000;
  --oks-z: 9999999;
}
.oks-access-wrapper {
  position: fixed;
  z-index: var(--oks-z);
  line-height: 1;
}
.oks-access-btn {
  width: var(--oks-btn-size);
  height: var(--oks-btn-size);
  border-radius: 50%;
  background: var(--oks-bg);
  color: var(--oks-icon);
  border: 2px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.2s;
  padding: 0;
}
.oks-access-btn:hover {
  background: var(--oks-h-bg);
  color: var(--oks-h-icon);
  transform: scale(1.1);
}
.oks-access-btn svg {
  fill: currentColor;
  display: block;
  margin: 0 auto;
  width: 60%;
  height: 60%;
}
/* Porthole preset: a brushed-metal ring framing the standard glyph. The glyph
   itself is untouched (discoverability), only the button gets the frame.
   Hosts wanting a bespoke frame can target ::part(trigger) from light DOM. */
.oks-access-btn[data-trigger-icon="porthole"] {
  box-shadow: 0 0 0 4px #b0bec5, 0 0 0 7px #546e7a, 0 6px 18px rgba(0,0,0,0.3);
}
.oks-active-badge {
  position: absolute;
  top: -2px;
  right: -2px;
  width: 20px;
  height: 20px;
  background: #25D366;
  border-radius: 50%;
  border: 2px solid #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  opacity: 0;
  pointer-events: none;
}
.oks-active-badge svg { width: 12px; height: 12px; }
.oks-access-wrapper.has-active .oks-active-badge { opacity: 1; }

.oks-access-panel {
  position: fixed;
  width: 340px;
  max-height: 90vh;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  z-index: var(--oks-z);
  display: flex;
  flex-direction: column;
  opacity: 0;
  pointer-events: none;
  transition: 0.2s;
  border: 1px solid rgba(0,0,0,0.1);
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  color: #333;
}
.oks-access-panel.is-open { opacity: 1; pointer-events: all; }
.oks-access-header {
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.oks-access-header h3 { margin: 0; font-size: 18px; color: #000; }
.oks-access-close {
  background: #f0f0f0;
  color: #333;
  border: 1px solid #ddd;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.2s;
  padding: 0;
}
.oks-access-close:hover { background: #e0e0e0; border-color: #ccc; }
.oks-access-close svg { width: 24px; height: 24px; stroke-width: 2.5px; }
.oks-access-content { padding: 0 20px 20px; overflow-y: auto; }
.oks-access-title {
  margin: 10px 0 5px;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  color: #888;
}
.oks-access-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 8px; }
.oks-access-presets { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 6px; }
.oks-preset {
  background: #f0f4f8;
  border: 2px solid transparent;
  border-radius: 8px;
  padding: 8px 4px;
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  font: inherit;
  color: #333;
  min-width: 0;
  transition: 0.15s;
}
.oks-preset:hover { background: #000; color: #fff; }
.oks-preset:focus-visible { outline: 2px solid #000; outline-offset: 2px; }
/* Click feedback: a 250 ms flip + slight squeeze. Pure transient \u2014 the
   button does not carry persistent active state because a preset is a
   trigger, not a mode. */
.oks-preset.is-flashing {
  background: #000;
  color: #fff;
  transform: scale(0.96);
}
.oks-preset .oks-icon { font-size: 22px; margin-bottom: 4px; }
.oks-preset .oks-icon svg { width: 20px; height: 20px; }
.oks-preset .oks-label {
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  text-align: center; line-height: 1.15;
  overflow-wrap: anywhere; word-break: break-word;
  /* Reserve room for 2 lines so 1-line labels (DISLEXIA, MOTOR) and
     2-line labels (BAJA VISI\xD3N, SIN DISTRAC.) end up the same height,
     centred. Without this the row looks ragged. */
  min-height: 2.3em;
  display: flex; align-items: center; justify-content: center;
}
.oks-access-opt {
  background: #f9f9f9;
  border: 2px solid #eee;
  border-radius: 10px;
  padding: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  min-width: 0;
  min-height: 70px;
  color: #333;
  transition: 0.2s;
  font: inherit;
}
.oks-access-opt.full-width { grid-column: span 2; }
.oks-access-opt.is-active {
  border-color: #000;
  background: #fff;
  box-shadow: 0 0 0 1px #000;
}
.oks-access-opt:hover { background: #000; color: #fff; border-color: #000; }
.oks-icon { font-size: 28px; margin-bottom: 3px; display: block; line-height: 1; }
.oks-icon svg { width: 24px; height: 24px; fill: currentColor; }
.oks-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  text-align: center;
  line-height: 1.2;
  overflow-wrap: anywhere;
  word-break: break-word;
}
.oks-levels { display: flex; gap: 3px; height: 5px; width: 50%; margin-top: 5px; }
.oks-levels span { flex: 1; background: #ddd; border-radius: 3px; }
.oks-access-opt[data-level="1"] .oks-levels span:nth-child(1),
.oks-access-opt[data-level="2"] .oks-levels span:nth-child(-n+2),
.oks-access-opt[data-level="3"] .oks-levels span:nth-child(-n+3),
.oks-access-opt[data-level="4"] .oks-levels span:nth-child(-n+4) { background: #000; }
.oks-access-opt:hover .oks-levels span { background: #555; }
.oks-access-footer {
  padding: 12px 20px;
  border-top: 1px solid #eee;
  text-align: center;
}
.oks-access-reset {
  width: 100%;
  padding: 8px;
  border: 2px solid #000;
  color: #000;
  background: transparent;
  font-weight: 700;
  cursor: pointer;
  border-radius: 6px;
  font-size: 12px;
}
.oks-access-reset:hover { background: #000; color: #fff; }
.oks-access-branding { margin-top: 12px; font-size: 12px; color: #000; font-weight: 700; }
.oks-access-branding a { color: #000; text-decoration: none; border-bottom: 1px dotted #000; }

@media (prefers-reduced-motion: reduce) {
  .oks-access-btn, .oks-access-panel, .oks-access-close,
  .oks-preset, .oks-access-opt { transition: none; }
  .oks-access-btn:hover { transform: scale(1); }
  .oks-preset.is-flashing { transform: none; }
}
@media (max-width: 768px) {
  .oks-access-panel {
    width: 100%; height: 100%; max-height: 100%;
    top: 0; left: 0; right: 0; bottom: 0;
    border-radius: 0;
  }
  .oks-access-opt { min-height: 72px; padding: 10px 8px; }
  .oks-icon svg { width: 26px; height: 26px; }
  .oks-label { font-size: 12px; line-height: 1.25; }
  .oks-access-grid { gap: 8px; }
  .oks-access-content { padding: 0 14px 20px; }
  .oks-access-title { font-size: 11px; margin: 10px 0 4px; }
  /* Cursor grande no aplica en t\xE1ctil: oculto y dejo el \xFAltimo bot\xF3n
     de la secci\xF3n ocupando 2 columnas para no romper la grilla par. */
  .oks-access-opt[data-class="oks-big-cursor"] { display: none; }
  .oks-access-opt[data-class="oks-a11y-focus"] { grid-column: span 2; }
  .oks-access-reset { padding: 14px; font-size: 14px; }
}
`;
var EFFECT_CSS = `
html.oks-colorblind-1 { filter: url('#oks-filter-protanopia'); }
html.oks-colorblind-2 { filter: url('#oks-filter-deuteranopia'); }
html.oks-colorblind-3 { filter: url('#oks-filter-tritanopia'); }

/* Text-size levels.
   Applied to <html> via :has(), not to <body>. rem is anchored to the root
   element, so a site whose CSS sizes things in rem (most modern Astro / Tailwind
   builds) needs the root font-size to change for the scale to take effect.
   A previous version applied this to body with %, which only moved descendants
   that inherited font-size from body \u2014 anything sized in rem stayed locked to
   the 16px default of <html>. An even earlier version used the universal
   selector with em and compounded the factor at every nesting level.
   :has(body.oks-zoom-N) is the right anchor: one change at the root, rem
   descendants scale exactly once. Hard-coded px is intentionally left alone;
   browser zoom covers that case. */
html:has(body.oks-zoom-1) { font-size: 110% !important; }
html:has(body.oks-zoom-2) { font-size: 120% !important; }
html:has(body.oks-zoom-3) { font-size: 135% !important; }
html:has(body.oks-zoom-4) { font-size: 150% !important; }

body.oks-lh-1 * { line-height: 1.6 !important; }
body.oks-lh-2 * { line-height: 1.9 !important; }
body.oks-lh-3 * { line-height: 2.2 !important; }

body.oks-a11y-font { font-family: Arial, sans-serif !important; }

body.oks-dyslexia * {
  font-family: 'Comic Sans MS', 'Verdana', sans-serif !important;
  letter-spacing: 0.05em !important;
  word-spacing: 0.1em !important;
  line-height: 1.6 !important;
}

body.oks-a11y-hide img { opacity: 0 !important; visibility: hidden !important; }
body.oks-a11y-links a { text-decoration: underline !important; background: #ff0 !important; color: #000 !important; }

body.oks-align-1 * { text-align: left !important; }
body.oks-align-2 * { text-align: center !important; }
body.oks-align-3 * { text-align: right !important; }

body.oks-a11y-pause * { animation: none !important; transition: none !important; }

body.oks-ls-1 * { letter-spacing: 0.05em !important; }
body.oks-ls-2 * { letter-spacing: 0.10em !important; }
body.oks-ls-3 * { letter-spacing: 0.16em !important; }

body.oks-a11y-focus a:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-focus button:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-focus input,
body.oks-a11y-focus select,
body.oks-a11y-focus textarea {
  outline: 2px dashed rgba(0, 95, 204, 0.45) !important;
  outline-offset: 2px !important;
}
body.oks-a11y-focus *:focus-visible {
  outline: 3px solid #005fcc !important;
  outline-offset: 3px !important;
  box-shadow: 0 0 0 6px rgba(0, 95, 204, 0.25) !important;
}

body.oks-a11y-contrast.oks-a11y-focus *:focus,
body.oks-a11y-contrast.oks-a11y-focus *:focus-visible {
  outline-color: #0ff !important;
  box-shadow: 0 0 0 6px rgba(0, 255, 255, 0.3) !important;
}

@media (pointer: fine) {
  body.oks-big-cursor, body.oks-big-cursor a, body.oks-big-cursor button {
    cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 24 24'%3E%3Cpath d='M4 2L4 18L8 14L11 21L14 19.5L11 13L15.5 13Z' stroke='white' stroke-width='4' stroke-linejoin='round' fill='white'/%3E%3Cpath d='M4 2L4 18L8 14L11 21L14 19.5L11 13L15.5 13Z' fill='black'/%3E%3C/svg%3E") 8 4, auto !important;
  }
}

body.oks-a11y-contrast,
body.oks-a11y-contrast *:not(oksigenia-access-panel):not(oksigenia-access-panel *) {
  background-color: #000 !important;
  color: #ff0 !important;
  border-color: #ff0 !important;
  text-shadow: none !important;
  box-shadow: none !important;
}
body.oks-a11y-contrast img { filter: grayscale(100%) contrast(120%) !important; }
body.oks-a11y-contrast a:not(oksigenia-access-panel *) { color: #0ff !important; text-decoration: underline !important; }

/* High-contrast applies background:#000 to every descendant of body to flip
   the page to inverted colours. That selector also catches our own overlays
   (.oks-reading-guide, .oks-overlay-effect), which would then paint a solid
   black band on top of the text and defeat their purpose. Restore the
   overlay-specific values here so they keep working in high-contrast mode. */
body.oks-a11y-contrast .oks-reading-guide {
  background-color: rgba(255, 255, 0, 0.25) !important;
  border-top-color: #ff0 !important;
  border-bottom-color: #ff0 !important;
}
body.oks-a11y-contrast .oks-overlay-effect {
  background-color: transparent !important;
}

.oks-overlay-effect {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: 999990;
  display: none;
  backdrop-filter: grayscale(100%);
}
.oks-overlay-effect.is-active { display: block; }

.oks-reading-guide {
  position: fixed; left: 0;
  width: 100%; height: 50px;
  background: rgba(255, 255, 0, 0.2);
  border-top: 3px solid red;
  border-bottom: 3px solid red;
  pointer-events: none;
  z-index: 2147483647;
  display: none;
  transform: translateY(-50%);
}
body.oks-a11y-guide .oks-reading-guide { display: block; }

/* Reading mask: dark overlay leaving a horizontal band lit around the cursor.
   --oks-mask-y is updated from JS on mousemove; band is \xB190px around it. */
.oks-reading-mask {
  position: fixed; top: 0; left: 0;
  width: 100vw; height: 100vh;
  pointer-events: none;
  z-index: 2147483646;
  background: rgba(0, 0, 0, 0.75);
  display: none;
  clip-path: polygon(
    0 0, 100% 0,
    100% calc(var(--oks-mask-y, 50vh) - 90px),
    0    calc(var(--oks-mask-y, 50vh) - 90px),
    0    calc(var(--oks-mask-y, 50vh) + 90px),
    100% calc(var(--oks-mask-y, 50vh) + 90px),
    100% 100%, 0 100%
  );
}
body.oks-a11y-mask .oks-reading-mask { display: block; }
body.oks-a11y-contrast .oks-reading-mask { background-color: rgba(0, 0, 0, 0.85) !important; }

/* Big targets: bump interactive hit-areas to WCAG 2.5.5 (44\xD744 minimum).
   Only adjusts padding + min-* \u2014 never display, so layouts that rely on
   inline flow or grid placement survive. Exempts our own shadow-DOM host. */
body.oks-a11y-bigtargets a:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-bigtargets button:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-bigtargets [role="button"]:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-bigtargets input[type="checkbox"]:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-bigtargets input[type="radio"]:not(oksigenia-access-panel):not(oksigenia-access-panel *),
body.oks-a11y-bigtargets summary:not(oksigenia-access-panel):not(oksigenia-access-panel *) {
  min-height: 44px !important;
  min-width: 44px !important;
  padding: 8px 12px !important;
  box-sizing: border-box !important;
}
`;

// src/web-component.ts
var OBSERVED = [
  "locale",
  "position",
  "position-mobile",
  "trigger-icon",
  "storage-key",
  "controls",
  "exclude",
  "trigger",
  "effects-exclude",
  "nudge",
  "presets"
];
var STYLE_ID = "oksigenia-access-effects";
var FILTERS_ID = "oksigenia-access-filters";
var GUIDE_ID = "oks-reading-guide";
var MASK_ID = "oks-reading-mask";
function ensureGlobalStyles() {
  if (typeof document === "undefined") return;
  if (!document.getElementById(STYLE_ID)) {
    const style = document.createElement("style");
    style.id = STYLE_ID;
    style.textContent = EFFECT_CSS;
    document.head.appendChild(style);
  }
  if (!document.getElementById(FILTERS_ID)) {
    const wrap = document.createElement("div");
    wrap.id = FILTERS_ID;
    wrap.style.cssText = "position:absolute;width:0;height:0;overflow:hidden;";
    wrap.innerHTML = COLORBLIND_FILTERS_SVG;
    document.body.appendChild(wrap);
  }
  if (!document.getElementById(GUIDE_ID)) {
    const guide = document.createElement("div");
    guide.id = GUIDE_ID;
    guide.className = "oks-reading-guide";
    document.body.appendChild(guide);
  }
  if (!document.getElementById(MASK_ID)) {
    const mask = document.createElement("div");
    mask.id = MASK_ID;
    mask.className = "oks-reading-mask";
    document.body.appendChild(mask);
  }
}
var VALID_POSITIONS = [
  "top-left",
  "top-center",
  "top-right",
  "mid-left",
  "mid-center",
  "mid-right",
  "bottom-left",
  "bottom-center",
  "bottom-right"
];
var VALID_ICONS = ["vitruvian", "wheelchair", "eye", "universal", "porthole"];
var fxSeq = 0;
var OksigeniaAccessPanelElement = class extends HTMLElement {
  static get observedAttributes() {
    return OBSERVED;
  }
  _controller = null;
  _fxId = `oks-access-fx-${++fxSeq}`;
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
  }
  connectedCallback() {
    ensureGlobalStyles();
    this.render();
  }
  disconnectedCallback() {
    this._controller?.();
    this._controller = null;
    if (typeof document !== "undefined") document.getElementById(this._fxId)?.remove();
  }
  attributeChangedCallback() {
    if (this.isConnected) this.render();
  }
  /** Imperative API (#2): open / close / toggle the panel from the host.
   *  Useful with `trigger="none"`, where the host drives its own button. */
  open() {
    this._controller?.open();
  }
  close() {
    this._controller?.close();
  }
  toggle() {
    this._controller?.toggle();
  }
  getPosition() {
    const attr = this.getAttribute("position") ?? "mid-left";
    return VALID_POSITIONS.includes(attr) ? attr : "mid-left";
  }
  getPositionMobile() {
    const attr = this.getAttribute("position-mobile");
    return attr && VALID_POSITIONS.includes(attr) ? attr : void 0;
  }
  getTriggerIcon() {
    const attr = this.getAttribute("trigger-icon") ?? "vitruvian";
    return VALID_ICONS.includes(attr) ? attr : "vitruvian";
  }
  getLocale() {
    return this.getAttribute("locale") ?? (typeof navigator !== "undefined" ? navigator.language : "en");
  }
  /** `nudge` (bare) ⇒ default 80px cap; `nudge="50"` ⇒ 50; absent/invalid ⇒ off. */
  getNudgeMax() {
    if (!this.hasAttribute("nudge")) return 0;
    const raw = this.getAttribute("nudge");
    if (raw == null || raw.trim() === "") return 80;
    const n = parseInt(raw, 10);
    return Number.isFinite(n) && n > 0 ? n : 0;
  }
  /** Inject the per-instance effects-exclude rule (#4): under high-contrast,
   *  drop the destructive filter from selectors the host marks as essential
   *  media (video, canvas, scientific imagery). Grayscale is handled by not
   *  offering the control (curation), not here. */
  updateEffectsExclude() {
    if (typeof document === "undefined") return;
    const sel = (this.getAttribute("effects-exclude") ?? "").split(",").map((s) => s.trim()).filter(Boolean);
    const existing = document.getElementById(this._fxId);
    if (sel.length === 0) {
      existing?.remove();
      return;
    }
    const style = existing ?? document.createElement("style");
    if (!existing) {
      style.id = this._fxId;
      document.head.appendChild(style);
    }
    const list = sel.join(", ");
    style.textContent = `body.oks-a11y-contrast :is(${list}), body.oks-a11y-contrast :is(${list}) * { filter: none !important; }`;
  }
  render() {
    const shadow = this.shadowRoot;
    if (!shadow) return;
    this._controller?.();
    const position = this.getPosition();
    const positionMobile = this.getPositionMobile();
    const enabled = resolveEnabledControls(this.getAttribute("controls"), this.getAttribute("exclude"));
    const showTrigger = this.getAttribute("trigger") !== "none";
    const showPresets = (this.getAttribute("presets") ?? "").trim().toLowerCase() !== "none";
    const html = buildPanelHtml({
      t: getTranslation(this.getLocale()),
      triggerIcon: this.getTriggerIcon(),
      position,
      enabled,
      showTrigger,
      showPresets
    });
    shadow.innerHTML = `<style>${PANEL_CSS}${positionCss(position, positionMobile)}</style>${html}`;
    this._controller = bindPanelBehavior(shadow, {
      storageKey: this.getAttribute("storage-key") ?? void 0,
      locale: this.getLocale(),
      enabled,
      nudgeMax: this.getNudgeMax()
    });
    this.updateEffectsExclude();
  }
};
if (typeof customElements !== "undefined" && !customElements.get("oksigenia-access-panel")) {
  customElements.define("oksigenia-access-panel", OksigeniaAccessPanelElement);
}

export { OksigeniaAccessPanelElement };
//# sourceMappingURL=web-component.js.map
//# sourceMappingURL=web-component.js.map