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

    public function detail_soal($id_jadwal)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
WHERE a_jadwal.id_jadwal='$id_jadwal';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function data_soal($id_jadwal)
    {
        $sql = "SELECT * FROM `soal`
WHERE id_jadwal='$id_jadwal';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function data_jadwal_siswa($sess, $jadwal)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel,a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_siswa.username='$sess' AND a_jadwal.tanggal_mulai='$jadwal';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function edit_jadwal_id($id_jadwal)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.id_mapel,a_mapel.nama_mapel,a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai,a_jadwal.waktu_selesai FROM a_jadwal
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
WHERE a_jadwal.id_jadwal='$id_jadwal';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function header_ujian_id($id_jadwal, $sess)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_siswa.nama_siswa,a_mapel.nama_mapel FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_jadwal.id_jadwal='$id_jadwal' AND a_siswa.username='$sess';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function soal_ujian_id($id_jadwal, $sess)
    {
        $sql = "SELECT soal.soal,soal.pilA,soal.pilB,soal.pilC,soal.pilD,soal.pilE FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
INNER JOIN soal
ON a_jadwal.id_jadwal=soal.id_jadwal
WHERE a_jadwal.id_jadwal='$id_jadwal' AND a_siswa.username='$sess';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    function simpan($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('soal', $data);
        }
    }
}
