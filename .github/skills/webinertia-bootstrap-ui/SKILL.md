---
name: webinertia-bootstrap-ui
description: "Use this skill when asked to add a new component, section, or page to the Webinertia Bootstrap UI design system. Covers procedures for extending components.phtml, creating new pthml pages, and adding styles to style.css while maintaining the dark glassmorphic aesthetic with Bootstrap 5.3."
argument-hint: "<component type or page name — e.g. 'badge variants', 'pricing page', 'progress bars'>"
---

# Webinertia Bootstrap UI — Skill

## Purpose

This skill guides extending the Webinertia Bootstrap UI design system by adding:
- New component variants to `webinertia.dev/httpdocs/components.phtml`
- New styles to `webinertia.dev/httpdocs/assets/css/style.css`
- New pages with full page shell and sections

---

## Before You Begin — Gather Context

1. Read the relevant sections of `webinertia.dev/httpdocs/assets/css/style.css` to understand existing patterns before adding anything.
2. For new **components.phtml** sections, read the last existing section to understand the current section numbering.
3. If creating a **new page**, check how `httpdocs/components.phtml` or `src/App/templates/services.phtml` is structured — pages follow identical shell patterns.
4. All assets (CSS, JS) must be added via CDN links in the `<head>` of the layout file (`src/App/templates/layout/default.phtml`) — never add new assets directly to component or page templates. These must be added to the layout using laminas view helpers and not hard-coded in the HTML.
---

## Procedure: Adding a Component Section to `components.phtml`

### Step 1 — Choose placement

- **Standard section** (component demo): wrap content in `<section class="component-section">`
- **Diagonal alternate section**: wrap in `<section class="diagonal-section">` — used for visual variety, should alternate roughly every 2 sections

**Never add a `style="..."` attribute to the section element.** Use the appropriate class instead.

### Step 2 — Write the section markup

```html
<!-- Section N — [Component Name] -->
<section class="component-section">
    <div class="section-header">
        <h2 class="section-title"><span class="gradient-text">Component Name</span></h2>
        <div class="divider"></div>
        <p class="section-subtitle">
            Brief description of what these components are for.
        </p>
    </div>

    <!-- Demo row or grid here -->
    <div class="…-demo-grid">
        <!-- Trigger cards, live examples, etc. -->
    </div>
</section>
```

### Step 3 — Add trigger / demo cards

For interactive components (modals, toasts), use a `.modal-trigger-card` (or `.toast-trigger-card`):

```html
<div class="modal-trigger-card">
    <div class="card-icon">🟣</div>
    <h3>Variant Name</h3>
    <p>Short description.</p>
    <div class="trigger-card-footer">
        <button class="btn-sm-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Open Modal
        </button>
    </div>
</div>
```

For static demos (tooltips, badges, pills etc.), embed the live element directly without a trigger card wrapper.

### Step 4 — Add HTML block (modals/offcanvas/popovers only)

Place the full Bootstrap modal/offcanvas HTML **after the closing `</main>` tag** and **before the first `<script>` tag**:

```html
<!-- Modal: component-name -->
<div class="modal fade [variant-class]" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Body content.
            </div>
            <div class="modal-footer">
                <button class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-sm-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
```

### Step 5 — Add a demo grid layout class (if needed)

If the new component needs its own grid layout, append to `style.css`:

```css
/* =====================================================
   [COMPONENT NAME] STYLES
   ===================================================== */

.component-demo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}
```

---

## Procedure: Adding a New CSS Component Variant

When adding a new **colour variant** for an existing component (modal, toast, tooltip, accordion), follow the same pattern as existing variants in `style.css`:

1. Find the existing variant block (e.g. `.modal-cyan { … }`) using search
2. Copy the exact block structure
3. Change the gradient reference to the appropriate token (`--gradient-1`, `--gradient-2`, `--gradient-3`) or define a new gradient using existing token colours
4. Adjust `box-shadow` glow colour to match the accent

**Accent colour fast reference:**

| Intent | Gradient / colour |
|---|---|
| Purple (default) | `var(--gradient-1)` / `rgba(139,92,246,…)` |
| Cyan (info) | `var(--gradient-2)` / `rgba(6,182,212,…)` |
| Magenta (highlight) | `var(--gradient-3)` / `rgba(236,72,153,…)` |
| Success (green) | `linear-gradient(135deg, #10B981, #06B6D4)` / `rgba(16,185,129,…)` |
| Danger (red) | `linear-gradient(135deg, #EF4444, #EC4899)` / `rgba(239,68,68,…)` |
| Warning (yellow) | `linear-gradient(135deg, #FBBF24, #EC4899)` / `rgba(251,191,36,…)` |

---

## Procedure: Creating a New Page

### Step 1 — Copy the shell

All pages share the same shell (side nav, main, footer, two CDN links). Copy from any existing page.

### Step 2 — Page header

Every interior page (not index) starts with a standard header inside `<main class="main-content">`:

```html
<section class="page-header">
    <h1 class="hero-title"><span class="gradient-text">Page Heading</span></h1>
    <div class="divider"></div>
    <p class="hero-subtitle">
        Page description copy.
    </p>
</section>
```

### Step 3 — Content sections

Use a mix of:
- `.bento-grid` + `.bento-card` for feature/info grids
- `.diagonal-section` for alternating visual contrast
- `.portfolio-grid` only for work/project showcase (12-col CSS grid)
- `.contact-container` + `.contact-form` + `.form-grid` for contact/lead forms only

### Step 4 — CTA section (last section on every page)

```html
<section class="cta-section">
    <h2 class="section-title">
        <span class="gradient-text">Ready to Get Started?</span>
    </h2>
    <p class="section-subtitle">
        CTA supporting copy here.
    </p>
    <div class="cta-buttons">
        <a href="<?= $this->url('contact') ?>" class="btn-primary">Start a Project</a>
        <a href="<?= $this->url('projects') ?>" class="btn-outline">View Our Work</a>
    </div>
</section>
```

### Step 5 — Add to side nav on every page

If the new page should appear in nav, add a `<li class="side-nav-item">` to the side nav in `src/Htmx/templates/body/default.phtml`.

The new page should also be added to the Mobile Navigation Offcanvas in the same file using the same pattern as the Mobile Nav section.

---

## CSS Conventions — Checklist

When writing any new CSS for this project:

- [ ] Use `var(--token)` from `:root` — never hard-code hex values
- [ ] **Never use `style="..."` attributes** — if a CSS class for the desired style does not exist, define one in `style.css` first
- [ ] Glassmorphism: `backdrop-filter: blur(20px)` + `background: rgba(26,26,46, 0.6)` + `border: 1px solid rgba(139,92,246, 0.2)`
- [ ] Card hover: `transform: translateY(-10px)` + appropriate glow `box-shadow`
- [ ] Buttons are `border-radius: 50px` pills — no rectangular buttons
- [ ] Component accent bar — **top** for cards/modals, **left** for toasts — always 4px, always via `::before` pseudo-element
- [ ] Do not use Bootstrap colour utilities (`bg-*`, `text-*`, `border-*`)
- [ ] Append new styles at the **bottom** of `style.css` in a clearly labelled comment block
- [ ] Never modify the `:root` token values

---

## Common Mistakes to Avoid

| Mistake | Fix |
|---|---|
| Using Bootstrap's `.btn-primary` utility | Use `.btn-sm-primary` or `a.btn-primary` (custom class) |
| Adding `data-bs-parent` to all accordions | Only use for single-open accordions; omit for multi-open |
| Forgetting to dispose Toast before re-show | Always call `existing.dispose()` before `new bootstrap.Toast(el).show()` |
| Using `container` / `row` / `col-*` Bootstrap grid inside main | Use custom `.bento-grid`, `.portfolio-grid`, `.form-grid` instead |
| Hard-coding `#8B5CF6` in new CSS | Use `var(--primary-purple)` |
| Forgetting tooltip init in JS | `querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el))` |
| Putting modals inside `<main>` | Place all `modal`/`offcanvas` HTML **after** `</main>`, before `<script>` |
