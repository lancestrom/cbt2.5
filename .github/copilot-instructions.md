## Quick context

- This repository is a CodeIgniter (v2/3 style) PHP web app arranged in the standard CI layout: `application/`, `system/`, `assets/`, `vendor/`, and an SQL dump at `database/cbt25.sql`.
- Primary runtime target is a LAMP stack (the workspace lives under XAMPP `htdocs` in this workspace). Expect Apache + PHP + MySQL when running locally.

## High level architecture (big picture)

- Controllers: `application/controllers/` — entry points for HTTP requests. Example: `Dashboard.php` orchestrates most admin flows.
- Models: `application/models/` — DB interactions and business logic. Model classes are prefixed with `Model_` (e.g. `Model_mapel`, `Model_siswa`).
- Views: `application/views/` — HTML/templating. Views are composed using `templates/header`, `tampilan_dashboard`, and individual page fragments (e.g. `tampilan_siswa.php`).
- System: `system/` contains the CodeIgniter core. Treat it as framework code — don't change unless you know CI internals.
- Third-party: `application/third_party/spout/` used for Excel import via Box\Spout. The autoloader is required in `Dashboard.php`.

## Key conventions and idioms to follow

- Controller pattern: controllers typically call `$this->Model_keamanan->getKeamanan();` at the top of methods to enforce auth. Search for this call to find protected endpoints.
- Controllers populate two arrays before loading views: `$isi` (page data) and `$isi2` (meta like `title`). Then they call:

  $this->load->view('templates/header', $isi2);
  $this->load->view('tampilan_dashboard', $isi);
  $this->load->view('templates/footer');

- Model names always start with `Model_`. Use `$this->load->model(array(...))` in the controller constructor (see `Dashboard::__construct`).
- Flash messages: session flashdata keys used are `pesan` and `info`, and their values are raw HTML strings with Bootstrap alert markup (don't change these strings' structure unless updating front-end markup accordingly).
- Database conventions: many tables have an `a_` prefix (for example `a_mapel`, `a_jadwal`, `a_kelas`, `a_siswa`). Use CI's query builder (`$this->db->insert`, `$this->db->empty_table`) for DB operations.
- Excel import: imports write to `./temp_doc/` then call `unlink()` to remove files. Allowed upload types are `xlsx|xls` and Box\Spout is used to parse rows.

## Files and directories you will frequently edit or inspect

- Controllers: `application/controllers/Dashboard.php` (central admin flows)
- Models: `application/models/Model_*` (business logic and DB queries)
- Views: `application/views/` and `application/views/Ujian/` for exam/jadwal related pages
- Config: `application/config/` (database credentials, routes — edit `database.php` when changing DB connection)
- SQL schema: `database/cbt25.sql` — import this in MySQL for a local dev DB
- Third-party Excel reader: `application/third_party/spout/` and its `README.md`

## How to run locally (discoverable steps)

1. Ensure code is in your web root (here it lives under XAMPP `htdocs/cbt2.5`).
2. Start Apache & MySQL (via XAMPP). Import `database/cbt25.sql` into MySQL (phpMyAdmin or mysql CLI).
3. Update `application/config/database.php` with your DB credentials.
4. Open the app at `http://localhost/cbt2.5/` (or the configured base URL).

Note: there is no app-specific build step. PHP files are interpreted by the server at runtime.

## Common patterns and examples (copyable intent)

- Protect an endpoint: add `$this->Model_keamanan->getKeamanan();` at the top of the controller method.
- Add a model: create `application/models/Model_new.php` and load with `$this->load->model('Model_new');` (or add to the array in the controller constructor).
- Example: `simpan_jadwal()` in `Dashboard.php` shows a typical insert flow:
  - gather inputs with `$this->input->post('field')`
  - build `$data = array(...)` and call `$this->db->insert('a_jadwal', $data);`
  - set flashdata with `$this->session->set_flashdata('pesan', '<div>...</div>')` and `redirect()` to the listing.

## Integration points & external behavior to keep in mind

- Excel imports: use Box\Spout (`ReaderEntityFactory::createXLSXReader()`), iterate sheets/rows — the code writes raw cell objects to arrays before passing them to model `simpan` methods.
- File uploads use CI's `upload` library configured in the controller method and files are stored in `temp_doc/` before being removed.
- Session-based auth: see `Model_keamanan` (inspect this model to understand login flow and session keys). Many controller methods rely on it.

## Safety and maintainability notes (observations you may act on)

- ID generation with `rand(00000, 99990)` (e.g. `simpan_jadwal`) may cause collisions; if adding new features, consider switching to auto-increment DB ids or UUIDs.
- Input sanitization and validation are minimal/absent in many controllers. When adding user-input endpoints, add CI `form_validation` rules and avoid directly inserting raw `$this->input->post()` values.
- Flashdata contains raw HTML. If changing front-end templating, update the alert markup and where flashdata is rendered.

## Quick search tips

- Find protected endpoints: search for `getKeamanan(`
- Find imports: search for `ReaderEntityFactory` or `temp_doc`
- Find table operations: search for `$this->db->insert`, `$this->db->empty_table`

## When merging or changing templates

- The UI is assembled through `templates/header`, `tampilan_dashboard`, and `templates/footer`. Keep the `title` value in `$isi2['title']` consistent when adding pages.

---

If any part above is unclear or you want this file to include code snippets for tests or a small checklist for PR reviewers, tell me which area to expand (auth flow, DB schema, Excel import, or view composition) and I will iterate.
