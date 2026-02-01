# Copilot instructions for this repository ✅

Short actionable notes for AI coding agents working on this CodeIgniter 3 PHP app.

## Project snapshot (big picture) 💡
- CodeIgniter 3-based web app (PHP 5.6+ recommended; composer.json lists PHP >= 5.3.7).
- MVC layout: controllers in `application/controllers/`, models in `application/models/`, views in `application/views/`.
- DB schema and starter data: `database/cbt25.sql` (import to MySQL for local dev).
- Single-page admin dashboard uses `application/views/tampilan_dashboard.php` as the shell that `load->view($content)` injects into.

## Important files to reference 🔧
- Routing: `application/config/routes.php` (default controller = `Siswa_login`).
- App config: `application/config/config.php` (note `encryption_key`, `sess_*` settings, `composer_autoload = FALSE`).
- DB config: `application/config/database.php` (local default: `root` / empty pw / `cbt25`).
- Example controller: `application/controllers/Dashboard.php` (auth checks, file uploads, Excel import via Spout).
- Example model: `application/models/Model_siswa.php` (raw SQL queries + `insert_batch` usage).
- Simple auth helper: `application/models/Model_keamanan.php` (calls `session->userdata('username')` and redirects if absent).
- Third-party library: `application/third_party/spout/` (loaded manually in controllers with `require_once`).

## Conventions & patterns to follow (do not invent) 📐
- Models follow `Model_<name>` class names (e.g., `Model_siswa`) and are loaded via `$this->load->model('Model_name')`.
- Controllers extend `CI_Controller`. Common pattern: call `$this->Model_keamanan->getKeamanan()` at top of controller methods to enforce login.
- Views are loaded via `$this->load->view('templates/header', $meta); $this->load->view('tampilan_dashboard', $data); $this->load->view('templates/footer');` — keep this structure.
- Flash Notices: `flashdata('pesan')` and `flashdata('info')` are used for user messages; mirror these keys when setting UI messages.
- Bulk imports: controllers use `temp_doc/` for uploads and `Model_*->simpan()` or `insert_batch` to load arrays directly into `a_`-prefixed tables.
- SQL style: the codebase frequently uses raw SQL (e.g., `$this->db->query($sql)`) rather than the query builder — follow existing style unless asked to refactor.

## Local dev / run steps (explicit) ▶️
1. Start Apache + MySQL (XAMPP or similar). Project root should be in your web root (example path in this repo: `htdocs/cbt2.5`).
2. Import `database/cbt25.sql` into MySQL (via phpMyAdmin or mysql CLI).
3. Update DB credentials in `application/config/database.php` if needed.
4. Confirm `application/config/config.php` has the proper `base_url` (this project attempts to auto-detect it). If pages 404, set `base_url` explicitly.
5. Visit `http://localhost/cbt2.5/` (default controller: `Siswa_login`).
6. To enable more verbose errors: set ENVIRONMENT to `development` (or set `CI_ENV`) in `index.php` and increase `log_threshold` in `config.php`.

## Debugging & testing notes 🐞
- No automated test suite detected. Unit tests are not present — be conservative with behavior changes.
- Use `application/logs/` and `log_threshold` for debugging messages; PHP errors follow `ENVIRONMENT` in `index.php`.
- To add quick instrumentation, follow existing logging style or use `$this->db->last_query()` for DB debugging.

## Integration points & external deps 🔗
- Excel import: `third_party/spout` (autoloader manually required in controllers; no active composer autoloading by default).
- File uploads go to `temp_doc/` and are removed after processing — keep file paths and cleanup steps consistent.

## Security & operational caveats ⚠️
- `encryption_key` is present in `config.php` — do not overwrite in PRs without reason.
- Session driver is `files` by default (configurable in `config.php`).
- There are commented remote DB credentials in `database.php` — don't reintroduce secrets to the codebase.
- Password handling is present in DB fields (check how passwords are created/checked before altering auth flows).

## Examples of common tasks (where to change code) 🛠️
- Add a new admin page: create controller method in `application/controllers/Dashboard.php`, add view to `application/views/`, and add a sidebar link in `tampilan_dashboard.php`.
- Add a new route: edit `application/config/routes.php` or rely on the default CI URI conventions.
- Add a third-party lib: place it under `application/third_party/` and `require_once` it in controllers as the existing Spout usage shows.

## What *not* to do / assumptions ✋
- Do not assume composer is enabled (set to `FALSE` in `config.php`). If enabling composer, make sure to run `composer install` and update config accordingly.
- Avoid sweeping refactors that change raw SQL into query builder without tests; changes should be incremental and tested on a local DB import.

---
If anything above is unclear or you'd like examples added (e.g., a short recipe for adding a new bulk-import job), tell me which part to expand and I'll iterate. ✅
