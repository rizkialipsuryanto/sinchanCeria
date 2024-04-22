<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Master_model', 'master');
        $this->load->model('Pegawai_model', 'pegawai');
        // $this->load->model('Poli_model', 'poli');

        $this->load->helper('pendaftaran');
        $this->load->helper('wpu');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->helper('user');
        $this->load->helper('bidang');

    }

    public function index()
    {
        // redirect('')
        // $data['title'] = "My Profile";
        // $data['user'] = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        // $data['dashboard'] = [
        //     'jumlahpasienhariini' => '56',
        //     'jumlahpasienbulanini' => '89',
        //     'jumlahpasienumum' => '32',
        //     'jumlahpasienjaminan' => '12'
        // ];

        // sendToAdminLTE(1, 'user/index', $data);
    }

    public function tasks()
    {

        // print_r("tasks");
        // die();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Tasks";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        // print_r($data['user']);

        // $ruang = $data['user']['ruang'];
        // $id = $data['user']['pegawai_id'];

        $data['ruang']   =   $this->master->getListRuang();
        $data['bidang']   =   $this->master->getListBidang();
        $data['kasi']   =   $this->master->getListKasi();
        $data['profesi']   =   $this->master->getListProfesi();
        $data['karukoordinator']   =   $this->master->getListKaruKoordinator();
        // print_r($data['karukoordinator']);
        // die();

        if ($this->input->post('caripembayaran')) {


            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);

            $data['keyword']   = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);

            $data['cari_ruang']   = $this->input->post('cari_ruang');
            $this->session->set_userdata('cari_ruang', $data['cari_ruang']);

        } else {
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
            $data['cari_ruang']   = $this->session->userdata('cari_ruang');
        }

        // $data['ruang']   =   $this->pegawai->getPegawaiByUid($id);
        
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/master/task.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        
        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        $data["tasks"] = $this->master->getTasks($config["per_page"], $data['nomer'], $data['cari_ruang'], $data["bataldaftar"],$data['user']);
        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'master/tasks', $data);
    }

    public function insertTasks()
    {
        date_default_timezone_set("Asia/Jakarta");

        $ruang = $_POST['ruang'];
            if ($_POST['profesi'] == "" or $_POST['bidang'] == "" or $_POST['kasi'] == "") {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                );
            } else {
                $data['simpan']   =   $this->master->insertTasks($this->input->post());
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Transaksi Berhasil</div>'
                );
            }
        

        redirect('master/tasks');
    }

    public function konfirmasiNonActiv($id)
    {
        date_default_timezone_set("Asia/Jakarta");

        // print_r($id);
        // die();
            $data['nonActive']   =   $this->master->nonActivProfesi($id);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Profesi Berhasil Di Non Activkan, Untuk mengAktifkan kembali silahkan hubungi IT</div>'
            );

        redirect('master/tasks');
    }

    public function tasksDetail()
    {
        // print_r("tasks");
        // die();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Kegiatan Utama";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $ruang = $data['user']['ruang'];
        $id = $data['user']['pegawai_id'];

        $data['ruang']   =   $this->master->getListRuang();
        $data['tasks']   =   $this->master->getListTasks($data['user']);

        // print_r($data['tasks']);
        // die();

        // $_POST['cari_task'];
        // print_r($_POST['cari_task']);
        if ($this->input->post('caripembayaran')) {
            $data['cari_task']   = $this->input->post('cari_task');
            // print_r( $data['cari_task']);
            $this->session->set_userdata('cari_task', $data['cari_task']);

        } else {
            $data['bataldaftar']   =  $this->session->userdata('bataldaftar');
        }

        // $data['ruang']   =   $this->pegawai->getPegawaiByUid($id);
        
        $data["css_arr_head"] = array(
            'select2/dist/css/select2.min.css'
        );
        $data["js_arr_foot"] = array("controllers/master/taskDetail.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        
        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "10";

        $this->pagination->initialize($config);

        $data['nomer'] = $this->uri->segment(3);
        // // 
        $data["tasksdetail"] = $this->master->getTasksDetail($config["per_page"], $data['nomer'], $data['cari_task'], $data["bataldaftar"],$data['user']);

        // print_r($data["tasksdetailById"]);
        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'master/tasksdetail', $data);
    }

    public function insertTasksDetail()
    {
        date_default_timezone_set("Asia/Jakarta");
            if ($_POST['tasks'] == "" or $_POST['tasks_detail'] == "") {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                );
            } else {
                $data['simpan']   =   $this->master->insertTasksDetail($this->input->post());
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Transaksi Berhasil</div>'
                );
            }
        redirect('master/tasksDetail');
    }

    public function updateTasksDetail()
    {
        date_default_timezone_set("Asia/Jakarta");
            if ($_POST['modal_id'] == "" or $_POST['modal_tasksdetail'] == "") {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                );
            } else {
                $data['simpan']   =   $this->master->updateTasksDetail($this->input->post());
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Transaksi Berhasil</div>'
                );
            }
        redirect('master/tasksDetail');
    }

    public function bidang()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Bidang";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $ruang = $data['user']['ruang'];
        $id = $data['user']['pegawai_id'];

        $data['bidang']   =   $this->master->getListBidang();
        
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
        $data["bidanglist"] = $this->master->getBidangList($config["per_page"], $data['nomer'], $data['keyword'], $data["bataldaftar"]);
        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'master/bidang', $data);
    }

    public function insertBidang()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bidang = $_POST['bidang'];
            if ($_POST['bidang'] == "") {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                );
            } else {
                $data['simpan']   =   $this->master->insertBidang($this->input->post());
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Transaksi Berhasil</div>'
                );
            }
        

        redirect('master/bidang');
    }

    public function kasi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Kasi";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $ruang = $data['user']['ruang'];
        $id = $data['user']['pegawai_id'];

        $data['bidang']   =   $this->master->getListBidang();
        
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
        $data["kasilist"] = $this->master->getKasiList($config["per_page"], $data['nomer'], $data['keyword'], $data["bataldaftar"]);
        $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'master/kasi', $data);
    }

    public function insertKasi()
    {
        date_default_timezone_set("Asia/Jakarta");
            if ($_POST['bidang'] == "" || $_POST['kasi'] == "") {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Data Wajib diisi semua</div>'
                );
            } else {
                $data['simpan']   =   $this->master->insertKasi($this->input->post());
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Transaksi Berhasil</div>'
                );
            }
        

        redirect('master/kasi');
    }

    public function dataUser()
    {
        $data['title']  = "Data User";
        $data['user']   = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->input->post('cariuser')) {
            $data['keyword']   = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword']   =  $this->session->userdata('keyword');
        }

        $data["css_arr_head"] = array('select2/dist/css/select2.min.css');
        $data["js_arr_foot"] = array("controllers/cssdruang/acceptTool.js");
        $data["js_to_load"] = "eklaimdateSearch.js";

        $config["base_url"]     =   base_url('master/dataUser/');

        $this->db->from('simrs2012.user');

        $config["total_rows"]   = $this->db->count_all_results();
        $data['total_rows']     = $config["total_rows"];
        $config["per_page"]     = "20";

        $this->pagination->initialize($config);

        $data['nomer']  = $this->uri->segment(4);

        $data["data"]   = $this->master->getListUser($config["per_page"], $data['nomer'], $data['keyword']);
        $data["links"]  = $this->pagination->create_links();

        // print_r($data['data']);
        // die();

        sendToAdminLTE(1, 'master/user', $data);
    }

    public function editUser($id)
    {
        $data['title']  = "Edit Validation";
        $data['user']   = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data['ruang']  = $this->master->getListRuang();
        $data['tasks']  = $this->master->getListTasks();
        $data['role']   = $this->master->getRole();
        $data['pegawai'] = $this->pegawai->getPegawai();

        $where              = array('id' => $id);
        $data['validation'] = $this->master->getListWhere($where)->result_array();

        sendToAdminLTE(1, 'master/edit-user', $data);
    }

    public function updateUser()
    {
        $data['validation'] = $this->master->updateUser($this->input->post());

        redirect('master/dataUser');
    }

    public function resetPassword($id)
    {
        // print_r($id);
        // die();
        $data['validation'] = $this->master->resetPassword($id);

        redirect('master/dataUser');
    }

    public function get_kasi()
    {
        $bidang_id = $this->input->post('bidang_id');
        $data = $this->master->get_kasi($bidang_id);
        echo json_encode($data);
    }

    public function get_profesi()
    {
        $kasi_id = $this->input->post('kasi_id');
        $data = $this->master->get_profesi($kasi_id);
        echo json_encode($data);
    }

}