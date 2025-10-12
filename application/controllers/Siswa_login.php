<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_login extends CI_Controller
{

    public function index()
    {

        $isi['title'] = 'Login Administrator';
        $this->load->view('Siswa/tampilan_login', $isi);
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->load->model('Model_login_siswa');
        $cek = $this->Model_login_siswa->cek_login($username, $password);

        if ($cek->num_rows() > 0) {
            foreach ($cek->result() as $ck) {
                $sess_data['username'] = $ck->username;
                $sess_data['level'] = $ck->level;
                $this->session->set_userdata($sess_data);
            }
            if ($sess_data['level'] == 'siswa') {
                redirect('Dashboard_siswa');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Username dan Password salah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
                redirect('/');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Username dan Password salah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
            redirect('/');
        }
    }
}
