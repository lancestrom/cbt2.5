## Quick orientation

This repository is a pair of CodeIgniter 3-based webapps in the workspace root:
- `cbt2.5/` — main student-facing app
- `cbt2.5admin/` — admin panel with parallel structure

Both are classic CI3 apps (no Composer autoload by default). Key entry points/configs live under `application/`.

## High-level architecture

- Framework: CodeIgniter 3 (conventional MVC: controllers in `application/controllers/`, models in `application/models/`, views in `application/views/`).
- Routing: `application/config/routes.php` — default controller is `Siswa_login` for the student app.
- Database: credentials and DB name in `application/config/database.php` (local DB file `database/cbt25.sql` present).
- Sessions: file sessions by default, cookie name `cbt25_session` (see `application/config/config.php`).

When making changes, update both `cbt2.5` and `cbt2.5admin` if the change affects shared models or DB schemas — they mirror each other.

## Developer workflows & quick commands

- Run locally via XAMPP: copy the app into your Apache htdocs (already under `/Applications/XAMPP/xamppfiles/htdocs/`) and start Apache+MySQL in XAMPP.
- Import the DB for local testing:

  mysql -u root -p < application/../database/cbt25.sql

- Enable runtime debug/logging: set `$config['log_threshold']` in `application/config/config.php` and ensure `ENVIRONMENT` != 'production' for `db_debug` in `database.php`.

## Project-specific conventions & patterns

- Models use the `Model_*` prefix (examples: `Model_siswa.php`, `Model_ujian.php`).
- Controller/view naming: views are grouped by role (e.g. `application/views/Siswa/`), and many filenames / UI text are Indonesian — expect identifiers in Bahasa Indonesia.
- No Composer autoload; any third-party libs are under `application/third_party/` (e.g. `spout`).
- Helpers/libraries are in `application/helpers/` and `application/libraries/` — extend CI using `MY_` prefix (`$config['subclass_prefix'] = 'MY_'`).

## Integration points & gotchas

- Database credentials are stored in plain PHP config files. Be careful when committing sensitive changes.
- A hard-coded `encryption_key` exists in `application/config/config.php`; rotating it will invalidate encrypted data and sessions.
- Many controllers rely on `$this->session->userdata('level')` checks — changing session keys or driver will affect auth flows.

## Files to inspect for common tasks

- Startup/routing: `application/config/config.php`, `application/config/routes.php`
- DB/schema & seed: `database/cbt25.sql`, `application/config/database.php`
- Authentication & flows: `application/controllers/Siswa_login.php`, `application/controllers/Dashboard.php`, `application/models/Model_login_siswa.php`
- Views and UI: `application/views/Siswa/` and `application/views/` directories

## What to do when you edit core behavior

1. Update controllers and models in both `cbt2.5` and `cbt2.5admin` if they share behavior.
2. Run DB migration / import if schema changes (no built-in migration enabled by default).
3. Increase `$config['log_threshold']` to capture errors and test flows locally.

---
If any section is unclear or you want this adapted for `cbt2.5admin/` as well, tell me which parts to expand and I will iterate.
