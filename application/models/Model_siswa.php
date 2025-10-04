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

    public function countSiswaMoodle()
    {
        $sql = "SELECT COUNT(*) AS jumlah_siswa_moodle FROM `cbt_user`
        WHERE firstname  NOT IN ('ADMINISTRATOR') AND id NOT IN(1);";
        $query = $this->db->query($sql);
        return $query->row()->jumlah_siswa_moodle;
    }

    public function countSiswaMoodleAktif()
    {
        $sql = "SELECT COUNT(*) AS siswa_aktif FROM `cbt_user`
WHERE firstname  NOT IN ('ADMINISTRATOR') AND id NOT IN(1) AND suspended NOT IN (1);";
        $query = $this->db->query($sql);
        return $query->row()->siswa_aktif;
    }

    public function countSiswaMoodleNONAktif()
    {
        $sql = "SELECT COUNT(*) AS siswa_non_aktif FROM `cbt_user`
WHERE firstname  NOT IN ('ADMINISTRATOR') AND id NOT IN(1) AND suspended IN (1);";
        $query = $this->db->query($sql);
        return $query->row()->siswa_non_aktif;
    }

    //     public function countSiswaMoodleLogin()
    //     {
    //         $sql = "SELECT COUNT(*) AS siswa_login FROM `cbt_sessions`
    // INNER JOIN cbt_user
    // ON cbt_sessions.userid=cbt_user.id
    // WHERE cbt_user.firstname NOT IN ('ADMINISTRATOR')
    // GROUP BY cbt_user.id;";
    //         $query = $this->db->query($sql);
    //         return $query->row()->siswa_login;
    //     }

    //     public function countSiswaMoodleBelumLogin()
    //     {
    //         $sql = "SELECT COUNT(*) AS siswa_belum_login FROM `cbt_user`
    // WHERE cbt_user.firstaccess IN (0) AND cbt_user.username NOT IN ('guest') AND cbt_user.firstname NOT IN ('ADMINISTRATOR');";
    //         $query = $this->db->query($sql);
    //         return $query->row()->siswa_login;
    //     }

    public function dataSiswaX()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.id=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%X %'
GROUP BY a_siswa.kelas";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaXI()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.id=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%XI %'
GROUP BY a_siswa.kelas";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaXII()
    {
        $sql = "SELECT a_kelas.kelas,count(a_siswa.nama_siswa) AS jumlah_siswa FROM a_kelas
INNER JOIN a_siswa
ON a_kelas.id=a_siswa.kelas
WHERE a_kelas.kelas LIKE '%XII %'
GROUP BY a_siswa.kelas";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswa()
    {
        $sql = "SELECT a_siswa.nama_siswa,a_jurusan.jurusan,a_kelas.kelas,a_siswa.username,a_siswa.password,IF(a_siswa.status=1,'AKTIF',null) AS keterangan FROM `a_siswa` 
INNER JOIN a_kelas on a_siswa.kelas=a_kelas.id 
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

    public function dataSiswaMoodleAKL()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (1) AND firstname not IN('ADMINISTRATOR') AND cbt_user.lastname LIKE ('%AKL%');";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlockAKL()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0) AND cbt_user.lastname LIKE ('%akl%');";
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

    public function dataSiswaMoodleBDP()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (1) AND firstname not IN('ADMINISTRATOR') AND cbt_user.lastname LIKE ('%PM%');";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlockBDP()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0) AND cbt_user.lastname LIKE ('%pm%');";
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

    public function dataSiswaMoodleOTKP()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (1) AND firstname not IN('ADMINISTRATOR') AND cbt_user.lastname LIKE ('%MPLB%');";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlockOTKP()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0) AND cbt_user.lastname LIKE ('%MPLB%');";
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

    public function dataSiswaMoodleTKJ()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (1) AND firstname not IN('ADMINISTRATOR') AND cbt_user.lastname LIKE ('%TJKT%');";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlockTKJ()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0) AND cbt_user.lastname LIKE ('%TJKT%');";
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

    public function dataSiswaMoodleDKV()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (1) AND firstname not IN('ADMINISTRATOR') AND cbt_user.lastname LIKE ('%DKV%');";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataSiswaMoodleBlockDKV()
    {
        $sql = "SELECT *,
IF(suspended=0,'AKTIF','TIDAK AKTIF') AS status
FROM `cbt_user`
WHERE id NOT IN (1,2) AND suspended NOT IN (0) AND cbt_user.lastname LIKE ('%dkv%');";
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
