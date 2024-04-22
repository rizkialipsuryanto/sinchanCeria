<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model  extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kasi($bidang_id){
        $hasil=$this->db->query("SELECT * FROM m_kasi WHERE bidang_id='$bidang_id'");
        return $hasil->result();
    }

    public function get_profesi($kasi_id){
        $hasil=$this->db->query("SELECT * FROM simrs.master_profesi WHERE kasi_id='$kasi_id'");
        return $hasil->result();
    }


    public function getTasks($limit, $start, $cari_ruang = null, $batal = null, $userid)
    {
        // print_r($userid);
        // die();
        $this->db->select('m_tasks.id,m_tasks.tasks, m_tasks.ruang,m_tasks.bidang_id,m_tasks.kasi_id');
        
        if ($cari_ruang) {
            $where = "m_tasks.ruang = '" . $cari_ruang . "'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->where("m_tasks.isActive = '1'");
        $this->db->limit($limit, $start);
        return $this->db->get_where('m_tasks', ['user_id' => $userid['uid']])->result_array();
    }

    public function getTasksDetail($limit, $start, $cari_task = null, $batal = null, $userid)
    {

        $this->db->select('m_tasks_detail.id,m_tasks_detail.id_tasks, m_tasks_detail.tasks_detail, m_tasks_detail.user_id,m_tasks.tasks');
        
        if ($cari_task) {
            $where = "m_tasks_detail.id_tasks = '" . $cari_task . "'";
            $this->db->where($where, NULL, FALSE);
        }

        $this->db->where("m_tasks.isActive = '1'");
        $this->db->limit($limit, $start);
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');

        return $this->db->get_where('m_tasks_detail', ['m_tasks_detail.user_id' => $userid['uid']])->result_array();
        // return $this->db->get_where('m_tasks_detail', ['user_id' => $userid['id']])->result_array();
        // print_r($this->db->get_where('m_tasks_detail', ['user_id' => $userid['id']])->result_array());
        // return $this->db->get('m_tasks_detail')->result_array();
    }

    public function getTasksDetailById($id)
    {

        // $this->db->select('id');
        // $this->db->select('id_tasks');
        // $this->db->select('tasks_detail');
        // return $this->db->get('m_tasks_detail')->result_array();

        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_tasks_detail.id,m_tasks_detail.id_tasks,m_tasks_detail.tasks_detail');
    
        return $this->db->get_where('m_tasks_detail', ['id' => $id])->result_array();
    }

    public function getKasiList($limit, $start, $keyword = null, $batal = null)
    {

        $this->db->select('kasi_id');
        $this->db->select('kasi');
        $this->db->select('bidang_id');
        return $this->db->get('m_kasi')->result_array();;
    }

    public function getBidangList($limit, $start, $keyword = null, $batal = null)
    {

        $this->db->select('bidang_id');
        $this->db->select('bidang');
        return $this->db->get('m_bidang')->result_array();;
    }

    public function getListRuang()
    {
        $this->db->order_by('userlevels.userlevelname', 'ASC');
            $this->db->where("simrs.userlevels.userlevelid > '0' and simrs.userlevels.is_unit_ruang = 1");
            return $this->db->get('simrs.userlevels')->result_array();
        
    }

    public function getListTasks($userid)
    {
        $this->db->order_by('id', 'ASC');
        $this->db->where("m_tasks.isActive = '1'");
            // return $this->db->get('m_tasks')->result_array();
        return $this->db->get_where('m_tasks', ['user_id' => $userid['uid']])->result_array();
        
    }

    public function getListBidang()
    {
        $this->db->order_by('bidang_id', 'ASC');
            return $this->db->get('simrs2012.m_bidang')->result_array();
        
    }

    public function getListKasi()
    {
        $this->db->order_by('kasi_id', 'ASC');
            return $this->db->get('simrs2012.m_kasi')->result_array();
        
    }

    public function getListProfesi()
    {
        $this->db->order_by('nama_profesi', 'ASC');
            return $this->db->get('simrs.master_profesi')->result_array();
        
    }

    public function getListKaruKoordinator()
    {
        // $this->db->order_by('nama_profesi', 'ASC');
            return $this->db->get_where('db_cuti.l_koordinator_karu', ['is_Active' => 1])->result_array();
        
    }

    public function getRole()
    {
        $this->db->order_by('id','ASC');
        return $this->db->get('simrs2012.user_role')->result_array();
    }

    public function getListSatuan()
    {
        $this->db->order_by('id','ASC');
        return $this->db->get('l_satuan_sinchan')->result_array();
    }

    public function getListTasksDetail()
    {
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('m_tasks_detail.id,m_tasks_detail.id_tasks,m_tasks_detail.tasks_detail');
         $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->where("m_tasks.isActive = '1'");
        $this->db->where('m_tasks_detail.user_id',  $data['user']['uid']);

        return $this->db->get('m_tasks_detail')->result_array();
        // return $this->db->get_where('m_tasks_detail', ['user_id' => $userid['id']])->result_array();

        // $this->db->select('*');
        // $this->db->from('m_tasks_detail');
        // $this->db->where("m_tasks_detail.id_tasks = '$id'");
        // $query_1 = $this->db->get_compiled_select();

        // $this->db->select('*');
        // $this->db->from('m_tasks_detail');
        // $this->db->where("m_tasks_detail.id_tasks = '1'");
        // $query_2 = $this->db->get_compiled_select();

        // $final_query = $this->db->query($query_1 . ' UNION ' . $query_2);

        // $result = $final_query->result_array();
        // return $result;
    }

    public function insertTasks($input)
    {
        $user           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $data["tasks"]           = $input['profesi'];
        $data["ruang"]           = $input['ruang'];
        $data["bidang_id"]           = $input['bidang'];
        $data["kasi_id"]           = $input['kasi'];
        $data["karu_koordinator_uid"]  = $input['karukoordinator'];
        $data["user_id"]           = $user['uid'];
        $data["isActive"]           = '1';
        
        $this->db->insert('m_tasks',$data);
    }

    public function nonActivProfesi($id)
    {
        // $id = $input['modal_id'];
        $data = array(
                'isActive' => '0'
            );
        $this->db->where('id', $id);
        $this->db->update('m_tasks', $data);
    }

    public function insertTasksDetail($input)
    {
        $user           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();
        
        $data["id_tasks"]           = $input['tasks'];
        $data["tasks_detail"]           = $input['tasks_detail'];
        $data["user_id"]           = $user['uid'];
        
        $this->db->insert('m_tasks_detail',$data);
    }

    public function insertBidang($input)
    {
        $data["bidang"]           = $input['bidang'];
        
        $this->db->insert('m_bidang',$data);
    }

    public function insertKasi($input)
    {
        
        $data["kasi"]           = $input['kasi'];
        $data["bidang_id"]           = $input['bidang'];
        
        $this->db->insert('m_kasi',$data);
    }

    public function updateTasksDetail($input)
    {
        $id = $input['modal_id'];
        $data = array(
                'tasks_detail' => $input['modal_tasksdetail']
            );
        $this->db->where('id', $id);
        $this->db->update('m_tasks_detail', $data);
    }

    public function getListUser($limit,$start,$keyword = null)
    {
        # code...
        // $this->db->limit($limit, $start);
        // return $this->db->get('simrs2012.user')->result_array();

        $this->db->select('user.id,user.firstname,user.lastname,user.email,user.role_id,user.is_active,user.poli,user.nik,user.nohp,user.alamat,user.ruang,master_login.pd_nickname,user.tasks');
        
        if ($keyword) {
            $where = "(user.firstname LIKE '%" . $keyword . "%' OR user.lastname LIKE '%" . $keyword . "%' OR master_login.pd_nickname LIKE '%" . $keyword ."%' OR user.email LIKE '%" . $keyword ."%')";
            $this->db->where($where, NULL, FALSE);
        }

        $this->db->limit($limit, $start);
        $this->db->join('simrs.master_login', 'simrs.master_login.uid = user.pegawai_id', 'left outer');

        return $this->db->get('user')->result_array();
    }

    public function getListWhere($where)
    {
        return $this->db->get_where('simrs2012.user', $where);
    }

    public function updateUser($input)
    {
        $id = $input['id'];

        $data = array(
            'firstname'     => $input['namadepan'],
            'lastname'      => $input['namabelakang'],
            'role_id'       => $input['role'],
            'is_active'     => $input['status'],
            'nik'           => $input['nik'],
            'nohp'          => $input['nohp'],
            'alamat'        => $input['alamat'],
            'ruang'         => $input['ruang'],
            'pegawai_id'    => $input['pegawaiid'],
            'tasks'         => $input['tasks']
        );

        $this->db->where('id', $id);
        $this->db->update('simrs2012.user', $data);
    }

    public function resetPassword($id)
    {
        // $id = $id;

        $data = array(
            'password'     => password_hash('12345678', PASSWORD_DEFAULT)
        );

        $this->db->where('id', $id);
        $this->db->update('simrs2012.user', $data);
    }

}
