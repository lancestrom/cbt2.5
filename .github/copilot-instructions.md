## Quick context

- Codebase: CodeIgniter (v2/3-style) PHP web app using the standard CI layout: `application/`, `system/`, `assets/`, `vendor/`. Schema dump: `database/cbt25.sql`.
- Runtime: LAMP (Apache + PHP + MySQL). In this workspace the app is placed under XAMPP webroot: `htdocs/cbt2.5`.

## Big-picture architecture

- Controllers (`application/controllers/`) are HTTP entry points and orchestrate flows. `Dashboard.php` is the central admin controller.
- Models (`application/models/`) perform DB queries and business logic. All model classes are prefixed with `Model_` (e.g. `Model_siswa`, `Model_mapel`).
- Views (`application/views/`) contain templates and page fragments. Pages are assembled by loading `templates/header` (meta via `$isi2`), `tampilan_dashboard` (content via `$isi`) and `templates/footer`.
- CI core lives in `system/` — treat it as framework code; avoid edits unless you understand CI internals.

## Project-specific conventions (high-value, concrete)

- Auth guard: controller methods that require authentication call `$this->Model_keamanan->getKeamanan();` at the top. Search for this call to find protected endpoints.
- Controller view pattern: controllers set two arrays before rendering:
  - `$isi2` — meta (e.g. `title`) passed to `templates/header`
  - `$isi` — page data passed to `tampilan_dashboard`
    Then controllers load views:
    $this->load->view('templates/header', $isi2);
  $this->load->view('tampilan_dashboard', $isi);
  $this->load->view('templates/footer');
- Model names: always start with `Model_`. Load models in a controller constructor with `$this->load->model(array('Model_keamanan','Model_siswa', ...));` (see `Dashboard::__construct`).
- Flash messages: session flashdata keys `pesan` and `info` store raw Bootstrap HTML strings. When updating UI, preserve that markup or update both producers and the views that render them.
- DB naming: many tables use an `a_` prefix (e.g. `a_mapel`, `a_siswa`, `a_jadwal`). Use CI's query builder (`$this->db->insert`, `$this->db->where`, `$this->db->empty_table`).

## Integration points and I/O patterns

- Excel import: `application/third_party/spout/` (Box\Spout) is used. Controller code writes uploads to `temp_doc/`, parses rows, calls model `simpan` methods, and then `unlink()`s the temp file. Look for `ReaderEntityFactory` and `temp_doc` usage in `Dashboard.php`.
- File uploads: use CI's `upload` library configuration in controller methods. Uploaded files commonly land under `temp_doc/` and `upload/excel/`.
- Sessions & auth: `Model_keamanan` holds login/session logic; many controllers call it to verify permissions. Inspect `application/models/Model_keamanan.php` to see which session keys are required.

## How to run & debug locally (practical steps)

1. Put the repo under your webroot (example here: `/Applications/XAMPP/xamppfiles/htdocs/cbt2.5`).
2. Start Apache & MySQL (XAMPP). Import `database/cbt25.sql` into MySQL.
3. Update DB credentials in `application/config/database.php`.
4. Visit `http://localhost/cbt2.5/`.

Debug tips:

- Tail PHP/Apache logs (XAMPP control panel or `logs/`); CI also writes logs to `application/logs/`.
- If a controller returns blank pages, enable CI error reporting in `index.php` / `application/config/config.php` and check `application/logs/`.

## Code patterns & examples (concrete snippets to reuse)

- Protect endpoint example (any controller method):
  $this->Model_keamanan->getKeamanan();

- Typical insert (from `Dashboard::simpan_jadwal()`):
  $data = array('id' => rand(00000,99990), 'field' => $this->input->post('field'));
  $this->db->insert('a_jadwal', $data);
  $this->session->set_flashdata('pesan', '<div class="alert">...</div>');

- Excel import pattern (search for `ReaderEntityFactory`):
  - Upload file to `temp_doc/`
  - Create reader `ReaderEntityFactory::createXLSXReader()`
  - Iterate rows, map to arrays, call model save methods
  - `unlink()` temp file

## Known maintenance notes (observed from code)

- ID generation: code uses `rand(00000, 99990)` in places — collision risk. Prefer DB auto-increment or UUIDs when adding features that need unique IDs.
- Input validation is light in many controllers. New endpoints should add CI `form_validation` rules and sanitize `$this->input->post()` values before DB writes.
- Flashdata values contain raw HTML alerts — any change to alert HTML requires updating producers and the templates that render them.

## Quick search queries (what to grep for)

- Protected endpoints: getKeamanan(
- Excel import: ReaderEntityFactory|temp_doc
- DB operations: $this->db->insert|$this->db->empty_table

## Files to inspect first when starting work

- `application/controllers/Dashboard.php` — central flows, excel import, uploads
- `application/models/Model_keamanan.php` — auth/session rules
- `application/models/Model_*` — DB/business logic
- `application/views/templates/header.php` and `application/views/tampilan_dashboard.php` — how pages are assembled
- `application/config/database.php` and `application/config/routes.php` — environment and routing

---

If anything above is unclear or you'd like this file expanded with runnable snippets (for imports, migrations, or a small smoke-test), tell me which area to expand and I'll iterate.
