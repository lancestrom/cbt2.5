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
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel,a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai,a_jadwal.waktu_selesai FROM `a_jadwal`
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_siswa.username='$sess' AND a_jadwal.tanggal_mulai='$jadwal'";
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

    public function soal_ujian_id_perkelas($id_jadwal, $sess)
    {
        $sql = "SELECT concat(soal.id_soal,a_jadwal.id_jadwal,a_mapel.id_mapel,a_kelas.id) AS id_ujian, a_mapel.nama_mapel, a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai,a_jadwal.waktu_selesai,soal.soal,soal.pilA,soal.pilB,soal.pilC,soal.pilD,soal.pilE,soal.kunci FROM `soal`
INNER JOIN a_jadwal
ON soal.id_jadwal=a_jadwal.id_jadwal
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_siswa.kelas=a_kelas.slug
WHERE a_jadwal.id_jadwal='$id_jadwal' AND a_siswa.username='$sess';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function soal_ujian_id_username($id_jadwal, $sess)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_jadwal.id_mapel,jadwal_soal.id_bank_soal,soal.id_soal,a_siswa.username,a_mapel.nama_mapel,
soal.id_soal, soal.soal,soal.pilA,soal.pilB,soal.pilC,soal.pilD,soal.pilE,soal.kunci
FROM `jadwal_soal`
INNER JOIN a_jadwal
ON jadwal_soal.id_jadwal=a_jadwal.id_jadwal
INNER JOIN a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
INNER JOIN bank_soal
ON jadwal_soal.id_bank_soal=bank_soal.id_bank_soal
INNER JOIN soal
ON bank_soal.id_bank_soal=soal.id_bank_soal
INNER JOIN a_kelas
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_jadwal.id_jadwal='$id_jadwal' AND a_siswa.username='$sess';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function cek_mepel_user($sess)
    {
        $sql = "SELECT * FROM `siswa_jawab`
INNER JOIN a_siswa
on siswa_jawab.username=a_siswa.username
INNER JOIN a_kelas
ON a_siswa.kelas=a_kelas.slug
INNER JOIN a_mapel
ON a_mapel.id_kelas=a_kelas.id
INNER JOIN a_jadwal
ON a_jadwal.id_mapel=a_mapel.id_mapel
WHERE siswa_jawab.username='$sess';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function detail_mapel($id_jadwal)
    {
        $sql = "SELECT a_jadwal.id_jadwal,a_mapel.nama_mapel,a_jadwal.tanggal_mulai,a_jadwal.waktu_mulai,a_jadwal.waktu_selesai,a_jadwal.durasi
FROM `a_jadwal`
INNER JOIN  a_mapel
ON a_jadwal.id_mapel=a_mapel.id_mapel
WHERE a_jadwal.id_jadwal='$id_jadwal';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }


    function simpan($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('soal', $data);
        }
    }
}