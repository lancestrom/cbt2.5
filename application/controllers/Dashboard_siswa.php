<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_siswa extends CI_Controller
{


    public function index()
    {
        $this->Model_keamanan->getKeamanan();
        $sess = $this->session->userdata('username');


        // $cek = $this->Model_ujian->cek_mepel_user($sess);

        $jadwal = date('Y-m-d');
        $waktu =  date('H:i:s');
        $isi['siswa'] = $this->Model_siswa->dataSiswaID($sess);
        $isi['ujian'] = $this->Model_ujian->data_jadwal_siswa($sess, $jadwal, $waktu);

        $this->load->view('Siswa/templates/header');
        $this->load->view('Siswa/tampilan_siswa', $isi);
        $this->load->view('Siswa/templates/footer');
    }

    public function detail_soal($id_jadwal)
    {
        $this->Model_keamanan->getKeamanan();

        $sess = $this->session->userdata('username');

        $benar = "";
        $isi['siswa'] = $this->Model_siswa->dataSiswaID($sess);
        // $isi['soal'] = $this->Model_ujian->soal_ujian_id_username($id_jadwal, $sess);
        // $isi['ujian'] = $this->Model_ujian->detail_mapel($id_jadwal);


        $isi['ujian'] = $this->Model_ujian->detail_mapel($id_jadwal, $sess);
        $this->load->view('Siswa/templates/header');
        $this->load->view('Siswa/tampilan_detail_ujian', $isi);
        $this->load->view('Siswa/templates/footer');
    }

    public function simpan_status_peserta()
    {
        $this->Model_keamanan->getKeamanan();
        $sess = $this->session->userdata('username');

        $id_jadwal = $this->input->post('id_jadwal');
        $username = $this->input->post('username');
        $status = "MENGERJAKAN";

        $data = array(
            'id_jadwal' => $id_jadwal,
            'username' => $username,
            'status' => $status
        );

        $this->db->insert('siswa_status', $data);
        redirect('Dashboard_siswa/ujian_siswa/' . $id_jadwal);
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
        $id_mapel = $this->input->post('id_mapel');


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
                    'id_mapel' => $id_mapel

                );
            }
            if (count($batch) > 0) {
                $this->db->insert_batch('siswa_jawab', $batch);
            }
        }

        // keep previous behaviour: destroy session and redirect to home

        $sess = $this->session->userdata('username');

        $data = array(
            'status' => 'SELESAI'
        );

        $this->db->where('username', $sess);
        $this->db->update('siswa_status', $data);

        $this->db->delete('siswa_login', array('username' => $sess));
        $this->session->sess_destroy();
        redirect('/');
    }

    public function logout()
    {
        $sess = $this->session->userdata('username');
        $this->db->delete('siswa_login', array('username' => $sess));
        $this->session->sess_destroy();
        redirect('/');
    }
}
