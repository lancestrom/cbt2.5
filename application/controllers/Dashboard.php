<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Dashboard extends CI_Controller
{
    public function index()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['jurusan'] = $this->Model_jurusan->countJurusan();
        $isi['siswa'] = $this->Model_siswa->countSiswa();

        $isi['kelas'] = $this->Model_kelas->countKelas();
        $isi['mapel'] = $this->Model_mapel->countMapel();
        // $isi['ujian'] = $this->Model_ujian->countUjian();

        // Kelas
        $isi['x'] = $this->Model_siswa->dataSiswaX();
        $isi['xi'] = $this->Model_siswa->dataSiswaXI();
        $isi['xii'] = $this->Model_siswa->dataSiswaXII();

        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_home';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer', $isi);
    }

    public function jurusan()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['jurusan'] = $this->Model_jurusan->dataJurusan();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_jurusan';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function kelas()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['kelas'] = $this->Model_kelas->dataKelasMaster();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_kelas';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function hapus_all_kelas()
    {
        $this->db->empty_table('a_kelas');
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Kelas Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/kelas');
    }

    public function upload_kelas()
    {
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id'              => $cells[0],
                                'kode'     => $cells[1],
                                'kelas'            => $cells[2]
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_kelas->simpan($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
                    $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Tambah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
                    redirect('Dashboard/kelas');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }

    public function mata_pelajaran()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['mapel'] = $this->Model_mapel->dataMapel();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_mata_pelajaran';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function hapus_all_mata_pelajaran()
    {
        $this->db->empty_table('a_mapel');
        $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/mata_pelajaran');
    }

    public function upload_mata_peajaran()
    {
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id_mapel'              => $cells[0],
                                'id_kelas'     => $cells[1],
                                'nama_mapel'            => $cells[2]
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_mapel->simpan($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
                    $this->session->set_flashdata('pesan', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Mapel Berhasil Di Tambah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
                    redirect('Dashboard/mata_pelajaran');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }

    public function ruang_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['ruang'] = $this->Model_ruang->dataRuang();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_ruang_ujian';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }


    public function siswa()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['siswa'] = $this->Model_siswa->dataSiswa();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_siswa';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function siswa_moodle()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['siswa'] = $this->Model_siswa->dataSiswaMoodle();

        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_siswa_moodle';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function proses_block_user()
    {
        $id = $this->input->post('id');
        $auth = $this->input->post('auth');
        $confirmed = $this->input->post('confirmed');
        $policyagreed = $this->input->post('policyagreed');
        $deleted = $this->input->post('deleted');
        $suspended = 1;
        $mnethostid = $this->input->post('mnethostid');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $idnumber = $this->input->post('idnumber');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $emailstop = $this->input->post('emailstop');
        $icq = $this->input->post('icq');
        $skype = $this->input->post('skype');
        $yahoo = $this->input->post('yahoo');
        $aim = $this->input->post('aim');
        $msn = $this->input->post('msn');
        $phone1 = $this->input->post('phone1');
        $phone2 = $this->input->post('phone2');
        $institution = $this->input->post('institution');
        $department = $this->input->post('department');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $country = $this->input->post('country');
        $lang = $this->input->post('lang');
        $calendartype = $this->input->post('calendartype');
        $theme = $this->input->post('theme');
        $timezone = $this->input->post('timezone');
        $firstaccess = $this->input->post('firstaccess');
        $lastaccess = $this->input->post('lastaccess');
        $lastlogin = $this->input->post('lastlogin');
        $currentlogin = $this->input->post('currentlogin');
        $lastip = $this->input->post('lastip');
        $secret = $this->input->post('secret');
        $picture = $this->input->post('picture');
        $url = $this->input->post('url');
        $description = $this->input->post('description');
        $descriptionformat = $this->input->post('descriptionformat');
        $mailformat = $this->input->post('mailformat');
        $maildigest = $this->input->post('maildigest');
        $maildisplay = $this->input->post('maildisplay');
        $autosubscribe = $this->input->post('autosubscribe');
        $trackforums = $this->input->post('trackforums');
        $timecreated = $this->input->post('timecreated');
        $timemodified = $this->input->post('timemodified');
        $trustbitmask = $this->input->post('trustbitmask');
        $imagealt = $this->input->post('imagealt');
        $lastnamephonetic = $this->input->post('lastnamephonetic');
        $firstnamephonetic = $this->input->post('firstnamephonetic');
        $middlename = $this->input->post('middlename');
        $alternatename = $this->input->post('alternatename');

        $data = array(
            'id' => $id,
            'auth' => $auth,
            'confirmed' => $confirmed,
            'policyagreed' => $policyagreed,
            'deleted' => $deleted,
            'suspended' => $suspended,
            'mnethostid' => $mnethostid,
            'username' => $username,
            'password' => $password,
            'idnumber' => $idnumber,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'emailstop' => $emailstop,
            'icq' => $icq,
            'skype' => $skype,
            'yahoo' => $yahoo,
            'aim' => $aim,
            'msn' => $msn,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'institution' => $institution,
            'department' => $department,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'lang' => $lang,
            'calendartype' => $calendartype,
            'theme' => $theme,
            'timezone' => $timezone,
            'firstaccess' => $firstaccess,
            'lastaccess' => $lastaccess,
            'lastlogin' => $lastlogin,
            'currentlogin' => $currentlogin,
            'lastip' => $lastip,
            'secret' => $secret,
            'picture' => $picture,
            'url' => $url,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'mailformat' => $mailformat,
            'maildigest' => $maildigest,
            'maildisplay' => $maildisplay,
            'autosubscribe' => $autosubscribe,
            'trackforums' => $trackforums,
            'timecreated' => $timecreated,
            'timemodified' => $timemodified,
            'trustbitmask' => $trustbitmask,
            'imagealt' => $imagealt,
            'lastnamephonetic' => $lastnamephonetic,
            'firstnamephonetic' => $firstnamephonetic,
            'middlename' => $middlename,
            'alternatename' => $alternatename,
        );

        $this->db->where('id', $id);
        $this->db->update('cbt_user', $data);
        redirect('Dashboard/siswa_moodle');
    }


    public function siswa_block()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['siswa'] = $this->Model_siswa->dataSiswaMoodleBlock();

        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'tampilan_siswa_blok';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function proses_unblock_user()
    {
        $id = $this->input->post('id');
        $auth = $this->input->post('auth');
        $confirmed = $this->input->post('confirmed');
        $policyagreed = $this->input->post('policyagreed');
        $deleted = $this->input->post('deleted');
        $suspended = 0;
        $mnethostid = $this->input->post('mnethostid');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $idnumber = $this->input->post('idnumber');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $emailstop = $this->input->post('emailstop');
        $icq = $this->input->post('icq');
        $skype = $this->input->post('skype');
        $yahoo = $this->input->post('yahoo');
        $aim = $this->input->post('aim');
        $msn = $this->input->post('msn');
        $phone1 = $this->input->post('phone1');
        $phone2 = $this->input->post('phone2');
        $institution = $this->input->post('institution');
        $department = $this->input->post('department');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $country = $this->input->post('country');
        $lang = $this->input->post('lang');
        $calendartype = $this->input->post('calendartype');
        $theme = $this->input->post('theme');
        $timezone = $this->input->post('timezone');
        $firstaccess = $this->input->post('firstaccess');
        $lastaccess = $this->input->post('lastaccess');
        $lastlogin = $this->input->post('lastlogin');
        $currentlogin = $this->input->post('currentlogin');
        $lastip = $this->input->post('lastip');
        $secret = $this->input->post('secret');
        $picture = $this->input->post('picture');
        $url = $this->input->post('url');
        $description = $this->input->post('description');
        $descriptionformat = $this->input->post('descriptionformat');
        $mailformat = $this->input->post('mailformat');
        $maildigest = $this->input->post('maildigest');
        $maildisplay = $this->input->post('maildisplay');
        $autosubscribe = $this->input->post('autosubscribe');
        $trackforums = $this->input->post('trackforums');
        $timecreated = $this->input->post('timecreated');
        $timemodified = $this->input->post('timemodified');
        $trustbitmask = $this->input->post('trustbitmask');
        $imagealt = $this->input->post('imagealt');
        $lastnamephonetic = $this->input->post('lastnamephonetic');
        $firstnamephonetic = $this->input->post('firstnamephonetic');
        $middlename = $this->input->post('middlename');
        $alternatename = $this->input->post('alternatename');

        $data = array(
            'id' => $id,
            'auth' => $auth,
            'confirmed' => $confirmed,
            'policyagreed' => $policyagreed,
            'deleted' => $deleted,
            'suspended' => $suspended,
            'mnethostid' => $mnethostid,
            'username' => $username,
            'password' => $password,
            'idnumber' => $idnumber,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'emailstop' => $emailstop,
            'icq' => $icq,
            'skype' => $skype,
            'yahoo' => $yahoo,
            'aim' => $aim,
            'msn' => $msn,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'institution' => $institution,
            'department' => $department,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'lang' => $lang,
            'calendartype' => $calendartype,
            'theme' => $theme,
            'timezone' => $timezone,
            'firstaccess' => $firstaccess,
            'lastaccess' => $lastaccess,
            'lastlogin' => $lastlogin,
            'currentlogin' => $currentlogin,
            'lastip' => $lastip,
            'secret' => $secret,
            'picture' => $picture,
            'url' => $url,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'mailformat' => $mailformat,
            'maildigest' => $maildigest,
            'maildisplay' => $maildisplay,
            'autosubscribe' => $autosubscribe,
            'trackforums' => $trackforums,
            'timecreated' => $timecreated,
            'timemodified' => $timemodified,
            'trustbitmask' => $trustbitmask,
            'imagealt' => $imagealt,
            'lastnamephonetic' => $lastnamephonetic,
            'firstnamephonetic' => $firstnamephonetic,
            'middlename' => $middlename,
            'alternatename' => $alternatename,
        );

        $this->db->where('id', $id);
        $this->db->update('cbt_user', $data);
        redirect('Dashboard/siswa_block');
    }

    public function hapus_all_peserta_ujian()
    {
        $this->db->empty_table('a_siswa');
        $this->session->set_flashdata('info', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Peserta Ujian Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/siswa');
    }

    public function upload_peserta_ujian()
    {
        if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './temp_doc/';
            $config['allowed_types']    = 'xlsx|xls';
            $config['file_name']        = 'doc' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open('temp_doc/' . $file['file_name']);


                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;
                    $save   = array();
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {

                            $cells = $row->getCells();

                            $data = array(
                                'id'              => $cells[0],
                                'no_peserta'      => $cells[1],
                                'nama_siswa'      => $cells[2],
                                'kelas'           => $cells[3],
                                'jurusan'         => $cells[4],
                                'username'        => $cells[5],
                                'password'        => $cells[6],
                            );
                            array_push($save, $data);
                        }
                        $numRow++;
                    }
                    $this->Model_siswa->simpanSiswa($save);
                    $reader->close();
                    unlink('temp_doc/' . $file['file_name']);
                    $this->session->set_flashdata('info', '
                    <div class="row">
                    <div class="col-md mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Data Peserta Ujian Berhasil Di Tambah</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    </div>');
                    redirect('Dashboard/siswa');
                }
            } else {
                echo "Error :" . $this->upload->display_errors();
            }
        }
    }

    public function jadwal_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['ujian'] = $this->Model_ujian->jadwalUjian();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_ujain';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function akun_peserta()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['kelas'] = $this->Model_kelas->dataKelas();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_kelas_akun_siswa';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function print_akun($id_kelas)
    {
        $this->Model_keamanan->getKeamanan();
        $isi['header'] = $this->Model_siswa->header_akun_siswa($id_kelas);
        $isi['siswa'] = $this->Model_siswa->akun_siswa($id_kelas);

        $isi['title'] = 'CBT | Administrator';
        $this->load->view('Ujian/print_akun_siswa', $isi);
    }

    public function print_kartu($id_kelas)
    {
        $this->Model_keamanan->getKeamanan();
        $isi['header'] = $this->Model_siswa->header_akun_siswa($id_kelas);
        $isi['siswa'] = $this->Model_siswa->akun_siswa($id_kelas);
        $isi['title'] = 'CBT | Administrator';
        $this->load->view('Ujian/print_kartu_siswa', $isi);
    }

    public function status_ujian()
    {
        $this->Model_keamanan->getKeamanan();
        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_status_ujian';
        $isi['ujian_hari_ini'] = $this->Model_ujian->ujian_hari_ini();

        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function status_peserta_login()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['status'] = $this->Model_ujian->statusPesertaLogin();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_status_peserta_login';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function hapus_session_login($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('cbt_sessions');
        redirect('Dashboard/status_peserta_login');
    }

    public function refresh_token($id)
    {
        $id = $this->input->post('id');
        $course = $this->input->post('course');
        $name = $this->input->post('name');
        $intro = $this->input->post('intro');
        $introformat = $this->input->post('introformat');
        $timeopen = $this->input->post('timeopen');
        $timeclose = $this->input->post('timeclose');
        $timelimit = $this->input->post('timelimit');
        $overduehandling = $this->input->post('overduehandling');
        $graceperiod = $this->input->post('graceperiod');
        $preferredbehaviour = $this->input->post('preferredbehaviour');
        $canredoquestions = $this->input->post('canredoquestions');
        $attempts = $this->input->post('attempts');
        $attemptonlast = $this->input->post('attemptonlast');
        $grademethod = $this->input->post('grademethod');
        $decimalpoints = $this->input->post('decimalpoints');
        $questiondecimalpoints = $this->input->post('questiondecimalpoints');
        $reviewattempt = $this->input->post('reviewattempt');
        $reviewcorrectness = $this->input->post('reviewcorrectness');
        $reviewmarks = $this->input->post('reviewmarks');
        $reviewspecificfeedback = $this->input->post('reviewspecificfeedback');
        $reviewgeneralfeedback = $this->input->post('reviewgeneralfeedback');
        $reviewrightanswer = $this->input->post('reviewrightanswer');
        $reviewoverallfeedback = $this->input->post('reviewoverallfeedback');
        $questionsperpage = $this->input->post('questionsperpage');
        $navmethod = $this->input->post('navmethod');
        $shuffleanswers = $this->input->post('shuffleanswers');
        $sumgrades = $this->input->post('sumgrades');
        $grade = $this->input->post('grade');
        $timecreated = $this->input->post('timecreated');
        $timemodified = $this->input->post('timemodified');
        $password = 'SAS' . rand(1111, 99999);
        $subnet = $this->input->post('subnet');
        $browsersecurity = $this->input->post('browsersecurity');
        $delay1 = $this->input->post('delay1');
        $delay2 = $this->input->post('delay2');
        $showuserpicture = $this->input->post('showuserpicture');
        $showblocks = $this->input->post('showblocks');
        $completionattemptsexhausted = $this->input->post('completionattemptsexhausted');
        $completionpass = $this->input->post('completionpass');
        $allowofflineattempts = $this->input->post('allowofflineattempts');

        $data = array(
            'id' => $id,
            'course' => $course,
            'name' => $name,
            'intro' => $intro,
            'introformat' => $introformat,
            'timeopen' => $timeopen,
            'timeclose' => $timeclose,
            'timelimit' => $timelimit,
            'overduehandling' => $overduehandling,
            'graceperiod' => $graceperiod,
            'preferredbehaviour' => $preferredbehaviour,
            'canredoquestions' => $canredoquestions,
            'attempts' => $attempts,
            'attemptonlast' => $attemptonlast,
            'grademethod' => $grademethod,
            'decimalpoints' => $decimalpoints,
            'questiondecimalpoints' => $questiondecimalpoints,
            'reviewattempt' => $reviewattempt,
            'reviewcorrectness' => $reviewcorrectness,
            'reviewmarks' => $reviewmarks,
            'reviewspecificfeedback' => $reviewspecificfeedback,
            'reviewgeneralfeedback' => $reviewgeneralfeedback,
            'reviewrightanswer' => $reviewrightanswer,
            'reviewoverallfeedback' => $reviewoverallfeedback,
            'questionsperpage' => $questionsperpage,
            'navmethod' => $navmethod,
            'shuffleanswers' => $shuffleanswers,
            'sumgrades' => $sumgrades,
            'grade' => $grade,
            'timecreated' => $timecreated,
            'timemodified' => $timemodified,
            'password' => $password,
            'subnet' => $subnet,
            'browsersecurity' => $browsersecurity,
            'delay1' => $delay1,
            'delay2' => $delay2,
            'showuserpicture' => $showuserpicture,
            'showblocks' => $showblocks,
            'completionattemptsexhausted' => $completionattemptsexhausted,
            'completionpass' => $completionpass,
            'allowofflineattempts' => $allowofflineattempts
        );
        $this->db->where('id', $id);
        $this->db->update('cbt_quiz', $data);
        redirect('Dashboard/status_ujian');
    }

    public function hapus_all_peserta_login()
    {
        $this->db->empty_table('cbt_sessions');
        $this->session->set_flashdata('info', '<div class="row">
        <div class="col-md mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Login Peserta Ujian Berhasil Di Hapus</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        </div>');
        redirect('Dashboard/status_peserta_login');
    }

    public function status_peserta()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['status'] = $this->Model_ujian->statusPeserta();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_status_peserta';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function filter_status_peserta()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['status'] = $this->Model_ujian->FilterstatusPeserta();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/filter_tampilan_status_peserta';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }



    public function rekap_nilai()
    {
        $this->Model_keamanan->getKeamanan();
        $isi['rekap'] = $this->Model_ujian->rekap_nilai();


        $isi2['title'] = 'CBT | Administrator';
        $isi['content'] = 'Ujian/tampilan_rekap_nilai';
        $this->load->view('templates/header', $isi2);
        $this->load->view('tampilan_dashboard', $isi);
        $this->load->view('templates/footer');
    }

    public function print_nilai($id_course)
    {
        $this->Model_keamanan->getKeamanan();
        $isi['header'] = $this->Model_ujian->print_nilai_header($id_course);
        $isi['rekap'] = $this->Model_ujian->print_nilai_rekap($id_course);

        $isi2['title'] = 'CBT | Administrator';
        $this->load->view('Ujian/tampilan_print_nilai', $isi);
    }




    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
