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

    public function uploadSoalID($id_jadwal)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel,a_kelas.kelas FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
WHERE a_jadwal.id_jadwal='$id_jadwal';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function simpan($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('a_soal', $data);
        }
    }
}
