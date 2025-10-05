<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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
                                'id'              => $cells[0],
                                'kode'     => $cells[1],
                                'kelas'            => $cells[2]
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_kelas->simpan($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
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
        $id_jadwal = rand(00000, 99990);
        $id_mapel = $this->input->post('id_mapel');
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $waktu_mulai = $this->input->post('waktu_mulai');
        $waktu_selesai = $this->input->post('waktu_selesai');

        $data = array(
            'id_jadwal' => $id_jadwal,
            'id_mapel' => $id_mapel,
            'tanggal_mulai' => $tanggal_mulai,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai
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
                                'id_mapel'              => $cells[0],
                                'id_kelas'     => $cells[1],
                                'nama_mapel'            => $cells[2]
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_mapel->simpan($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
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
                                'id'              => $cells[0],
                                'no_peserta'      => $cells[1],
                                'nama_siswa'      => $cells[2],
                                'kelas'           => $cells[3],
                                'jurusan'         => $cells[4],
                                'username'        => $cells[5],
                                'password'        => $cells[6],
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_siswa->simpanSiswa($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
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
        $isi['content'] = 'Ujian/tampilan_ujian';
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
