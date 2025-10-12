# Copilot Instructions for cbt2.5 Codebase

## Overview

This is a PHP-based web application, likely using CodeIgniter (see `system/` and `application/` structure), for computer-based testing (CBT). The architecture is MVC, with controllers, models, and views organized under `application/`.

## Key Directories & Files

- `application/controllers/`: Main controllers (e.g., `Dashboard.php`, `Login.php`, `Siswa_login.php`, `Welcome.php`).
- `application/models/`: Data access and business logic (e.g., `Model_siswa.php`, `Model_ujian.php`).
- `application/views/`: UI templates, organized by feature (e.g., `tampilan_dashboard.php`, `tampilan_login.php`).
- `application/config/`: Configuration files (e.g., `config.php`, `database.php`, `routes.php`).
- `system/`: Core framework files (do not modify unless extending framework behavior).
- `assets/`, `login/`, `siswa/`: Static files (CSS, JS, images) for different user roles and UI themes.
- `upload/`: File uploads, including exam data and images.
- `application/third_party/spout/`: External PHP library for spreadsheet import/export (see its `README.md`).

## Developer Workflows

- **No build step required**: PHP files are interpreted directly. Place new code in the appropriate MVC folder.
- **Testing**: No automated test suite detected. Manual browser testing is standard. For Spout library, run `phpunit` in its directory for library tests.
- **Debugging**: Use browser dev tools and PHP error logs (`application/logs/`).
- **Database**: SQL schema in `database/cbt25.sql`. Update this file for schema changes.

## Project-Specific Patterns

- **MVC conventions**: Controllers load models and views explicitly. Example:
  ```php
  $this->load->model('Model_siswa');
  $this->load->view('tampilan_siswa', $data);
  ```
- **Role-based UI**: Separate static assets and views for admin, siswa (student), and login flows.
- **Excel/CSV Import/Export**: Use Spout library (`application/third_party/spout/`) for handling large spreadsheet files efficiently.
- **Configuration**: All app config in `application/config/`. Use `routes.php` for URL routing.
- **Uploads**: Store exam images and Excel files in `upload/` subfolders. Reference these paths in code.

## Integration Points

- **Spout**: For spreadsheet operations, see its documentation and `README.md`.
- **Composer**: If adding new PHP libraries, update `composer.json` and run `composer install`.

## Conventions & Gotchas

- **Do not edit files in `system/` unless extending CodeIgniter core.**
- **Keep uploads and static assets organized by user role and feature.**
- **Manual testing is the norm; add tests if introducing critical logic.**
- **Database changes require updating both SQL and relevant models.**

## Example: Adding a New Feature

1. Create a controller in `application/controllers/`.
2. Add a model in `application/models/` if needed.
3. Create a view in `application/views/`.
4. Update `application/config/routes.php` for new URLs.
5. Add static assets in the appropriate folder.

---

For questions about Spout, see `application/third_party/spout/README.md`.
For framework details, refer to CodeIgniter documentation.
