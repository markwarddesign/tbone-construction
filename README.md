# T-Bone Construction — WordPress Theme

Custom Gutenberg block theme for [T-Bone Construction](https://tboneconstruction.com), a residential construction company in Jerome, Idaho.

Built with native WordPress block APIs, Tailwind CSS, and Lucide icons. Includes a Projects custom post type with a filterable, lightbox-enabled gallery, plus a Contact Form 7 integration block.

## Highlights

- **17 custom blocks** organized as parents (`services`, `services-detail`, `reviews-grid`, `gallery`) with editable child blocks for cards/rows/reviews
- **Inline RichText editing** across every section — no ServerSideRender canvas, true WYSIWYG
- **Projects custom post type** with `tbc_project_category` taxonomy, gallery meta box for extra images, archive at `/projects/`, individual permalinks at `/projects/{slug}/`
- **Lightbox gallery** with graceful fallback to single project pages when JS is off
- **Contact Form 7 integration** — block picks the form via REST-powered SelectControl
- **One-click site setup** — Appearance → Theme Settings has a "Create / Repair Site Pages" button that auto-creates Home / About / Services / Gallery / Reviews / Contact pages, sets the front page, and assigns a primary nav menu

## Requirements

- WordPress 6.4+
- PHP 8.1+
- Node.js 18+ (for build)
- [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) (optional — needed for the Contact block)

## Install

```bash
# In your WP install:
cd wp-content/themes
git clone https://github.com/markwarddesign/tbone-construction.git
cd tbone-construction
npm install
npm run build      # builds block JS
npm run build:css  # builds Tailwind CSS
```

Then activate **T-Bone Construction** in Appearance → Themes. On first activation the setup routine will create the pages, set the front page, and wire up the primary menu.

## Development

```bash
npm run dev   # concurrent webpack + Tailwind watchers
```

Or run them separately:

```bash
npm run start      # block JS watcher
npm run watch:css  # Tailwind CSS watcher
```

## Directory layout

```
tbone-construction/
├── blocks/                       # Custom Gutenberg blocks
│   ├── _shared/                  # Shared JS modules (Lucide icon set, etc.)
│   ├── about-story/              # About page hero
│   ├── contact/                  # CF7 integration
│   ├── gallery/                  # Filterable project gallery + lightbox
│   ├── hero/                     # Home hero
│   ├── primary-nav/              # Sticky main nav + mobile drawer
│   ├── review-card/              # Child of reviews-grid
│   ├── reviews-grid/             # Reviews section parent
│   ├── service-card/             # Child of services
│   ├── service-row/              # Child of services-detail
│   ├── services/                 # Home services grid parent
│   ├── services-detail/          # Services page parent
│   ├── site-footer/              # Full site footer
│   ├── testimonial-quote/        # Dark single-quote band
│   ├── top-bar/                  # Phone/email top bar
│   └── trex-partnership/         # TrexPro partnership band
├── inc/
│   ├── data.php                  # Shared rendering partials
│   ├── post-types.php            # Projects CPT + taxonomy
│   ├── setup.php                 # First-run page/project/menu seeding
│   ├── svg.php                   # Lucide icon SVG library
│   └── theme-settings.php        # Appearance → Theme Settings admin page
├── parts/                        # FSE template parts (header, footer)
├── patterns/                     # Block patterns
├── src/style.css                 # Tailwind entry
├── templates/                    # FSE block templates
├── functions.php
├── theme.json
├── tailwind.config.js
└── package.json
```

## Architecture notes

- **Parent + child block model.** Repeating sections (`services`, `services-detail`, `reviews-grid`) use `InnerBlocks` with locked child blocks. Children expose RichText editing on the canvas + sidebar controls for icons, links, image uploads, etc.
- **CPT-driven gallery.** The gallery block queries `tbc_project` posts. Filter buttons populate from `tbc_project_category` terms in use. Each tile is an `<a>` link to the single page; JS upgrades clicks to a lightbox.
- **Theme tokens.** Palette and font families live in [`theme.json`](theme.json) and [`tailwind.config.js`](tailwind.config.js). Brand colors: `#faf8f5` (linen), `#1f2926` (ink), `#c25e24` (rust), `#eab308` (gold).
- **Icons** are Lucide-style inline SVGs. PHP definitions in [`inc/svg.php`](inc/svg.php); the matching React versions in [`blocks/_shared/icons.js`](blocks/_shared/icons.js) keep editor previews identical to frontend.

## License

GPL v2 or later
