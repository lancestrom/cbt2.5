# Copilot instructions for this repository ✅

Concise, actionable notes for AI coding agents working on this CodeIgniter 3 PHP app.

## Project snapshot (big picture) 💡
- CodeIgniter 3-based monolithic web app (target PHP ~5.6+). MVC layout: controllers in `application/controllers/`, models in `application/models/`, views in `application/views/`.
- Single-page admin shell: `application/views/tampilan_dashboard.php` — controllers load header, shell, footer in this order and inject page content into the shell.
- DB schema & seed: `database/cbt25.sql` (import for local development).

## Where to look (quick file map) 🔧
- Routes: `application/config/routes.php` (default controller: `Siswa_login`).
- App config: `application/config/config.php` (check `base_url`, `encryption_key`, `sess_*`, `composer_autoload`).
- DB: `application/config/database.php` and `database/cbt25.sql` (update local creds as needed).
- Auth / login examples: `application/controllers/Login.php`, `Siswa_login.php`, `Model_login.php`, `Model_login_siswa.php`.
- Auth helper: `application/models/Model_keamanan.php` (call `getKeamanan()` at top of protected controller methods).
- Example import & upload: `application/controllers/Dashboard.php` (uses `temp_doc/` and `third_party/spout/` for Excel import).
- Views & templates: `application/views/templates/` (header/footer), `application/views/tampilan_dashboard.php` (shell), plus `login/` and `siswa/` front-end folders under project root.

## Conventions & idioms to follow 📐
- Model naming: `Model_<name>` (e.g., `Model_siswa`) and loaded via `$this->load->model('Model_name')`.
- Controllers extend `CI_Controller`. Typical pattern: call `$this->Model_keamanan->getKeamanan()` early to enforce authentication.
- View rendering pattern (keep this):
  `$this->load->view('templates/header', $meta);
   $this->load->view('tampilan_dashboard', $data);
   $this->load->view('templates/footer');`
- Flash messages use `flashdata('pesan')` and `flashdata('info')` — use those keys when setting UI notices.
- Bulk imports: uploads saved to `temp_doc/` or `upload/excel/`, processed and then removed; use `insert_batch` for efficient inserts into `a_`-prefixed tables.
- DB style: project commonly uses raw SQL (`$this->db->query($sql)`) rather than the query builder — preserve style unless asked to refactor.
- Third-party libs under `application/third_party/` are manually required in controllers (no composer autoload by default).

## Local dev run & debug steps ▶️
1. Put the project under your web root (e.g., `htdocs/cbt2.5`) and start Apache + MySQL (XAMPP or similar).
2. Import `database/cbt25.sql` into MySQL.
3. Update `application/config/database.php` and `application/config/config.php` (`base_url`) as needed.
4. Visit `http://localhost/cbt2.5/` (default controller: `Siswa_login`).
5. For verbose errors: set `ENVIRONMENT` to `development` in `index.php` and increase `log_threshold` in `application/config/config.php`.
6. Use `application/logs/` and `$this->db->last_query()` for DB debugging.

## Quick PR checklist ✅
- Run manual smoke test locally (login flows, upload/import pages you changed).
- If you modify DB schema, update `database/cbt25.sql` and include migration notes in PR.
- Keep `encryption_key` and session settings unchanged unless required; avoid committing secrets.
- For file uploads, ensure temp files in `temp_doc/` are cleaned up after processing.
- Preserve raw SQL style for consistency; add tests or a careful rationale when changing to query builder.

## Integration & dependencies 🔗
- Excel import: `application/third_party/spout/` (loaded with `require_once` in controllers).
- Static assets & front-end: `assets/`, `login/`, and `siswa/` folders contain CSS/JS used by templates.

## Security & operational caveats ⚠️
- Do not reintroduce credentials (there are commented remote DB creds in `database.php`).
- `encryption_key` is important — avoid changing it without reason.
- Password handling lives in DB fields—inspect `Model_login*` before changing auth logic.

## Testing & instrumentation notes 🐞
- No automated tests found; be conservative with behavior changes and add migration/QA steps to PRs.
- For quick checks add logging to `application/logs/` or use `$this->db->last_query()` to inspect queries.

---
If anything above is unclear or you'd like short examples added (e.g., add a sample bulk-import controller or a short recipe for adding a page), tell me which part to expand and I'll iterate. ✅