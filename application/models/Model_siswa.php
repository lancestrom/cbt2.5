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

    public function dataSiswaMoodle()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended  NOT IN (1) AND firstname not IN('ADMINISTRATOR')";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlock()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0);";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function header_akun_siswa($id_kelas)
    {
        $sql = "SELECT a_siswa.*,a_kelas.*,a_jurusan.*,a_kelas.kelas AS nama_kelas FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.kelas='$id_kelas';";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function akun_siswa($id_kelas)
    {
        $sql = "SELECT a_siswa.*,a_kelas.*,a_jurusan.*,a_kelas.kelas AS nama_kelas FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.kelas='$id_kelas';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaAKL()
    {
        $sql = "SELECT * FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.jurusan LIKE '%akl%';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function dataSiswaBDP()
    {
        $sql = "SELECT * FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.jurusan LIKE '%pm%';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function dataSiswaOTKP()
    {
        $sql = "SELECT * FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.jurusan LIKE '%mplb%';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function dataSiswaTKJ()
    {
        $sql = "SELECT * FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.jurusan LIKE '%tjkt%'
                ORDER BY a_siswa.id ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function dataSiswaDKV()
    {
        $sql = "SELECT * FROM `a_siswa`
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                INNER JOIN a_jurusan
                ON a_siswa.jurusan=a_jurusan.kode
                WHERE a_siswa.jurusan LIKE '%dkv%'
				ORDER BY a_siswa.id ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    function simpanSiswa($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('a_siswa', $data);
        }
    }
}
