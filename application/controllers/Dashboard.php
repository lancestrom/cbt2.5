<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

/**
 * Dashboard controller
 *
 * @property CI_DB_active_record $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property Model_keamanan $Model_keamanan
 * @property Model_jurusan $Model_jurusan
 * @property Model_kelas $Model_kelas
 * @property Model_siswa $Model_siswa
 * @property Model_mapel $Model_mapel
 * @property Model_ujian $Model_ujian
 * @property Model_ruang $Model_ruang
 * @property CI_Upload $upload
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load model sekali saja di constructor
        // 'Model_keamanan', 'Model_jurusan', 'Model_kelas', 'Model_siswa', 'Model_mapel', 'Model_ujian', 'Model_ruang'
        $this->load->model(array(
            'Model_keamanan',
            'Model_jurusan',
            'Model_kelas',
            'Model_siswa',
            'Model_mapel',
            'Model_ujian',
            'Model_ruang'
        ));
        // Load common libraries used across controller methods
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['jurusan'] = $this->Model_jurusan->countJurusan();
        $isi['siswa'] = $this->Model_siswa->countSiswa();

        $isi['kelas'] = $this->Model_kelas->countKelas();
        $isi['mapel'] = $this->Model_mapel->countMapel();
        // $isi['ujian'] = $this->Model_ujian->countUjian();

        // Kelas
        $isi['x'] = $this->Model_siswa->dataSiswaX();
        $isi['xi'] = $this->Model_siswa->dataSiswaXI();
        $isi['xii'] = $this->Model_siswa->dataSiswaXII();

        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_home';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer', $isi);
    }

    public function jurusan()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['jurusan'] = $this->Model_jurusan->dataJurusan();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_jurusan';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function kelas()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['kelas'] = $this->Model_kelas->dataKelasMaster();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_kelas';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function hapus_all_kelas()
    {
        $this->Model_keamanan->getKeamanan();
        $this->db->empty_table('a_kelas');
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Kelas Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/kelas');
    }

    public function upload_kelas()
    {
        $this->Model_keamanan->getKeamanan();
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id'   => isset($cells[0]) ? trim((string)$cells[0]->getValue()) : null,
                                'kode' => isset($cells[1]) ? trim((string)$cells[1]->getValue()) : null,
                                'kelas' => isset($cells[2]) ? trim((string)$cells[2]->getValue()) : null
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_kelas->simpan($save);
                    $reader->close();
                    $tmpPath = 'temp_doc/' . $file['file_name'];
                    if (is_file($tmpPath)) {
                        @unlink($tmpPath);
                    }
                    $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Tambah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
                    redirect('Dashboard/kelas');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }

    public function mata_pelajaran()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['mapel'] = $this->Model_mapel->dataMapel();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_mata_pelajaran';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function buat_mapel_jadwal($id_mapel)
    {
        $this->Model_keamanan->getKeamanan();
        $isi['mapel'] = $this->Model_mapel->buat_mapel_jadwal($id_mapel);


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_buat_jadwal';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function simpan_jadwal()
    {
        $this->Model_keamanan->getKeamanan();
        // Validate incoming form data (trim + required). Use XSS-cleaned inputs when reading.
        $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required|trim');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai', 'required|trim');
        $this->form_validation->set_rules('waktu_selesai', 'Waktu Selesai', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed: preserve messages and redirect back to the form.
            $errors = validation_errors();
            $this->session->set_flashdata('pesan', '<div class="row"><div class="col-md mt-2"><div class="alert alert-danger alert-dismissible fade show" role="alert">' . $errors . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div></div></div>');
            $id_mapel = $this->input->post('id_mapel', TRUE);
            if (!empty($id_mapel)) {
                redirect('Dashboard/buat_mapel_jadwal/' . $id_mapel);
            }
            redirect('Dashboard/mata_pelajaran');
        }

        // Safer unique id: timestamp + random suffix (reduces collision risk vs rand alone).
        $id_jadwal = time() . mt_rand(1000, 9999);
        $data = array(
            'id_jadwal' => $id_jadwal,
            'id_mapel' => $this->input->post('id_mapel', TRUE),
            'tanggal_mulai' => $this->input->post('tanggal_mulai', TRUE),
            'waktu_mulai' => $this->input->post('waktu_mulai', TRUE),
            'waktu_selesai' => $this->input->post('waktu_selesai', TRUE)
        );

        $this->db->insert('a_jadwal', $data);
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Jadwal Berhasil Di Tambah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/mata_pelajaran');
    }

    public function hapus_all_mata_pelajaran()
    {
        $this->Model_keamanan->getKeamanan();
        $this->db->empty_table('a_mapel');
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/mata_pelajaran');
    }

    public function upload_mata_peajaran()
    {
        $this->Model_keamanan->getKeamanan();
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id_mapel'  => isset($cells[0]) ? trim((string)$cells[0]->getValue()) : null,
                                'id_kelas'  => isset($cells[1]) ? trim((string)$cells[1]->getValue()) : null,
                                'nama_mapel' => isset($cells[2]) ? trim((string)$cells[2]->getValue()) : null
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_mapel->simpan($save);
                    $reader->close();
                    $tmpPath = 'temp_doc/' . $file['file_name'];
                    if (is_file($tmpPath)) {
                        @unlink($tmpPath);
                    }
                    $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Tambah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
                    redirect('Dashboard/mata_pelajaran');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }


    public function siswa()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['siswa'] = $this->Model_siswa->dataSiswa();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_siswa';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }



    public function hapus_all_peserta_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        $this->db->empty_table('a_siswa');
        $this->session->set_flashdata('info', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Peserta Ujian Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/siswa');
    }

    public function upload_peserta_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id'          => isset($cells[0]) ? trim((string)$cells[0]->getValue()) : null,
                                'no_peserta'  => isset($cells[1]) ? trim((string)$cells[1]->getValue()) : null,
                                'nama_siswa'  => isset($cells[2]) ? trim((string)$cells[2]->getValue()) : null,
                                'kelas'       => isset($cells[3]) ? trim((string)$cells[3]->getValue()) : null,
                                'jurusan'     => isset($cells[4]) ? trim((string)$cells[4]->getValue()) : null,
                                'username'    => isset($cells[5]) ? trim((string)$cells[5]->getValue()) : null,
                                'password'    => isset($cells[6]) ? trim((string)$cells[6]->getValue()) : null,
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_siswa->simpanSiswa($save);
                    $reader->close();
                    $tmpPath = 'temp_doc/' . $file['file_name'];
                    if (is_file($tmpPath)) {
                        @unlink($tmpPath);
                    }
                    $this->session->set_flashdata('info', '
                    <div class="row">
                    <div class="col-md mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Data Peserta Ujian Berhasil Di Tambah</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    </div>');
                    redirect('Dashboard/siswa');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }

    public function jadwal_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['ujian'] = $this->Model_ujian->jadwalUjian();



        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Master/tampilan_ujian';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function hapus_all_jadwal()
    {
        $this->Model_keamanan->getKeamanan();
        $this->db->empty_table('a_jadwal');
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Jadwal Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/jadwal_ujian');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
