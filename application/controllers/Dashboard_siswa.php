<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_siswa extends CI_Controller
{


    public function index()
    {
        $sess = $this->session->userdata('username');
        $isi['siswa'] = $this->Model_siswa->dataSiswaID($sess);
        $this->load->view('Siswa/tampilan_siswa', $isi);
    }
}
