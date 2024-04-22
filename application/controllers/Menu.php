<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model', 'menu');
    }


    public function index()
    {
        $data['title']  =   "Menu Management";
        $data['user']   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu']   =   $this->db->get('user_menu')->result_array();


        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            //sendTemplateView(1, 'menu/index', $data);

            sendToAdminLTE(1, 'menu/index', $data);
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">New Menu Added</div>'
            );
            redirect('menu');
        }
    }


    public function submenu()
    {
        $this->load->library('pagination');
        $data['title'] = "Sub Menu Management";
        $data['user']   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $config['base_url'] = site_url('menu/submenu');
        $config['total_rows'] = $this->menu->get_submenu_total();
        $config['per_page'] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['submenu']    =      $this->menu->getSubMenu($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
        $data['menu']       =       $this->db->get('user_menu')->result_array();


        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');


        if ($this->form_validation->run() == false) {
            sendToAdminLTE(1, 'menu/submenu', $data);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">New Sub Menu Added</div>'
            );
            redirect('menu/submenu');
        }
    }

    public function deletesubmenu()
    {
        $this->db->where('id', $_GET['id']);
        $this->db->delete('user_sub_menu');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Sub Menu Berhasil Dihapus</div>'
        );
        redirect('menu/submenu');
    }

    public function deletemenu()
    {
        $this->db->where('id', $_GET['id']);
        $this->db->delete('user_menu');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Menu Berhasil Dihapus</div>'
        );
        redirect('menu');
    }
}
