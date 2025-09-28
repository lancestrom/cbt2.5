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
        $sql = "SELECT concat(a_mapel.id_mapel,a_mapel.id_kelas) AS id,a_kelas.kelas,a_mapel.nama_mapel FROM `a_mapel`
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id;";
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
