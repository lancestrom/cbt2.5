<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_siswa extends CI_Controller
{


    public function index()
    {
        $this->Model_keamanan->getKeamanan();
        $sess = $this->session->userdata('username');
        $jadwal = date('Y-m-d');
        $isi['siswa'] = $this->Model_siswa->dataSiswaID($sess);
        $isi['ujian'] = $this->Model_ujian->data_jadwal_siswa($sess, $jadwal);

        $this->load->view('Siswa/templates/header');
        $this->load->view('Siswa/tampilan_siswa', $isi);
        $this->load->view('Siswa/templates/footer');
    }

    public function ujian_siswa($id_jadwal)
    {
        $this->Model_keamanan->getKeamanan();
        $sess = $this->session->userdata('username');
        $isi['siswa'] = $this->Model_ujian->header_ujian_id($id_jadwal, $sess);
        $isi['ujian'] = $this->Model_ujian->soal_ujian_id($id_jadwal, $sess);

        $this->load->view('Siswa/templates/header');
        $this->load->view('Siswa/tampilan_soal_ujian', $isi);
        $this->load->view('Siswa/templates/footer');
    }
}
