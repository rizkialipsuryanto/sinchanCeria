<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        is_logged_in();

        // kudu_ngisii_form();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Role_model', 'role');
        $this->load->helper('wpu');
    }


    public function index()
    {
        $data['title'] = "Dashboard";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['dashboard'] = [
            'jumlahpasienhariini' => '56',
            'jumlahpasienbulanini' => '89',
            'jumlahpasienumum' => '32',
            'jumlahpasienjaminan' => '12'
        ];

        $data["online"] = $this->getOnlineList();
        sendToAdminLTE(1, 'admin/index', $data);
    }

    public function role()
    {
        $data['title'] = "Role";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();


        // $roleId = $this->input->post('role');
        $this->form_validation->set_rules('role', 'role', 'required');

        if ($this->form_validation->run() == false) {
            sendToAdminLTE(1, 'admin/role', $data);
        } else {
            $result = $this->role->addNewRole($this->input->post());
            setMessage($result);
            redirect('admin/role');
        }
    }

    public function roleaccess($role_id)
    {
        if ($role_id != 'undefined') {
            $data['title'] = "Role Access";
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();


            $this->db->where('id !=', 1);
            $data['menu'] = $this->db->get('user_menu')->result_array();
            //sendTemplateView(1, 'admin/role-access', $data);

            // $data["js_to_load"] = [
            //     base_url("assets/js/kasir.js")
            // ];
            sendToAdminLTE(1, 'admin/role-access', $data);
        } else {
            redirect('auth/logout');
        }
    }

    public function changeaccess()
    {
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');



        $data = [
            'role_id' => $roleId,
            'menu_id' => $menuId

        ];

        $result = $this->db->get_where('user_access_menu', $data);


        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Access changed!</div>'
        );
    }

    public function getOnlineList()
    {

        $user_online = $this->admin->loadOnlineUser();
        $html = "";
        $html .= '<div class="box box-success">';
        $html .= '<div class="box-header with-border">';
        $html .= '<h3 class="box-title">Latest Members</h3>';
        $html .= '<div class="box-tools pull-right">';
        $html .= '<span class="label label-success">Members</span>';
        $html .= '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>';
        $html .= '<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="box-body no-padding">';
        $html .= '<ul class="users-list clearfix">';

        //date("Y-m-d H:i:s", $data["tgl_bayar"]) 

        foreach ($user_online as $ou) {
            $html .= '<li>';
            $html .= '<img src="' . base_url('assets/img/profile/') . '' . $ou["image"] . ' " alt="User Image">';
            $html .= '<a data-toggle="tooltip" title="Nama Petugas"  class="users-list-name" href="#">' . ucwords(strtolower($ou["firstname"])) . '</a>';
            $html .= '<span class="users-list-date" data-toggle="tooltip" title="Tanggal Login">' . date("Y-m-d", $ou["lastlogin"]) . '</span>';
            $html .= '<span class="users-list-date" data-toggle="tooltip" title="Jam Login">' . date("H:i:s", $ou["lastlogin"]) . '</span>';
            $html .= '<span class="users-list-date" data-toggle="tooltip" title="IP"><strong>' . $ou["lastip"] . '</strong></span>';

            $html .= '</li>';
        }





        $html .= '</ul>';
        $html .= '</div>';
        $html .= '<div class="box-footer text-center">';
        $html .= '<a href="javascript:void(0)" class="uppercase">View All Users</a>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
