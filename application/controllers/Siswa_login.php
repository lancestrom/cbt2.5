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

        $siswa = $this->db->get_where(
            'a_siswa',
            ['username' => $username, 'password' => $password]
        )->row_array();

        $this->load->model('Session_Model');
        $session_id = bin2hex(random_bytes(32));
        $ipaddress = $this->input->ip_address();

        // Simpan session ke database
        if ($this->Session_Model->create_session($session_id, $username, $ipaddress)) {
            // Set cookie untuk session
            $this->input->set_cookie(array(
                'name' => 'app_session_id',
                'value' => $session_id,
                'expire' => 86400, // 24 jam
                'httponly' => TRUE,
                'secure' => FALSE // Set ke TRUE jika pakai HTTPS
            ));

            // Set session CodeIgniter
            $sess_data = array(
                'username' => $username,
                'session_id' => $session_id,
                'logged_in' => TRUE
            );
        }

        if ($siswa['status'] == '1') {
            $sess_data['username'] = $siswa['username'];
            $sess_data['level'] = $siswa['level'];

            $this->session->set_userdata($sess_data);

            if ($sess_data['level'] == 'siswa') {
                redirect('Dashboard_siswa');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Username / Password salah / Akun Terblockir
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
            redirect('/');
        }
    }
}
