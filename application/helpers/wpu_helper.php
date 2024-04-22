<?php

function is_logged_in()
{
    $ci =   get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id    = $ci->session->userdata('role_id');
        $menu       = $ci->uri->segment('1');
        $queryMenu  = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id    = $queryMenu['id'];
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
            // echo "eror";
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci =   get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked = 'checked'";
    }
}
function check_doctor_availability($tanggal, $kd_poli, $kd_dokter, $kd_layanan = 2)
{
    $ci =   get_instance();
    $ci->db->where('tanggal', $tanggal);
    $ci->db->where('kd_poli', $kd_poli);
    $ci->db->where('kd_dokter', $kd_dokter);
    $ci->db->where('kd_layanan', $kd_layanan);
    $result = $ci->db->get('t_dokterjaga');

    if ($result->num_rows() > 0) {
        return "checked = 'checked'";
    }
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP']; // share internet
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}


function getUsername($uid)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('user', ['user.id' => $uid])->row_array();
    if ($result) {
        $response =  $result["firstname"];
    } else {
        $response =  "-";
    }
    return $response;
}


function getStatusPulangPoliklinik($idxdaftar)
{
    $ci =   get_instance();

    $ci->db->limit(1);
    $ci->db->select('m_statuskeluar.keterangan');
    $ci->db->join('m_statuskeluar', 'y_keterangan_pasien.STATUS = m_statuskeluar.status', 'left outer');
    $result = $ci->db->get_where('y_keterangan_pasien', ['y_keterangan_pasien.IDXDAFTAR' => $idxdaftar])->row_array();


    if ($result) {
        $response =  $result["keterangan"];
    } else {
        $response =  "-";
    }
    return $response;
}


function getNamaPoliKlinik($kdpoliklinik)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_poly', ['m_poly.kode' => $kdpoliklinik])->row_array();
    if ($result) {
        $response =  $result["nama"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaDokter($kddokter)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_dokter', ['m_dokter.KDDOKTER' => $kddokter])->row_array();
    if ($result) {
        $response =  $result["NAMADOKTER"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaCaraBayar($kdCarabayar)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_carabayar', ['m_carabayar.KODE' => $kdCarabayar])->row_array();
    if ($result) {
        $response =  $result["NAMA"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaRujukan($kdrujukan)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_rujukan', ['m_rujukan.KODE' => $kdrujukan])->row_array();
    if ($result) {
        $response =  $result["NAMA"];
    } else {
        $response =  "-";
    }
    return $response;
}



function y_igd_kamar_pasien($kdKamar)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('y_igd_kamar_pasien', ['y_igd_kamar_pasien.ID_KAMAR_PASIEN' => $kdKamar])->row_array();
    if ($result) {
        $response =  $result["NAMA"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getTime($type = 1, $time)
{

    if ($type == 1) {
        $response = date("H:i:s", $time);
    } else {
        $response = date("Y-m-d H:i:s", $time);
    }

    return $response;
}

function getFullUrl()
{
    //
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";

    // Here append the common URL characters. 
    $link .= "://";

    // Append the host(domain name, ip) to the URL. 
    $link .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL 
    $link .= $_SERVER['REQUEST_URI'];

    // Print the link 
    return $link;
}


function getStatusPulangPoli($kdStatus)
{
    //SELECT * FROM simrs2012.m_statuskeluar;
    $ci =   get_instance();
    $result = $ci->db->get_where('m_statuskeluar', ['m_statuskeluar.status' => $kdStatus])->row_array();
    if ($result) {
        $response =  $result["keterangan"];
    } else {
        $response =  "-";
    }
    return $response;
}

function sendTemplateView($flag, $view, $data)
{

    $ci =   get_instance();

    $ci->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $ci->output->set_header('Pragma: no-cache');
    $ci->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    if ($flag == 1) {
        $ci->load->view('template/header', $data);
        $ci->load->view('template/navbar', $data);
        $ci->load->view('template/sidebar', $data);
        $ci->load->view('template/message', $data);
        $ci->load->view('template/pageheader', $data);
        $ci->load->view($view, $data);
        $ci->load->view('template/footer', $data);
    } else if ($flag == 2) {
        $ci->load->view('auth/header', $data);
        $ci->load->view($view, $data);
        $ci->load->view('auth/footer', $data);
    }
}

function sendToAdminLTE($flag, $view, $data)
{
    $ci =   get_instance();

    $ci->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $ci->output->set_header('Pragma: no-cache');
    $ci->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    if ($flag == 1) {
        //Send to adminLTE template
        $ci->load->view('AdminLTE/header', $data);
        $ci->load->view('AdminLTE/main_header', $data);
        $ci->load->view('AdminLTE/aside_main_sidebar', $data);
        $ci->load->view('AdminLTE/content_wrapper', $data);
        $ci->load->view('AdminLTE/notification', $data);
        $ci->load->view($view, $data);
        $ci->load->view('AdminLTE/main_footer', $data);
        $ci->load->view('AdminLTE/aside_footer', $data);
    } else if ($flag == 2) {
        //send to login auth page
        $ci->load->view('Login_v15/header', $data);
        $ci->load->view($view, $data);
        $ci->load->view('Login_v15/footer', $data);
    }
}


function setMessage($affectedrows)
{
    $ci =   get_instance();
    if ($affectedrows > 0) {
        $ci->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert"> Berhasil</div>'
        );
    } else {
        $ci->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert"> Gagal</div>'
        );
    }
}

function showMessage($type, $message)
{
    $ci =   get_instance();

    if ($type == 'info') {
        $icon = "icon fa fa-info";
        $class = "alert alert-info alert-dismissible";
    } else if ($type == 'success') {
        $icon = "icon fa fa-ban";
        $class = "alert alert-success alert-dismissible";
    } else if ($type == 'warning') {
        $icon = "icon fa fa-warning";
        $class = "alert alert-warning alert-dismissible";
    } else {
        $icon = "icon fa fa-ban";
        $class = "alert alert-danger alert-dismissible";
    }

    $ci->session->set_flashdata(
        'message',
        '<div class="' . $class . '">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="' . $icon . '"></i> ' . $message . '</h4>
        </div>'
    );
}
