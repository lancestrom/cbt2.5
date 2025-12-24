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
        // $isi['ujian'] = $this->Model_ujian->soal_ujian_id($id_jadwal, $sess);
        $isi['soal'] = $this->Model_ujian->soal_ujian_id_username($id_jadwal, $sess);

        $this->load->view('Siswa/templates/header');
        $this->load->view('Siswa/tampilan_soal_ujian', $isi);
        $this->load->view('Siswa/templates/footer');
    }

    public function simpan_jawaban()
    {
        // expect answers as array: jawaban[<id_soal>] = 'A'|'B'|...
        $jawaban = $this->input->post('jawaban');
        $username = $this->session->userdata('username');


        if (!empty($jawaban) && is_array($jawaban)) {
            $batch = array();
            foreach ($jawaban as $id_soal => $pil) {
                // sanitize basic
                $id_soal = intval($id_soal);
                $pil = substr($this->db->escape_str($pil), 0, 1);
                $batch[] = array(
                    'username' => $username,
                    'soal_id' => $id_soal,
                    'jawaban' => $pil,

                );
            }
            if (count($batch) > 0) {
                $this->db->insert_batch('siswa_jawab', $batch);
            }
        }

        // keep previous behaviour: destroy session and redirect to home
        $this->session->sess_destroy();
        redirect('/');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
