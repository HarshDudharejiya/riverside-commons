# Riverside Commons - Drupal Assessment

This repository contains the completed frontend assessment for the Riverside Commons project. It features a custom Drupal theme utilizing Single Directory Components (SDCs), strictly adhering to Figma design fidelity and WCAG 2.2 accessibility standards.

## 🎥 Demonstration
**Watch the 2-3 minute walkthrough here:** https://www.loom.com/share/fb92b531399d491d84ff49a0671d36d3

## 📦 Included Artifacts
* **Database Dump:** `database/db.sql`
* **Files Directory:** already added so no need to add
* **Configuration:** `config/sync` and ddev settings files alredy have this setting

## 🚀 Setup & Reproduction Instructions

This project is built using **DDEV**. To reproduce this build from a clean clone so that `drush cim` reports no overrides, please follow these exact steps:

1. **Clone the repository and install dependencies:**
   ```bash
   git clone <your-repository-url>
   cd <your-repository-directory>
   ddev start
   ddev composer install
   ddev import-db database/db.sql
   ddev drush cr
   ddev drush uli

🚩 Questions & Flags (Architectural Reasoning)
In accordance with the evaluation criteria, here is a transparent look into specific decisions, cleanups, and challenges addressed during development:

1. Data Model & Backend Rationale
Pricing Logic (field_price & field_member_price): I chose to separate standard and member prices into two distinct Decimal fields rather than a complex combined field. This allows for clean conditional logic in the preprocess functions (e.g., gracefully falling back to "Free" if empty, or injecting the member discount note dynamically).

Dates vs. Presentation (field_dates & field_schedule): I implemented a Datetime Range field for structured, canonical data (vital for future sorting/calendar integrations). However, I also included a Short Text field_schedule to give content editors the flexibility to provide human-readable overrides (e.g., "Tuesdays, 6-8pm") exactly as shown in the design.

Taxonomy vs. Text: field_category utilizes a Taxonomy Term reference to power the Views exposed filter effectively. Conversely, field_level was kept as a standard text/list field, assuming a strict, non-expanding vocabulary (e.g., Beginner, Intermediate).

Granular Content Fields: I split the course details into specific fields (field_learn, field_included) rather than relying on a single massive WYSIWYG body. This guarantees the content maps perfectly to the distinct UI sections in the Figma design without relying on the editor to write custom HTML.

2. Contributed Modules
While the prompt suggested keeping the backend light, I included a few targeted contrib modules to bridge the gap between standard Drupal and a premium user experience:

Better Exposed Filters (better_exposed_filters): Standard Drupal Views exposed filters default to basic select dropdowns. I included BEF to allow for a more modern, accessible frontend UI for the category filtering, bringing the View closer to typical Figma filter patterns.

Pathauto & Token (pathauto, token): I included these to establish automated, semantic URL aliases for the Program nodes and Category terms. Clean URLs are a baseline requirement for technical SEO, and building this into the initial data model demonstrates a production-ready mindset.

Devel (devel): Utilized strictly for local development and debugging during the build process to inspect rendering arrays and data structures rapidly.

3. Accessibility & Figma Corrections (WCAG 2.2)
Touch Targets: The design's mobile navigation toggle and links did not meet WCAG 2.2 requirements. I enforced a minimum 44px target size for these interactive elements.

Color Contrast: I darkened the cancellation note text in the sticky sidebar to ensure it passes the 4.5:1 AA ratio for standard text on a white background.

Focus States: I implemented explicit :focus-visible outlines for keyboard navigators across the site (navigation, program cards), as the static design did not define them.

Expanded Click Targets: I applied a pseudo-element (::after) on the Program Card titles to stretch the clickable link across the entire card, making it far easier to interact with on touch devices.

4. SEO & Performance Notes
Metadata & JSON-LD: I dynamically injected Course/Event JSON-LD schema (and BreadcrumbList) via preprocess for the Program Detail page, mapping the custom fields to structured data.

Component Asset Loading: By utilizing Single Directory Components (SDC) and libraryOverrides, I ensured that the specific CSS and JS for the Site Navigation and Program Cards are only loaded on pages where those components are actually rendered, minimizing render-blocking resources.

5. Assumptions for Undefined States
Because the Figma file intentionally left some states undefined, I made the following assumptions:

Hover/Focus: Added subtle transform and box-shadow transitions to the Program Cards to make them feel interactive and indicate clickability.

Mobile Header: The Figma mobile design omitted the "Donate" CTA in the site header. I used a media query to hide it entirely on mobile, ensuring strict adherence to the comp.