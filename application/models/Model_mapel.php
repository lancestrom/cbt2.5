<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_mapel extends CI_Model
{
    public function countMapel()
    {
        $sql = "SELECT COUNT(*) AS mapel FROM `cbt_course`
                WHERE  category>0;";
        $query = $this->db->query($sql);
        return $query->row()->mapel;
    }

    public function countMapelAKL()
    {
        $sql = "SELECT COUNT(*) AS mapel_akl FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%AKL%'";
        $query = $this->db->query($sql);
        return $query->row()->mapel_akl;
    }

    public function countMapelBDP()
    {
        $sql = "SELECT COUNT(*) AS mapel_bdp FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%PM%'";
        $query = $this->db->query($sql);
        return $query->row()->mapel_bdp;
    }

    public function countMapelOTKP()
    {
        $sql = "SELECT COUNT(*) AS mapel_otkp FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%MPLB%'";
        $query = $this->db->query($sql);
        return $query->row()->mapel_otkp;
    }

    public function countMapelTKJ()
    {
        $sql = "SELECT COUNT(*) AS mapel_tkj FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%TJKT%'";
        $query = $this->db->query($sql);
        return $query->row()->mapel_tkj;
    }

    public function countMapelDKV()
    {
        $sql = "SELECT COUNT(*) AS mapel_dkv FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%dkv%'";
        $query = $this->db->query($sql);
        return $query->row()->mapel_dkv;
    }

    public function dataMapel()
    {
        $sql = "SELECT *  FROM `cbt_course`
                WHERE  category>0;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataMapelAKL()
    {
        $sql = "SELECT * FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%AKL%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataMapelBDP()
    {
        $sql = "SELECT * FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%PM%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataMapelOTKP()
    {
        $sql = "SELECT * FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%MPLB%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataMapelTKJ()
    {
        $sql = "SELECT * FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%TJKT%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function dataMapelDKV()
    {
        $sql = "SELECT * FROM `cbt_course`
                WHERE format='singleactivity' AND fullname LIKE '%DKV%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
