<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_login extends CI_Model
{
    /**
     * Legacy method kept for compatibility.
     * Prefer using get_user_by_username() + password_verify in controllers.
     */
    public function cek_login($username, $pass)
    {
        $this->db->where("username", $username);
        $this->db->where("password", $pass);
        return $this->db->get('auth');
    }

    /**
     * Fetch user row by username.
     * Returns single row object or null.
     */
    public function get_user_by_username($username)
    {
        return $this->db->where('username', $username)->get('auth')->row();
    }

    /**
     * Update user's password hash (used to migrate from md5 to password_hash).
     */
    public function update_password($username, $newHash)
    {
        return $this->db->where('username', $username)->update('auth', array('password' => $newHash));
    }
}
