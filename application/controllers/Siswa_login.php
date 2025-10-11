<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_login extends CI_Controller
{

    public function index()
    {
        $this->load->view('Siswa/tampilan_login');
    }
}
