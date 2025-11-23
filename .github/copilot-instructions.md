## Repo snapshot

This is a static HTML template-based website (MEDIVESTA) adapted from a Bootstrap 3 theme.
- Main entry: `index.html` (also `index-2.html`).
- Styles: `css/style.css` (compiled); source SASS lives in `sass/` (e.g. `sass/style.scss`).
- Scripts: `js/script.js` (project JS), vendor libs under `js/vendor/` (jQuery, Owl, Isotope, etc.).
- Server-side: simple PHP form handler at `php/form-process.php` (contact forms post here).
- Assets: `images/`, `fonts/`, `css/vendor/`.

## High-level architecture & why

- Purely front-end HTML/CSS/JS template. No Node/npm build files detected. The CSS in `css/style.css` appears to be the shipped compiled file while the `sass/` folder contains the source SASS.
- JavaScript behavior is driven by jQuery and a set of vendor plugins in `js/vendor/`. `js/script.js` wires the UI (slides, carousels, isotope filters, popups, maps).
- Forms rely on a minimal PHP endpoint (`php/form-process.php`) — to test form flows you must run a PHP-capable server.

## Quick tasks & concrete commands (PowerShell)

- Serve as static site (no PHP required): open `index.html` in browser or use a static server (Live Server extension).
- To test forms / PHP: run a PHP built-in server from the workspace root in PowerShell:

  php -S localhost:8000 -t .\MEDIVESTA

  Then open http://localhost:8000/MEDIVESTA/index.html

- To edit styles: modify SASS under `sass/` and compile to `css/style.css` with your SASS compiler (not included). Example (requires dart-sass installed):

  sass --watch .\MEDIVESTA\sass:.\MEDIVESTA\css

  (Adjust command to your environment; the repo does not include a package.json or build scripts.)

## Project-specific patterns / conventions

- Navigation links are literal filenames (e.g. `<a href="about-company.html">`). Adding a page usually requires adding the file in root and updating the nav in `index.html` (and other templates).
- Isotope-based portfolio: markup uses `.grid-services` and filter anchors with `data-filter` attributes. Example: `ul.portfolio_filter > li > a[data-filter=".eco"]` toggles items having class `eco`.
- Main JS entry is `js/script.js`. Keep vendor libraries in `js/vendor/` and include them before `js/script.js` (current ordering matters — modernizr in head, vendor scripts before the final script include).
- Forms: front-end validation uses `js/vendor/validator.min.js` + `js/vendor/form-scripts.js`; the POST target is `php/form-process.php`.
- Google Maps integration expects a DOM element with id `maps` and uses `data-lat`, `data-lng`, `data-marker` attributes in the HTML to set up the map. The template currently loads Google Maps API without a key — add your API key if needed.

## Integration & external dependencies

- External vendor libraries are stored locally under `js/vendor/` and `css/vendor/` (no CDN dependency for those). jQuery and bootstrap are included locally.
- Google Maps API is loaded via the remote script tag in `index.html` — you may need to add an API key depending on your usage.
- Contact/email relies on `php/form-process.php` which may use PHP `mail()` or custom logic — inspect that file before changing email behavior.

## Debugging tips (project-specific)

- If UI items like sliders, carousels, or popups fail: check console for jQuery plugin load order. Plugins must be included before `js/script.js`.
- If styles don't reflect SASS edits: confirm you are editing the correct `.scss` in `sass/` and then recompile to `css/style.css`. The site references `css/style.css` directly.
- Forms not submitting? Run the PHP server (see commands above) and inspect network requests in DevTools — `php/form-process.php` must return expected responses.

## Small examples to copy/paste

- Add a new filter button for Isotope:

  <li><a href="" data-filter=".newcategory">New category</a></li>

- Map element example (set lat/lng via data attrs):

  <div id="maps" data-lat="6.9271" data-lng="79.8612" data-marker="images/marker.png"></div>

## Where to look next (important files)

- `index.html` — main template and navigation.
- `js/script.js` — custom interactive behavior and plugin wiring.
- `js/vendor/` and `css/vendor/` — third-party libs; keep ordering intact.
- `sass/` — SASS source; edit here then compile into `css/style.css`.
- `php/form-process.php` — server-side form handler used by contact pages.

If any of these sections are unclear or you'd like me to include CI/setup commands (installing dart-sass, adding a simple npm script, or wiring a local test harness), tell me which you'd prefer and I'll update the file. Also please confirm whether you want the SASS compile command added as an opinionated recipe (which requires installing a compiler).
