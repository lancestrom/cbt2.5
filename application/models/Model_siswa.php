<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_siswa extends CI_Model
{
    public function countSiswa()
    {
        $sql = "SELECT COUNT(*) as siswa FROM `a_siswa`";
        $query = $this->db->query($sql);
        return $query->row()->siswa;
    }

    public function dataSiswaX()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%X %'
GROUP BY a_siswa.kelas;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaXI()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%XI %'
GROUP BY a_siswa.kelas;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaXII()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.slug=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%XII %'
GROUP BY a_siswa.kelas;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswa()
    {
        $sql = "SELECT a_siswa.nama_siswa,a_jurusan.jurusan,a_kelas.kelas,a_siswa.username,a_siswa.password,IF(a_siswa.status=1,'AKTIF',null) AS keterangan FROM `a_siswa` 
INNER JOIN a_kelas on a_siswa.kelas=a_kelas.slug
INNER JOIN a_jurusan ON a_siswa.jurusan=a_jurusan.kode 
order by a_siswa.id;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaID($sess)
    {
        $sql = "SELECT a_siswa.id,a_siswa.nama_siswa,a_kelas.kelas,a_siswa.username,a_siswa.password,a_siswa.level FROM `a_siswa`
INNER JOIN a_kelas
ON a_siswa.kelas=a_kelas.slug
WHERE a_siswa.username='$sess';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }



    function simpanSiswa($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('a_siswa', $data);
        }
    }
}
