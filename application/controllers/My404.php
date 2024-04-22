<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My404 extends CI_Controller
{


        function __construct()
        {
                parent::__construct();
                $this->load->helper('wpu');
                // $this->ci_minifier->set_domparser(2);
                // $this->ci_minifier->init(1);
                // $this->ci_minifier->enable_obfuscator(3);
        }

        public function index()
        {
                $data['title'] = "Page Not Found";
                $data['user']   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->output->set_status_header('404');
                if ($data['user']) {
                        sendToAdminLTE(1, 'errors/page_404', $data);
                } else {
                        redirect('auth');
                }
        }
}
