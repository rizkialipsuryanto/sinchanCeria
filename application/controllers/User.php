<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // is_logged_in();

        $this->load->model('User_model', 'user');
        // $this->load->model('Pegawai_model', 'pegawai');
        $this->load->model('Master_model', 'master');

        $this->load->helper('pendaftaran');
        $this->load->helper('user');
        $this->load->helper('wpu');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        
        $data['title'] = "My Profile";
        $data['user'] = $this->db->get_where('master_login', ['username' => $this->session->userdata('username')])->row_array();
        
        // print_r($data['user']);
        // die();
        sendToAdminLTE(1, 'user/index', $data);
    }

    public function edit()
    {
        $data['title'] = "Edit Profile";
        $data['user'] = $this->db->get_where('master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data['ruang']  = $this->master->getListRuang();

        $data["css_arr_head"] = array(
        );

        $data["js_arr_foot"] = array(
        );


        $this->form_validation->set_rules('pd_nickname', 'Nama', 'required');
        $this->form_validation->set_rules('no_identitas', 'Nomor Identitas', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('userlevelid', 'Ruang', 'required');
        $this->form_validation->set_rules('nip', 'Nip', 'required');
        $this->form_validation->set_rules('tanggal_masuk_kerja', 'Nip', 'required');

        if ($this->form_validation->run() == false) {
            $data["js_to_load"] = "";

            sendToAdminLTE(1, 'user/edit', $data);
        } else {

            $pd_nickname  = $this->input->post('pd_nickname');
            $no_identitas   = $this->input->post('no_identitas');
			$tanggal_lahir   = $this->input->post('tanggal_lahir');
            $alamat      = $this->input->post('alamat');
            $no_telp  = $this->input->post('no_telp');
            $userlevelid      = $this->input->post('userlevelid');
            $nip      = $this->input->post('nip');
            $tanggal_masuk_kerja      = $this->input->post('tanggal_masuk_kerja');

            //cek jika ada gambar yang akan di upload
            $uploadImage = $_FILES['image']['name'];

            if ($uploadImage) {

                $config['upload_path'] = FCPATH . 'assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png|JPG|jpeg';
                $config['max_size']     = '5048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $old_image = $data['user']['image'];

                    if ($old_image != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image  = $this->upload->data('file_name');
                    $this->db->set('image',  $new_image);
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">Gagal Upload Foto Profile : ' . $this->upload->display_errors() . '</div>'
                    );
                    redirect('user');
                }
            }

            $this->db->set('pd_nickname', $pd_nickname);
            $this->db->set('no_identitas', $no_identitas);
			$this->db->set('tanggal_lahir', $tanggal_lahir);
            $this->db->set('alamat', $alamat);
            $this->db->set('no_telp', $no_telp);
            $this->db->set('userlevelid', $userlevelid);
            $this->db->set('nip', $nip);
            $this->db->set('tanggal_masuk_kerja', $tanggal_masuk_kerja);

            $this->db->where('username', $this->session->userdata('username'));
            $this->db->update('simrs.master_login');


            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Your profile has been updated!</div>'
            );

            redirect('user');
        }
    }

    public function karyawan()
    {
        $data['title'] = "My Profile";
        $data["css_arr_head"] = array(
        );

        $data["js_arr_foot"] = array(
        );
        $data['user'] = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data['karyawan'] = $this->user->getDataKaryawan();
        
        sendToAdminLTE(1, 'user/karyawan', $data);
    }

    public function changepassword()
    {
        $data['title'] = "Change Password";
        $data['user'] = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();


        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {

            sendToAdminLTE(1, 'user/changepassword', $data);
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Wrong current password!</div>'
                );
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">Password cannot be same as current password</div>'
                    );
                    redirect('user/changepassword');
                } else {

                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">Password changed!</div>'
                    );
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function dailyRecords()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('pagination');

        // echo date('d / M / y');

        $data['id'] = $this->uri->segment(3);

        $data['title']          = "Daily Records";
        $data['user']           = $this->db->get_where('master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data['profesi']          = $this->db->get_where('master_profesi', ['id_profesi' => $data['user']['id_profesi']])->row_array();
        $idprofesi = $data['profesi']['id_profesi'];

        $data['tupoksi']          = $this->db->get_where('m_tupoksi', ['id_profesi' => $idprofesi])->result_array();
        $idtupoksi = $data['tupoksi'];
        $data['satuan']   =   $this->master->getListSatuan();
        if ($this->input->post('caripembayaran')) {

            $data['bataldaftar']   = $this->input->post('bataldaftar');
            $this->session->set_userdata('bataldaftar', $data['bataldaftar']);
            $data['tanggalcari']   = $this->input->post('tanggalcari');

            // print_r($this->input->post('tanggalcari'));
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
        // $config["base_url"]     =   base_url('user/dailyRecords/');
        // $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by');
        // $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks');
        // if ($tanggal) {
        //     $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
        //     $this->db->where($where, NULL, FALSE);
        // }
        // $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        // $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        // $where = "dailyrecords.created_by = '". $userid."' and m_tasks.isActive = '1'";
        // $this->db->where($where, NULL, FALSE);
        // $this->db->order_by('dailyrecords.tanggal', 'DESC');
        // $this->db->order_by('dailyrecords.id', 'DESC');
        // $this->db->from('dailyrecords');


        // $config["total_rows"]   = $this->db->count_all_results();
        // $data['total_rows']     = $config["total_rows"];
        // $config["per_page"]     = "10";

        // $this->pagination->initialize($config);

        // $data['nomer'] = $this->uri->segment(3);
        // // // 
        // $data["daily"] = $this->user->getDailyByUser($config["per_page"], $data['nomer'], $data['tanggalcari'], $userid, $data["bataldaftar"]);


        // $data["dailyById"] = $this->user->getDailyById($data["id"]);

        // $data["links"] =  $this->pagination->create_links();

        sendToAdminLTE(1, 'user/dailyrecords', $data);
    }

    public function dailyRecordsPrint()
    {
        $data['id'] = $this->uri->segment(3);
        $data['title']          = "Daily Records";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();
        $userid = $data['user']['uid'];

        $data['tasks']           = $this->db->get_where('m_tasks', ['user_id' => $data['user']['uid']])->row_array();
        

        $data['daily'] = $this->user->getDailyByUsers(['created_by' => $userid]);

        $this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-daily.pdf";
		$this->pdf->load_view('user/laporan-karyawan', $data);
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

                if ($_POST['tanggal'] == "" or $_POST['jumlah'] == "" or $_POST['tupoksi'] == "" or $_POST['satuan'] == "" or $_POST['catatan_harian'] == "") {
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

    public function cetakLHK()
    {
        $data['title']          = "Cetakan LHK";
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data['kegiatan']   =   $this->master->getListTasksDetail();
        $data['tasks']   =   $this->master->getListTasks($data['user']);
        $data['bulan']  = 8;
        $data['tahun']  = 2022;
        // print_r($data['kegiatan']);
        // die();
        $mpdf = new \Mpdf\Mpdf([
            'format' => [216,356],
            'mode' => 'utf-8',
            'orientation' => 'L',
            'default_font_size' => 12,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 7,
            'margin_bottom' => 5,
            'default_font' => 'ubuntu'
        ]);
        // print_r("Cetak LHK");
        // die();
        // $mpdf = new \Mpdf\Mpdf();
        sendToAdminLTE(1, 'cetak/cetakLHK', $data);
        $mypdf = $this->load->view('cetak/cetakLHK', $data, true);
        $mpdf->WriteHTML($mypdf);
        $mpdf->Output();
    }
}
