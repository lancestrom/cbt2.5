<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ujian extends CI_Model
{



    public function jadwalUjian()
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel,a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai,a_jadwal.waktu_selesai,((
TIME_TO_SEC(a_jadwal.waktu_selesai)-TIME_TO_SEC(a_jadwal.waktu_mulai) )) / 60 AS waktu
FROM `a_jadwal`
INNER join a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
