<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_login_siswa extends CI_Model
{
    public function cek_login($username, $password)
    {
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        return $this->db->get('a_siswa');
    }
}
