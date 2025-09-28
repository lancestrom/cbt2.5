<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ujian extends CI_Model
{

    public function countUjian()
    {
        $sql = "SELECT COUNT(*) AS ujian FROM `cbt_quiz`";
        $query = $this->db->query($sql);
        return $query->row()->ujian;
    }
    public function countUjianAKL()
    {
        $sql = "SELECT COUNT(*) AS ujian_akl FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
                INNER JOIN cbt_course_categories
                ON cbt_course.category=cbt_course_categories.id
                WHERE cbt_course_categories.name LIKE '%AKL%'";
        $query = $this->db->query($sql);
        return $query->row()->ujian_akl;
    }

    public function countUjianBDP()
    {
        $sql = "SELECT COUNT(*) AS ujian_bdp FROM `cbt_quiz`
                WHERE name LIKE '%PM%'";
        $query = $this->db->query($sql);
        return $query->row()->ujian_bdp;
    }

    public function countUjianOTKP()
    {
        $sql = "SELECT COUNT(*) AS ujian_otkp FROM `cbt_quiz`
                WHERE name LIKE '%MPLB%'";
        $query = $this->db->query($sql);
        return $query->row()->ujian_otkp;
    }

    public function countUjianTKJ()
    {
        $sql = "SELECT COUNT(*) AS ujian_tkj FROM `cbt_quiz`
                WHERE name LIKE '%TJKT%'";
        $query = $this->db->query($sql);
        return $query->row()->ujian_tkj;
    }

    public function countUjianDKV()
    {
        $sql = "SELECT COUNT(*) AS ujian_dkv FROM `cbt_quiz`
                WHERE name LIKE '%dkv%'";
        $query = $this->db->query($sql);
        return $query->row()->ujian_dkv;
    }

    public function ujian_hari_ini()
    {
        $sql = "SELECT cbt_quiz.* FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
 WHERE cbt_course.visible='1';";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function ujian_hari_ini_akl()
    {
        $sql = "SELECT cbt_course.fullname, COUNT(*) AS jumlah_siswa FROM cbt_enrol
INNER JOIN cbt_course
ON cbt_enrol.courseid=cbt_course.id
INNER JOIN cbt_user_enrolments
ON cbt_enrol.id=cbt_user_enrolments.enrolid
INNER JOIN cbt_user
ON cbt_user_enrolments.userid=cbt_user.id
WHERE cbt_course.visible=1 AND cbt_course.fullname LIKE '%akl%'
GROUP BY cbt_course.id
ORDER BY cbt_course.fullname ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function ujian_hari_ini_bdp()
    {
        $sql = "SELECT cbt_course.fullname, COUNT(*) AS jumlah_siswa FROM cbt_enrol
INNER JOIN cbt_course
ON cbt_enrol.courseid=cbt_course.id
INNER JOIN cbt_user_enrolments
ON cbt_enrol.id=cbt_user_enrolments.enrolid
INNER JOIN cbt_user
ON cbt_user_enrolments.userid=cbt_user.id
WHERE cbt_course.visible=1 AND cbt_course.fullname LIKE '%PM%'
GROUP BY cbt_course.id
ORDER BY cbt_course.fullname ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function ujian_hari_ini_otkp()
    {
        $sql = "SELECT cbt_course.fullname, COUNT(*) AS jumlah_siswa FROM cbt_enrol
INNER JOIN cbt_course
ON cbt_enrol.courseid=cbt_course.id
INNER JOIN cbt_user_enrolments
ON cbt_enrol.id=cbt_user_enrolments.enrolid
INNER JOIN cbt_user
ON cbt_user_enrolments.userid=cbt_user.id
WHERE cbt_course.visible=1 AND cbt_course.fullname LIKE '%MPLB%'
GROUP BY cbt_course.id
ORDER BY cbt_course.fullname ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function ujian_hari_ini_tkj()
    {
        $sql = "SELECT cbt_course.fullname, COUNT(*) AS jumlah_siswa FROM cbt_enrol
INNER JOIN cbt_course
ON cbt_enrol.courseid=cbt_course.id
INNER JOIN cbt_user_enrolments
ON cbt_enrol.id=cbt_user_enrolments.enrolid
INNER JOIN cbt_user
ON cbt_user_enrolments.userid=cbt_user.id
WHERE cbt_course.visible=1 AND cbt_course.fullname LIKE '%tjkt%'
GROUP BY cbt_course.id
ORDER BY cbt_course.fullname ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function ujian_hari_ini_dkv()
    {
        $sql = "SELECT cbt_course.fullname, COUNT(*) AS jumlah_siswa FROM cbt_enrol
INNER JOIN cbt_course
ON cbt_enrol.courseid=cbt_course.id
INNER JOIN cbt_user_enrolments
ON cbt_enrol.id=cbt_user_enrolments.enrolid
INNER JOIN cbt_user
ON cbt_user_enrolments.userid=cbt_user.id
WHERE cbt_course.visible=1 AND cbt_course.fullname LIKE '%dkv%'
GROUP BY cbt_course.id
ORDER BY cbt_course.fullname ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjian()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjianAKL()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
								WHERE cbt_course.fullname LIKE '%AKL%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjianBDP()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
								WHERE cbt_course.fullname LIKE '%PM%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjianOTKP()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
								WHERE cbt_course.fullname LIKE '%MPLB%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjianTKJ()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
								WHERE cbt_course.fullname LIKE '%TJKT%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function jadwalUjianDKV()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_course.fullname,cbt_course.shortname,name,timelimit,
                FROM_UNIXTIME(timeopen) AS timeopen,
								concat(DAYNAME(FROM_UNIXTIME(timeopen)),', ',date(FROM_UNIXTIME(timeopen))) AS tanggal_ujian,
								TIME(FROM_UNIXTIME(timeopen)) as waktu_awal,
								TIME(FROM_UNIXTIME(timeclose)) as waktu_akhir
                FROM `cbt_quiz`
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
								WHERE cbt_course.fullname LIKE '%DKV%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaLogin()
    {
        $sql = "SELECT cbt_sessions.id,cbt_sessions.userid,cbt_user.firstname,cbt_user.lastname,cbt_sessions.firstip,
FROM_UNIXTIME(cbt_sessions.timecreated) AS waktu_login
FROM `cbt_sessions`
INNER JOIN cbt_user
ON cbt_user.id=cbt_sessions.userid";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPeserta()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPeserta()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPesertaAKL()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE a_kelas.kode='AKL'
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPesertaBDP()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE a_kelas.kode='PM'
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPesertaOTKP()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE a_kelas.kode='MPLB'
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPesertaTKJ()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE a_kelas.kode='TJKT'
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function FilterstatusPesertaDKV()
    {
        $sql = "SELECT cbt_quiz.name,a_kelas.kelas as nama_kelas,
                count(IF(cbt_quiz_attempts.state='finished','Selesai',null)) AS selesai,
                COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null)) AS masih_mengerjakan,
                (count(IF(cbt_quiz_attempts.state='finished','Selesai',null))+COUNT(IF(cbt_quiz_attempts.state='inprogress','Belum Selesai',null))) AS jumlah_mengerjakan
                FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE a_kelas.kode='DKV'
                GROUP BY cbt_quiz.name,a_kelas.kelas
                ORDER BY a_kelas.kelas ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaAKL()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE cbt_user.lastname LIKE '%AKL%'
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaBDP()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE cbt_user.lastname LIKE '%PM%'
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaOTKP()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE cbt_user.lastname LIKE '%MPLB%'
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaTKJ()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE cbt_user.lastname LIKE '%TJKT%'
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function statusPesertaDKV()
    {
        $sql = "SELECT *, a_kelas.kelas as nama_kelas FROM `cbt_quiz_attempts`
                INNER JOIN cbt_user
                on cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN cbt_quiz
                ON cbt_quiz_attempts.quiz=cbt_quiz.id
                INNER JOIN a_siswa
                ON cbt_user.username=a_siswa.username  
                INNER JOIN a_kelas
                ON a_siswa.kelas=a_kelas.id
                WHERE cbt_user.lastname LIKE '%DKV%'
                ORDER BY `cbt_quiz_attempts`.`timefinish`  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai()
    {
        // $sql = "SELECT  cbt_quiz.course as id_course,cbt_quiz.*,cbt_course.*,cbt_quiz_attempts.*,
        //         FROM_UNIXTIME(timeopen) AS timeopen, dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai,
        //         FROM_UNIXTIME(timeclose) AS timeclose, dayname(FROM_UNIXTIME(timeclose)) AS hariakhir, day(FROM_UNIXTIME(timeclose)) AS taggalakhir, monthname(FROM_UNIXTIME(timeclose)) AS bulanakhir, year(FROM_UNIXTIME(timeclose)) AS tahunakhir
        //         FROM `cbt_quiz`
        //         INNER JOIN cbt_course
        //         ON cbt_quiz.course=cbt_course.id
        //         INNER JOIN cbt_quiz_attempts
        //         ON cbt_quiz.id=cbt_quiz_attempts.quiz
        //         GROUP BY cbt_quiz.name";
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai_akl()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
 WHERE cbt_course.fullname LIKE '%AKL%'
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai_bdp()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
 WHERE cbt_course.fullname LIKE '%PM%'
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai_otkp()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
 WHERE cbt_course.fullname LIKE '%MPLB%'
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai_tkj()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
 WHERE cbt_course.fullname LIKE '%TJKT%'
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function rekap_nilai_DKV()
    {
        $sql = "SELECT cbt_quiz.course as id_course,cbt_course.sortorder,cbt_quiz.`name`,dayname(FROM_UNIXTIME(timeopen)) AS harimulai, day(FROM_UNIXTIME(timeopen)) AS taggalmulai, monthname(FROM_UNIXTIME(timeopen)) AS bulanmulai, year(FROM_UNIXTIME(timeopen)) AS tahunmulai
FROM `cbt_quiz`
INNER JOIN cbt_course
ON cbt_quiz.course=cbt_course.id
INNER JOIN cbt_quiz_attempts
ON cbt_quiz.id=cbt_quiz_attempts.quiz
 WHERE cbt_course.fullname LIKE '%dkv%'
GROUP BY  cbt_quiz.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function print_nilai_header($id_course)
    {
        $sql = "SELECT cbt_course.id AS id_course ,cbt_course.*,cbt_quiz_attempts.*,cbt_user.*,a_siswa.*,cbt_quiz.*,
                FROM_UNIXTIME(startdate),
                hour(FROM_UNIXTIME(startdate)) AS jam_awal,minute(FROM_UNIXTIME(startdate)) AS menit_awal,dayname(FROM_UNIXTIME(startdate)) AS hari_awal, day(FROM_UNIXTIME(startdate)) AS tanggal_awal,monthname(FROM_UNIXTIME(startdate)) AS bulan_awal,year(FROM_UNIXTIME(startdate)) AS tahun_awal,
                hour(FROM_UNIXTIME(enddate)) AS jam_akhir,minute(FROM_UNIXTIME(enddate)) AS menit_akhir,dayname(FROM_UNIXTIME(enddate)) AS hari_akhir, day(FROM_UNIXTIME(enddate)) AS tanggal_akhir,monthname(FROM_UNIXTIME(enddate)) AS bulan_akhir,year(FROM_UNIXTIME(enddate)) AS tahun_akhir
                FROM `cbt_course`
                INNER JOIN cbt_quiz
                ON cbt_quiz.course=cbt_course.id
                INNER JOIN cbt_quiz_attempts
                ON cbt_quiz.id=cbt_quiz_attempts.quiz
                INNER JOIN cbt_user
                ON cbt_quiz_attempts.userid=cbt_user.id
                INNER JOIN a_siswa
                on a_siswa.username=cbt_user.username
                WHERE cbt_quiz.course='$id_course'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function print_nilai_rekap($id_course)
    {
        $sql = "SELECT cbt_user.firstname,a_kelas.kelas as nama_kelas,cbt_quiz_grades.grade AS nilai FROM `cbt_quiz_grades`
                INNER JOIN cbt_user
                ON cbt_quiz_grades.userid=cbt_user.id
                inner JOIN cbt_quiz
                on cbt_quiz_grades.quiz=cbt_quiz.id
                INNER JOIN cbt_course
                ON cbt_quiz.course=cbt_course.id
                inner JOIN a_siswa
                ON cbt_user.username=a_siswa.username
                INNER JOIN a_kelas
                on a_siswa.kelas=a_kelas.id
                WHERE cbt_quiz.course='$id_course'  
                ORDER BY cbt_user.firstname  ASC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
