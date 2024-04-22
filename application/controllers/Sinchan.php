<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sinchan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Sinchan_model', 'sinchan');

        // $this->load->helper('pendaftaran');
        $this->load->helper('user');
        $this->load->helper('wpu');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }


    public function evaluasiKasi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        // echo date('d / M / y');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Evaluasi Kepala Seksi";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $userid = $data['user']['uid'];
        $data['tasks']           = $this->db->get_where('m_tasks', ['user_id' => $data['user']['uid']])->row_array();
        $idtasks = $data['tasks']['id'];

        $data['profesi']   =   $this->sinchan->getListProfesiKasi();
        $data['ruang']   =   $this->sinchan->getListRuang();
        // print_r($data['ruang']);
        // die();

        if ($this->input->post('caripembayaran')) {
            $data['cari_status']   = $this->input->post('cari_status');
            $this->session->set_userdata('cari_status', $data['cari_status']);

            $data['cari_profesi']   = $this->input->post('cari_profesi');
            $this->session->set_userdata('cari_profesi', $data['cari_profesi']);

            $data['cari_ruang']   = $this->input->post('cari_ruang');
            $this->session->set_userdata('cari_ruang', $data['cari_ruang']);

            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);

            $data['tanggalcari']   = $this->input->post('tanggalcari');
            $this->session->set_userdata('tanggalcari', $data['tanggalcari']);

        } else {

            // $data['keyword']   =  $this->session->userdata('keyword');
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
        }
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/user/dailyRecord.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        // pagination
        $config["base_url"]     =   base_url('sinchan/evaluasiKasi/');
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by, ,dailyrecords.feedback_at, m_kasi.kasi_id, m_kasi.ka_kasi');
        $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks,m_tasks.ruang');
        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_kasi', 'm_kasi.kasi_id = m_tasks.kasi_id', 'left outer');
        $where = "m_kasi.ka_kasi = '".$userid."' and m_tasks.isActive = '1' and dailyrecords.created_by != '".$userid."'";
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.id', 'DESC');
        $this->db->from('dailyrecords');

        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["daily"] = $this->sinchan->getDailyByUserAtasan($config["per_page"], $data['nomer'], $data['cari_status'], $data['cari_profesi'], $data['cari_ruang'], $data['tanggalcari'], $userid, $data["bataldaftar"]);
        // print_r($data["daily"]);
        // die();

        $data["dailyById"] = $this->sinchan->getDailyById($data["id"]);
        // print_r($data["dailyById"]);

        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'sinchan/evaluasikasi', $data);
    }

    public function konfirmasievaluasiKasi()
    {
        date_default_timezone_set("Asia/Jakarta");

        // $txt_feedback = $_POST['txt_feedback'];

        $data['simpan']   =   $this->sinchan->updatedailyRecords($this->input->post());
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Data Berhasil Disimpan</div>'
        );
        redirect('sinchan/evaluasikasi');
    }

    //INI UNTUK KABID

    public function evaluasiKabid()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        // echo date('d / M / y');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Evaluasi Kepala Bidang / Kabag";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $userid = $data['user']['uid'];
        $data['tasks']           = $this->db->get_where('m_tasks', ['user_id' => $data['user']['uid']])->row_array();
        $idtasks = $data['tasks']['id'];

        $data['profesi']   =   $this->sinchan->getListProfesi();
        // print_r($data['profesi']);
        // die();

        if ($this->input->post('caripembayaran')) {

            $data['cari_profesi']   = $this->input->post('cari_profesi');
            $this->session->set_userdata('cari_profesi', $data['cari_profesi']);

            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);
            $data['tanggalcari']   = $this->input->post('tanggalcari');

            // print_r($this->input->post('cari_profesi'));
            // die();
            $this->session->set_userdata('tanggalcari', $data['tanggalcari']);

        } else {

            // $data['keyword']   =  $this->session->userdata('keyword');
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
        }
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/user/dailyRecord.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        // pagination
        $config["base_url"]     =   base_url('sinchan/evaluasiKasi/');
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback, m_bidang.bidang_id, m_bidang.ka_bidang');
        $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks');
        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_bidang', 'm_bidang.bidang_id = m_tasks.bidang_id', 'left outer');
        $this->db->join('simrs.master_login', 'master_login.uid = m_tasks.user_id', 'left outer');
        $where = "m_bidang.ka_bidang = '".$userid."' and m_tasks.isActive = '1' and master_login.is_manajemen != '' and dailyrecords.created_by != '".$userid."'";
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.id', 'DESC');
        $this->db->from('dailyrecords');

        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["daily"] = $this->sinchan->getDailyByUserAtasan_Kabid($config["per_page"], $data['nomer'], $data['cari_profesi'], $data['tanggalcari'], $userid, $data["bataldaftar"]);
        // print_r($data["daily"]);
        // die();

        $data["dailyById"] = $this->sinchan->getDailyById($data["id"]);
        // print_r($data["dailyById"]);

        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'sinchan/evaluasikabid', $data);
    }

    //INI UNTUK DIREKTUR

    public function evaluasiDirektur()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        // echo date('d / M / y');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Evaluasi Direktur";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $userid = $data['user']['uid'];
        $data['tasks']           = $this->db->get_where('m_tasks', ['user_id' => $data['user']['uid']])->row_array();
        $idtasks = $data['tasks']['id'];

        $data['profesi']   =   $this->sinchan->getListProfesi();
        // print_r($data['profesi']);
        // die();

        if ($this->input->post('caripembayaran')) {

            $data['cari_profesi']   = $this->input->post('cari_profesi');
            $this->session->set_userdata('cari_profesi', $data['cari_profesi']);

            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);
            $data['tanggalcari']   = $this->input->post('tanggalcari');

            // print_r($this->input->post('cari_profesi'));
            // die();
            $this->session->set_userdata('tanggalcari', $data['tanggalcari']);

        } else {

            // $data['keyword']   =  $this->session->userdata('keyword');
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
        }
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/user/dailyRecord.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        // pagination
        $config["base_url"]     =   base_url('sinchan/evaluasiDirektur/');
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback, m_bidang.bidang_id, m_bidang.ka_bidang');
        $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks');
        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_bidang', 'm_bidang.bidang_id = m_tasks.bidang_id', 'left outer');
        $this->db->join('simrs.master_login', 'master_login.uid = m_tasks.user_id', 'left outer');
        $where = "m_tasks.isActive = '1' and master_login.is_manajemen != '' and dailyrecords.created_by != '".$userid."'";
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.id', 'DESC');
        $this->db->from('dailyrecords');

        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["daily"] = $this->sinchan->getDailyByUserAtasan_Direktur($config["per_page"], $data['nomer'], $data['cari_profesi'], $data['tanggalcari'], $userid, $data["bataldaftar"]);
        // print_r($data["daily"]);
        // die();

        $data["dailyById"] = $this->sinchan->getDailyById($data["id"]);
        // print_r($data["dailyById"]);

        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'sinchan/evaluasidirektur', $data);
    }

    //INI UNTUK KEPALA RUANG 
    public function evaluasiKaru()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        // echo date('d / M / y');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Evaluasi Kepala Ruang";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $userid = $data['user']['uid'];
        $data['tasks']           = $this->db->get_where('m_tasks', ['user_id' => $data['user']['uid']])->row_array();
        $idtasks = $data['tasks']['id'];

        $data['bawahan']   =   $this->sinchan->getListBawahan();
        // print_r($data['bawahan']);
        // die();

        $data['profesi']   =   $this->sinchan->getListProfesiKasi();


        if ($this->input->post('caripembayaran')) {
            $data['cari_status']   = $this->input->post('cari_status');
            $this->session->set_userdata('cari_status', $data['cari_status']);

            $data['cari_bawahan']   = $this->input->post('cari_bawahan');
            $this->session->set_userdata('cari_bawahan', $data['cari_bawahan']);

            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);

            $data['tanggalcari']   = $this->input->post('tanggalcari');
            $this->session->set_userdata('tanggalcari', $data['tanggalcari']);

        } else {

            // $data['keyword']   =  $this->session->userdata('keyword');
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
        }
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/user/dailyRecord.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        // pagination
        $config["base_url"]     =   base_url('sinchan/evaluasiKaru/');
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback,dailyrecords.feedback_at');
        $this->db->select('m_tasks.tasks,m_tasks_detail.id_tasks');
        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = m_tasks.ruang', 'left outer');
        $where = "m_tasks.karu_koordinator_uid = '".$userid."' and m_tasks.isActive = '1' and dailyrecords.created_by != '".$userid."'";
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.id', 'DESC');
        $this->db->from('dailyrecords');

        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "20";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["daily"] = $this->sinchan->getDailyByUserAtasan_Karu($config["per_page"], $data['nomer'], $data['cari_status'], $data['cari_bawahan'], $data['tanggalcari'], $userid, $data["bataldaftar"]);

        $data["dailyById"] = $this->sinchan->getDailyById($data["id"]);
        // print_r($data["dailyById"]);

        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'sinchan/evaluasikaru', $data);
    }

    public function konfirmasievaluasiKaru()
    {
        date_default_timezone_set("Asia/Jakarta");

        // $txt_feedback = $_POST['txt_feedback'];

        $data['simpan']   =   $this->sinchan->updatedailyRecords($this->input->post());
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Data Berhasil Disimpan</div>'
        );
        redirect('sinchan/evaluasikaru');
    }

    public function insertdailyRecords()
    {
        date_default_timezone_set("Asia/Jakarta");

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim');

        $tanggal = $_POST['tanggal'];
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        // if (($tahun <> date("yy")) or ($bulan <> date("m"))) {
        //     $this->session->set_flashdata('flash', 'mohon maaf anda melebihi batas waktu yang di tentukan');
        //     redirect('user/dailyrecords');
        // } else {

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('flash', 'salah');
                redirect('user/dailyRecords');
            } else {

                if ($_POST['tanggal'] == "" or $_POST['jumlah'] == "" or $_POST['tasks'] == "" or $_POST['satuan'] == "" or $_POST['catatan_harian'] == "") {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                    );
                } else {
                    $data['simpan']   =   $this->user->insertdailyRecords($this->input->post());
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">Data Berhasil Disimpan</div>'
                    );
                }
            }
        // }

        redirect('user/dailyrecords');
    }

    public function updatedailyRecords()
    {
        date_default_timezone_set("Asia/Jakarta");

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim');

        // print_r($_POST['tanggal']);
        // print_r(date("yy-m-d"));

        $tanggal = $_POST['tanggal'];
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        // print_r($tanggal);
        // print_r($bulan);
        // print_r($tahun);
        // print_r(date("yy"));
        // print_r(date("m"));
        // die();
        // if (($tahun <> date("yy")) or ($bulan <> date("m"))) {
        //     // $this->session->set_flashdata('flash','mohon maaf anda melebihi batas waktu yang di tentukan');
        //     $this->session->set_flashdata(
        //         'message',
        //         '<div class="alert alert-danger" role="alert">Update Data Gagal!!! Pengisian tidak sesuai tanggal</div>'
        //     );
        //     redirect('user/dailyrecords');
        // } else {

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('flash', 'salah');
                redirect('user/dailyRecords');
            } else {

                if ($_POST['tanggal'] == "" or $_POST['tasks'] == "" or $_POST['catatan'] == "") {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">Gagal Mengubah Data !!! Data Wajib diisi semua</div>'
                    );
                } else {
                    $data['simpan']   =   $this->user->updatedailyRecords($this->input->post());
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">Data Berhasil Disimpan</div>'
                    );
                }
            }
        // }

        redirect('user/dailyrecords');
    }

    public function deletedailyRecords()
    {
        date_default_timezone_set("Asia/Jakarta");
        $data['data']   =   $this->user->deletedailyRecords($this->input->post());
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Data Berhasil Di Hapus</div>'
        );

        redirect('user/dailyRecords');
    }

    public function presentase()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Presentase";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $ruang = $data['user']['ruang'];
        $id = $data['user']['pegawai_id'];

        $data['ruang']   =   $this->master->getListRuang();

        // $data['ruang']   =   $this->pegawai->getPegawaiByUid($id);

        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/cssdruang/acceptTool.js");
        $data["js_to_load"] = "eklaimdateSearch.js";


        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["tasks"] = $this->user->getProsentase($config["per_page"], $data['nomer'], $data['keyword'], $data["bataldaftar"]);
        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'user/presentase', $data);
    }
}
