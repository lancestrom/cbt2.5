# Copilot Instructions for cbt2.5 Codebase

## Overview

This is a PHP-based web application, likely using CodeIgniter (see `system/` and `application/` structure), for computer-based testing (CBT). The architecture is MVC, with controllers, models, and views organized under `application/`.

```markdown
# Copilot instructions — cbt2.5 (CodeIgniter PHP app)

This file gives focused, discoverable knowledge for an AI code agent to be productive quickly.

Key facts

- Codebase is a CodeIgniter-style MVC app under `application/` with the framework in `system/` and a web entry at `index.php`.
- Database schema: `database/cbt25.sql`. Many controllers/models expect a MySQL/MariaDB connection configured in `application/config/database.php`.
- No build step. Run under a PHP web server (XAMPP, php -S, or Apache). Static assets live in `assets/`, `login/`, and `siswa/`.

Important locations (examples)

- Controllers: `application/controllers/` — e.g. `Login.php`, `Siswa_login.php`, `Dashboard.php`, `Dashboard_siswa.php`.
- Models: `application/models/` — prefixed `Model_` (e.g. `Model_siswa.php`, `Model_ujian.php`). Models are loaded with `$this->load->model('Model_siswa');`.
- Views: `application/views/` — many view files use the `tampilan_` prefix (e.g. `tampilan_dashboard.php`, `tampilan_login.php`).
- Config: `application/config/config.php`, `application/config/database.php`, `application/config/routes.php`.
- Uploads: `upload/excel/`, `upload/soal_gambar/` — code expects these paths for import and media files.
- Third-party libs: `application/third_party/spout/` (spreadsheet import/export). See its `README.md` for phpunit tests.

What to change (rules for agents)

- Do not modify files in `system/` unless you are intentionally extending CI core behavior.
- Follow the naming patterns: controllers in PascalCase, models prefixed `Model_`, views often prefixed `tampilan_`.
- When adding features: create Controller → Model (if DB access) → View → register route in `application/config/routes.php` → add static files under `assets/` or role-specific folders.
- Database changes must be reflected in `database/cbt25.sql` and the corresponding model queries.

Debugging & local run notes

- Run under XAMPP (this repo sits in htdocs) or with `php -S localhost:8000` pointing to project root and ensure PHP's mysqli is available.
- Check runtime errors and logs at `application/logs/`. Session settings are in `application/config/config.php` (verify `sess_save_path`).

Patterns and gotchas (from the codebase)

- Role-based UI: admin vs siswa (student) flows are separated into different view/asset folders — reuse those conventions when adding UI.
- File uploads and spreadsheet imports use `upload/` subfolders and the Spout library — prefer Spout for large Excel files to avoid memory issues.
- Controllers often directly access `$this->db` and models; business logic is mixed between models and controllers in places — search for shared helpers in `application/helpers/`.

Integration points

- Spout for Excel: `application/third_party/spout/` (import/export). Run tests with phpunit inside that folder if needed.
- Composer is present (`composer.json`). If you add external packages, update composer and commit `composer.lock`.

Examples to reference while coding

- Loading a model and view: `application/controllers/Siswa_login.php` (look for `$this->load->model` / `$this->load->view`).
- Database schema updates: `database/cbt25.sql` contains the canonical schema to update when adding fields/tables.

If something is unclear

- Point to a specific controller/model/view and ask for examples to modify. I will open those files and produce a minimal, runnable patch.
```

2. Add a model in `application/models/` if needed.
