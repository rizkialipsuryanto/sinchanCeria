<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('wpu');
        $this->load->model('User_model', 'user');
        $this->load->model('Poli_model', 'poli');
        $this->load->model('Pegawai_model', 'pegawai');
        $this->load->model('LogAuth_model', 'logauth');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('user');
        } else {
            $this->form_validation->set_rules('username', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            if ($this->form_validation->run() === false) {
                clearstatcache();
                $data['title'] = "Login Page";
                sendToAdminLTE(2, 'Login_v15/login', $data);
            } else {
                $this->_login();
            }
        }
    }

    private function _login()
    {

        $username        = $this->input->post('username');
        $password    = $this->input->post('password');

        $user        = $this->db->get_where('master_login', ['username' => $username])->row_array();

        if ($user) {
            // if ($user['active'] == 1 && $user['role_id'] != 95) {
                // if (password_verify($password, $user['password_ci'])) {
                if ($user['password'] == $password) {
                    $data = [
                        'username'        =>    $user['username'],
                        'role_id'    =>    $user['role_id']
                    ];
                    $this->session->set_userdata($data);

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">Login Berhasil</div>'
                    );
                    redirect('user');
                    // $this->user->updateLastLogin($user["uid"]);


                    // switch ($user['role_id']) {
                    //     case 1:
                    //         //redirect('rekammedis/dashboard');
					// 		redirect('user');
                    //         break;
                    //     case 2:
                    //         redirect('user');
                    //         break;
                    //     case 3:
                    //         redirect('user');
                    //         break;
                    //     case 4:
                    //         //redirect('rekammedis/dashboard');
					// 		redirect('user');
                    //         break;
                    //     case 5:
                    //         redirect('user');
                    //         break;
                    //     case 6:
                    //         redirect('user');
                    //         break;
                    //     case 7:
                    //         redirect('user');
                    //         break;
                    //     case 8:
                    //         redirect('user');
                    //         break;
                    //     case 9:
                    //         //redirect('rawatinap/dashboard');
					// 		redirect('user');
                    //         break;
                    //     case 10:
                    //         redirect('user');
                    //         break;
                    //     default:
                    //         redirect('user');
                    // }
                // } else {
                //     $this->session->set_flashdata(
                //         'message',
                //         '<div class="alert alert-danger" role="alert">Wrong password !</div>'
                //     );
                //     redirect('auth');
                // }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">This email has not been activated !</div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">Email is not registered !</div>'
            );
            redirect('auth');
        }
    }

    public function logout()
    {

        $user  =   $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();
        $this->user->updateLastLogout($user["id"]);


        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');


        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger btn-fw" role="alert">You have been logout !</div>'
        );
        redirect('auth');
    }

    public function registration()
    {

        $data['poli']   =   $this->poli->getListRuang();
        $data['pegawai']   =   $this->pegawai->getPegawai();

        // $data["css_arr_head"] = array(
        //     'select2/dist/css/select2.min.css'
        // );

        // $data["js_arr_foot"] = array("controllers/cssd/acceptTool.js");

        if ($this->session->userdata('username')) {
            redirect('user');
        }

        $this->form_validation->set_rules('firstname', 'Firstname', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|trim');
        $this->form_validation->set_rules('no_identitas', 'no_identitas', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            [
                'is_unique'        => 'Email sudah terdaftar!'
            ]
        );
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|matches[password2]',
            [
                'matches'        => 'Password dont Macth!',
                'min_length'    => 'Passsword too Short'
            ]
        );


        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() === false) {
            $data['title'] = "Registration";
            $data["css_arr_head"] = array(
                'select2/dist/css/select2.min.css'
            );

            $data["js_arr_foot"] = array("controllers/cssd/acceptTool.js");
            //sendTemplateView(2, 'auth/registration', $data);
            sendToAdminLTE(2, 'Login_v15/registration', $data);
        } else {


            $email  = $this->input->post('email');

            $datanya   =   $this->pegawai->getPegawaiById($this->input->post('no_identitas'));

            if (empty($datanya)) {
                // print_r("data kosong");
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Identitas belum lengkap atau belum terdaftar di Database Kepegawaian.\n Silahkan lengkapi data no identitas/ noktp di simrsv2</div>'
                );
                redirect('auth');
            } else {
                // print_r($this->input->post('cbpoli'));
                // die();
                $no_identitas = $datanya[0]['uid'];
                $data = [
                    'firstname' => htmlspecialchars($this->input->post('firstname'), true),
                    'lastname' => htmlspecialchars($this->input->post('lastname'), true),
                    // 'ruang' => htmlspecialchars($this->input->post('cbpoli'), true),
                    'pegawai_id' => htmlspecialchars($no_identitas, true),
                    'email' => htmlspecialchars($email, true),
                    'image' => 'default.png',
                    'password' =>  password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'role_id' =>  2,
                    'is_active' =>  1,
                    'date_created' =>  time()
                ];

                // print_r($datanya[0]['uid']);
                // die();
                $token = base64_encode(random_bytes(32));

                $user_token =  [
                    'email'            => $email,
                    'token'            => $token,
                    'date_created'    => time()
                ];

                $this->db->insert('user', $data);
                $this->db->insert('user_token', $user_token);

                // kirim email
                $this->_sendEmail($token, 'verify');

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Selamat, Akun kamu telah berhasil dibuat.\n Langkah selanjutnya, silakan lakukan aktivasi melalui email yang telah dikirim</div>'
                );
                redirect('auth');
            }

            // die();

        }
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() === false) {
            $data['title'] = "Lupa Password";
            // sendTemplateView(2, 'auth/forgot-password', $data);
            sendToAdminLTE(2, 'Login_v15/forgot-password', $data);
        } else {

            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                //
                $token = base64_encode(random_bytes(32));

                $user_token =  [
                    'email'            => $email,
                    'token'            => $token,
                    'date_created'    => time()
                ];

                $this->db->insert('user_token', $user_token);

                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success" role="alert">Silakan cek di email kamu untuk melakukan reset password</div>'
                );
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Email tidak terdaftar atau belum diaktivasi !</div>'
                );
                redirect('auth/forgotpassword');
            }
        }
    }

    private function _sendEmail($token, $type)
    {

        $config = [
            // 'protocol'    => 'smtp',
            // 'smtp_host' => 'ssl://smtp.googlemail.com',
            // 'smtp_user' => 'esensiana.com@gmail.com',
            // 'smtp_pass' => 'satujamlebihdekat14045',
            // 'smtp_port' =>     465,
            // 'mailtype'    => 'html',
            // 'charset'    => 'utf-8',
            // 'newline'    => "\r\n"

            'protocol'    => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'itirsudajibarang@gmail.com',
            'smtp_pass' => 'oratidokan',
            'smtp_port' =>     465,
            'mailtype'    => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n"
        ];



        $param["flag"] = $type;
        $this->logauth->save($param);

        //$this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('itirsudajibarang@gmail.com', 'IT RSUD AJIBARANG');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Silakan Buka Email ini di komputer yang sama dengan komputer untuk membuka simrs ini<br> Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . ' ">Activate</a> <br><br><br><br><br><br>Rumah Sakit Umum Daerah Ajibarang | Software Consultant | Jl. Raya Ajibarang - Pancasan Jl. Ajibarang - Wangon, Kaliumbul, Pancurendang, Kec. Ajibarang, Kabupaten Banyumas, Jawa Tengah 53163');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Silakan Buka Email ini di komputer yang sama dengan komputer untuk membuka simrs ini<br> Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . ' ">Reset Password</a> <br><br><br><br><br><br>Rumah Sakit Umum Daerah Ajibarang | Software Consultant | Jl. Raya Ajibarang - Pancasan Jl. Ajibarang - Wangon, Kaliumbul, Pancurendang, Kec. Ajibarang, Kabupaten Banyumas, Jawa Tengah 53163');
        }


        if ($this->email->send()) {
            return true;
        } else {

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">email tidak terkirim.!!! email server sedang dilakukan perbaikan. hubungi IT untuk dilakukan perbaikan</div>'
            );
            // $this->session->set_flashdata(
            //     'message',
            //     '<div class="alert alert-danger" role="alert">' . $this->email->print_debugger() . '</div>'
            // );
            redirect('auth');
            // echo $this->email->print_debugger();
            // die();
        }
    }

    public function verify()
    {
        // 
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {


                if (time() - $user_token['date_created'] < (60   * 60 * 24)) {

                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');


                    $this->db->delete('user_token', ['email' => $email]);


                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">' . $email . ' has been activated, please login!</div>'
                    );
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">Account Activation failed, token expired</div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Account Activation failed, token invalid</div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">Account Activation failed, wrong email!</div>'
            );
            redirect('auth');
        }
    }

    public function blocked()
    {
        //echo 'access blocked';
        $data['title'] = "Akses ditolak";
        $data['footer'] = "Copyright &copy; " . date('Y') . " All rights reserved.";
        $data['h3']  = "Kamu tidak berhak mengakses halaman ini";
        $this->load->view('auth/blocked', $data);
    }


    public function resetpassword()
    {

        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {

                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">Reset Password failed, token invalid</div>'
                );
                redirect('auth/forgotpassword');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">Reset Password failed, wrong email!</div>'
            );
            redirect('auth/forgotpassword');
        }
    }

    public function changePassword()
    {

        if (!$this->session->userdata['reset_email']) {
            redirect('auth');
        }


        $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]|min_length[5]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim|matches[password1]|min_length[5]');

        if ($this->form_validation->run() == false) {
            //
            $data['title'] = "Ubah Password";
            // $this->load->view('templates/auth_header', $data);
            // $this->load->view('auth/change-password');
            // $this->load->view('templates/auth_footer');
            //sendTemplateView(2, 'auth/change-password', $data);
            sendToAdminLTE(2, 'Login_v15/change-password', $data);
        } else {
            //
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Password has been changed!, please login</div>'
            );
            redirect('auth');
        }
    }

    public function webinar()
    {

        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        // $this->form_validation->set_rules('lastname', 'Lastname', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            [
                'is_unique'        => 'Email sudah terdaftar!'
            ]
        );
        // $this->form_validation->set_rules(
        //     'password1',
        //     'Password',
        //     'required|trim|min_length[3]|matches[password2]',
        //     [
        //         'matches'        => 'Password dont Macth!',
        //         'min_length'    => 'Passsword too Short'
        //     ]
        // );


        // $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() === false) {
            $data['title'] = "Webinar";
            //sendTemplateView(2, 'auth/registration', $data);
            sendToAdminLTE(2, 'Login_v15/webinar', $data);
        } else {


            $email  = $this->input->post('email');

            $data = [

                'email' => htmlspecialchars($email, true),
                'nama' => htmlspecialchars($this->input->post('nama'), true),
                'nohp' => htmlspecialchars($this->input->post('nohp'), true),
                'alamat' => htmlspecialchars($this->input->post('alamat'), true),
                'instansi' => htmlspecialchars($this->input->post('instansi'), true),
                'profesi' => htmlspecialchars($this->input->post('profesi'), true)
                // 'image' => 'default.png',
                // 'password' =>  password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                // 'role_id' =>  2,
                // 'is_active' =>  0,
                // 'date_created' =>  time()
            ];



            $token = base64_encode(random_bytes(32));

            // print_r($token);
            // die();

            // $user_token =  [
            //     'email'            => $email,
            //     'token'            => $token,
            //     'date_created'    => time()
            // ];

            $this->db->insert('t_webinar_pendaftaran', $data);
            // $this->db->insert('user_token', $user_token);

            // kirim email
            $this->_sendEmailWebinar($token, 'verify');

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Selamat, Akun kamu telah berhasil dibuat.\n Langkah selanjutnya, silakan lakukan aktivasi melalui email yang telah dikirim</div>'
            );
            redirect('auth');
        }
    }

    private function _sendEmailWebinar($token, $type)
    {
        $config = [
            'protocol'    => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'code.javac@gmail.com',
            'smtp_pass' => '',
            'smtp_port' =>     465,
            'mailtype'    => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n"
        ];



        //$this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('code.javac@gmail.com', 'Bukti Pendaftaran');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Yth. Bapak/Ibu peserta Webinar Di Tempat');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Yth. Bapak/Ibu peserta Webinar Di Tempat');
        }


        if ($this->email->send()) {
            return true;
        } else {

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">email tidak terkirim.!!! email server sedang dilakukan perbaikan. hubungi IT untuk dilakukan perbaikan</div>'
            );
            // $this->session->set_flashdata(
            //     'message',
            //     '<div class="alert alert-danger" role="alert">' . $this->email->print_debugger() . '</div>'
            // );
            redirect('auth');
            // echo $this->email->print_debugger();
            // die();
        }
    }
}
