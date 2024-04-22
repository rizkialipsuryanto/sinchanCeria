<?php

class Template
{
    protected $_ci;
    function __construct()
    {
        $this->_ci = &get_instance();
    }

    function show($template, $data = null)
    {
        if (!$this->_is_process()) {
            $data['_navbar'] = $this->_ci->load->view('layouts/navbar', $data, true);
            $data['_main_sidebar'] = $this->_ci->load->view('layouts/main_sidebar', $data, true);
            // $data['_breadcrumbs'] = $this->_ci->load->view('layouts/breadcrumbs', $data, true);
            $data['_content_wrapper'] = $this->_ci->load->view($template, $data, true);
            $data['_main_footer'] = $this->_ci->load->view('layouts/main_footer', $data, true);
            $this->_ci->load->view('layouts/template', $data);
        } else {
            // $data['_breadcrumbs'] = $this->_ci->load->view('layouts/breadcrumbs', $data, true);
            $this->_ci->load->view($template, $data);
        }
    }

    function _is_process()
    {
        return ($this->_ci->input->server('HTTP_X_REQUESTED_WITH') && ($this->_ci->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest'));
    }
}
