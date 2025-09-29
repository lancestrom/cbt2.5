<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_mapel extends CI_Model
{
    public function countMapel()
    {
        $sql = "SELECT COUNT(*) AS mapel FROM `a_mapel`;";
        $query = $this->db->query($sql);
        return $query->row()->mapel;
    }

    public function dataMapel()
    {
        $sql = "SELECT * FROM `a_mapel`";
        $query = $this->db->query($sql);
        return $query->result_array;
    }

    function simpan($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('a_mapel', $data);
        }
    }
}
