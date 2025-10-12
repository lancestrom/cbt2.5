<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Login controller
 *
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Model_login $Model_login
 */
class Login extends CI_Controller
{

    public function index()
    {

        $isi['title'] = 'Login Administrator';
        $this->load->view('tampilan_login', $isi);
    }

    public function proses_login()
    {
        $username = trim($this->input->post('username', TRUE));
        $password = $this->input->post('password', TRUE);

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Username dan Password harus diisi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('/');
            return;
        }

        $this->load->model('Model_login');
        $user = $this->Model_login->get_user_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Username dan Password salah<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('/');
            return;
        }

        $stored = $user->password;
        $verified = false;

        // Prefer password_hash()/password_verify(). If stored password looks like a bcrypt/hash, verify it.
        if (password_verify($password, $stored)) {
            $verified = true;
            // Rehash if outdated
            if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->Model_login->update_password($username, $newHash);
            }
        } else {
            // Fallback for legacy md5-stored passwords
            if ($stored === md5($password)) {
                $verified = true;
                // Migrate to password_hash
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->Model_login->update_password($username, $newHash);
            }
        }

        if ($verified) {
            $sess_data = array(
                'username' => $user->username,
                'level' => $user->level
            );
            $this->session->set_userdata($sess_data);
            $this->session->set_userdata('username', $user->username);
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Username dan Password salah<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('/');
            return;
        }
        // Redirect after successful login
        if ($this->session->userdata('level') == 'admin') {
            redirect('Dashboard');
        } elseif ($this->session->userdata('level') == 'adminakl') {
            redirect('Dashboard_akl');
        } elseif ($this->session->userdata('level') == 'adminbdp') {
            redirect('Dashboard_bdp');
        } elseif ($this->session->userdata('level') == 'adminotkp') {
            redirect('Dashboard_otkp');
        } elseif ($this->session->userdata('level') == 'admintkj') {
            redirect('Dashboard_tkj');
        } elseif ($this->session->userdata('level') == 'admindkv') {
            redirect('Dashboard_dkv');
        }
    }
}
