<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sinchan_model  extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }



    public function updateLastLogin($id)
    {

        $ip = getRealIpAddr();
        $logintime = time();

        // $this->db->set('online', 1);
        $this->db->set('lastip', $ip);
        $this->db->set('last_login',  $logintime);

        $this->db->where('id', $id);
        $this->db->update('simrs.master_login');
    }

    public function updateLastLogout($id)
    {
        $this->db->set('online', 0);
        $this->db->where('id', $id);
        $this->db->update('user');
    }

    public function userByRole($id)
    {

        $this->db->select('id');
        $this->db->select('firstname');
        $this->db->select('lastname');
        $this->db->where('role_id', $id);
        $this->db->where('is_active', '1');
        return $this->db->get('user')->result_array();;
    }

    public function getListRuang()
    {
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('userlevelid, userlevelname, id_kepala_unit_ruang');
        $where = "id_kepala_unit_ruang != ''";
        $this->db->where($where, NULL, FALSE);
        return $this->db->get('simrs.userlevels')->result_array();
    }

    public function getListKaruKoordinator()
    {
        // $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('nama_emp');
        // $where = "is_karu = '1'";
        // $this->db->where($where, NULL, FALSE);
        return $this->db->get('db_cuti.l_koordinator_karu')->result_array();
    }

    public function getDailyByUser($limit, $start, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by');
        $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks');
        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $where = "dailyrecords.created_by = '". $userid."' and m_tasks.isActive = '1'";
        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.id', 'DESC');
        $this->db->limit($limit, $start);
        
        // $this->db->where("m_tasks.isActive = '1'");
        return $this->db->get('dailyrecords')->result_array();
    }

    public function getDailyByUserAtasan($limit, $start, $status = null, $profesi = null, $ruang = null, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback,dailyrecords.feedback_at, m_kasi.kasi_id, m_kasi.ka_kasi');
        $this->db->select('m_tasks.tasks,m_tasks_detail.id_tasks, m_tasks.ruang');

        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_kasi', 'm_kasi.kasi_id = m_tasks.kasi_id', 'left outer');
        $this->db->join('simrs.master_login', 'master_login.uid = dailyrecords.created_by', 'left outer');
        $where = "m_kasi.ka_kasi = '".$userid."' and m_tasks.isActive = '1' and dailyrecords.created_by != '".$userid."' and simrs.master_login.is_karu = '1'";
        if ($tanggal) {
            $this->db->where("dailyrecords.tanggal", $tanggal);
        }
        if ($profesi) {
            $this->db->where("m_tasks.tasks", $profesi);
        }
        if ($ruang) {
            $this->db->where("m_tasks.ruang", $ruang);
        }
        if ($status) {
            $this->db->where("dailyrecords.verif", $status);
        }

        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.created_by', 'DESC');
        $this->db->limit($limit, $start);
        
        return $this->db->get('dailyrecords')->result_array();
    }

    public function getDailyByUserAtasan_Kabid($limit, $start, $profesi = null, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback, m_bidang.bidang_id, m_bidang.ka_bidang');
        $this->db->select('m_tasks.tasks,m_tasks_detail.id_tasks');

        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_bidang', 'm_bidang.bidang_id = m_tasks.bidang_id', 'left outer');
        $this->db->join('simrs.master_login', 'master_login.uid = m_tasks.user_id', 'left outer');
        $where = "m_bidang.ka_bidang = '".$userid."' and m_tasks.isActive = '1' and master_login.is_karu != '' and dailyrecords.created_by != '".$userid."'";
        if ($tanggal) {
            $this->db->where("dailyrecords.tanggal", $tanggal);
        }
        if ($profesi) {
            $this->db->where("m_tasks.tasks", $profesi);
        }

        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.created_by', 'DESC');
        $this->db->limit($limit, $start);
        
        return $this->db->get('dailyrecords')->result_array();
    }

    public function getDailyByUserAtasan_Direktur($limit, $start, $profesi = null, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback, m_bidang.bidang_id, m_bidang.ka_bidang');
        $this->db->select('m_tasks.tasks,m_tasks_detail.id_tasks');

        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        $this->db->join('m_bidang', 'm_bidang.bidang_id = m_tasks.bidang_id', 'left outer');
        $this->db->join('simrs.master_login', 'master_login.uid = m_tasks.user_id', 'left outer');
        $where = "m_tasks.isActive = '1' and master_login.is_manajemen != '' and dailyrecords.created_by != '".$userid."'";
        if ($tanggal) {
            $this->db->where("dailyrecords.tanggal", $tanggal);
        }
        if ($profesi) {
            $this->db->where("m_tasks.tasks", $profesi);
        }

        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.created_by', 'DESC');
        $this->db->limit($limit, $start);
        
        return $this->db->get('dailyrecords')->result_array();
    }

    public function getDailyByUserAtasan_Karu($limit, $start, $status = null, $bawahan = null, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback,dailyrecords.feedback_at');
        $this->db->select('m_tasks.tasks,m_tasks_detail.id_tasks');

        $this->db->join('m_tasks_detail', 'm_tasks_detail.id = dailyrecords.id_tasks_detail', 'left outer');
        $this->db->join('m_tasks', 'm_tasks.id = m_tasks_detail.id_tasks', 'left outer');
        // $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = m_tasks.ruang', 'left outer');
        $where = "m_tasks.karu_koordinator_uid = '".$userid."' and m_tasks.isActive = '1' and dailyrecords.created_by != '".$userid."'";
        if ($tanggal) {
            $this->db->where("dailyrecords.tanggal", $tanggal);
        }
        if ($bawahan) {
            // $this->db->where("m_tasks.tasks", $bawahan);
            $this->db->where("dailyrecords.created_by", $bawahan);
        }
        if ($status) {
            $this->db->where("dailyrecords.verif", $status);
        }

        $this->db->where($where, NULL, FALSE);
        $this->db->order_by('dailyrecords.tanggal', 'DESC');
        $this->db->order_by('dailyrecords.created_by', 'DESC');
        $this->db->limit($limit, $start);
        
        return $this->db->get('dailyrecords')->result_array();
    }

    public function getDataWhereDate($tanggal)
    {
        $this->db->select('dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan, dailyrecords.jam_mulai,dailyrecords.jam_selesai,dailyrecords.durasi');

        if ($tanggal) {
            $where = "substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."'";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->where($where);
        $this->db->order_by('tanggal', 'ASC');

        return $this->db->get('dailyrecords')->result_array();
        
    }

    public function getDailyById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('id');
        $this->db->select('tanggal');
        $this->db->select('substring(tanggal,6,2) as bulan');
        $this->db->select('year(tanggal) as tahun');
        $this->db->select('id_tasks_detail');
        $this->db->select('catatan');
        $this->db->select('jam_mulai');
        $this->db->select('jam_selesai');
        $this->db->select('durasi');
        $this->db->select('jumlah');
        $this->db->select('satuan');
    
        return $this->db->get_where('dailyrecords', ['id' => $id])->result_array();
    }

    public function getProsentase($limit, $start, $keyword = null, $batal = null)
    {

        // $this->db->select('id');
        // $this->db->select('tasks');
        // $this->db->select('ruang');
        // return $this->db->get('m_tasks')->result_array();;

        date_default_timezone_set('Asia/Jakarta');

        $tgl = '59';
        $this->db->select('aa.created_by');
        $this->db->select('d.userlevelid as ruang');
        $this->db->select('f.pd_nickname as nama,f.id_profesi');
        $this->db->select('ROUND((select count(a.id) from dailyrecords a left join m_tasks_detail b on b.id = a.id_tasks_detail where b.id_tasks = "3")/(count(aa.id))*100, 0) as prosentase_nonumum , ROUND((select count(a.id) from dailyrecords a left join m_tasks_detail b on b.id = a.id_tasks_detail where b.id_tasks = "1")/(count(aa.id))*100, 0) as prosentase_umum');
        // $this->db->select('m_pasien.NAMA');
        // $this->db->select('m_pasien.ALAMAT');
        // $this->db->select('m_carabayar.NAMA AS `CARABAYAR` ');

        $this->db->limit($limit, $start);
        $this->db->group_by('aa.created_by');
        $this->db->join('user c', 'c.id = aa.created_by', 'left outer');
        $this->db->join('m_tasks e', 'e.id = c.tasks', 'left outer');
        $this->db->join('simrs.userlevels d', 'd.userlevelid = e.ruang', 'left outer');
        $this->db->join('simrs.master_login f', 'f.uid = c.pegawai_id', 'left outer');
        return $this->db->get_where('dailyrecords aa', ['aa.created_by' =>  $tgl])->result_array();
    }

    public function insertdailyRecords($input)
    {

        $waktu_awal        =strtotime("".$input['tanggal']." ".$input['jam_mulai'].":00");
        $waktu_akhir    =strtotime("".$input['tanggal']." ".$input['jam_selesai'].":00"); // bisa juga waktu sekarang now()
            
            //menghitung selisih dengan hasil detik
        $diff    =$waktu_akhir - $waktu_awal;
            
            //membagi detik menjadi jam
        $jam    =floor($diff / (60 * 60));
            
            //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit    =$diff - $jam * (60 * 60);

            //menampilkan / print hasil
        // echo 'Hasilnya adalah '.number_format($menit,0,",",".").' menit<br /><br />';
        // die();
        // $detik = number_format($diff,0,",",".");

        $data["tanggal"]           = $input['tanggal'];
        $data["jam_mulai"]           = $input['jam_mulai'];
        $data["id_tasks_detail"]           = $input['tasks'];
        $data["jam_selesai"]           = $input['jam_selesai'];
        $data["durasi"]           = $menit;
        $data["catatan"]           = $input['catatan_harian'];
        $data["jumlah"]           = $input['jumlah'];
        $data["satuan"]           = $input['satuan'];
        $data["created_at"]           = date("Y-m-d H:i:s");
        $data["created_by"]           = $input['user_input'];
        
        $this->db->insert('dailyrecords',$data);
    }

    public function updatedailyRecords($input)
    {
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();
        $data = array(
            'verif' => 1,
            'feedback' => $input['txt_feedback'],
            'feedback_at' => date("Y-m-d H:i:s"),
            'feedback_by' => $data['user']['uid']
        );

        $this->db->where('id', $input['modal_id']);
        $this->db->update('dailyrecords', $data);
    }

    public function deletedailyRecords($input)
    {
        $id = $input['modal_id'];
        $this->db->delete('dailyrecords', array('id' => $id));
    }

    public function getListProfesi()
    {
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('m_tasks.id, m_tasks.tasks, master_profesi.nama_profesi, m_tasks.kasi_id, master_login.uid, m_tasks.user_id, m_tasks.isActive, master_login.pd_nickname');
        $this->db->join('m_kasi', 'm_kasi.kasi_id = m_tasks.kasi_id', 'left outer');
        $this->db->join('simrs.master_login', 'simrs.master_login.uid = m_kasi.ka_kasi', 'left outer');
        $this->db->join('simrs.master_profesi', 'simrs.master_profesi.id_profesi = m_tasks.tasks', 'left outer');
        $this->db->group_by('m_tasks.tasks');
        $this->db->where("m_tasks.isActive = '1'");
        $this->db->where('master_login.uid',  $data['user']['uid']);

        return $this->db->get('m_tasks')->result_array();
    }

    public function getListProfesiKasi()
    {
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('m_tasks.id, m_tasks.tasks, master_profesi.nama_profesi, m_tasks.kasi_id, master_login.uid, m_tasks.user_id, m_tasks.isActive, master_login.pd_nickname');
        $this->db->join('m_kasi', 'm_kasi.kasi_id = m_tasks.kasi_id', 'left outer');
        $this->db->join('simrs.master_login', 'simrs.master_login.uid = m_kasi.ka_kasi', 'left outer');
        $this->db->join('simrs.master_profesi', 'simrs.master_profesi.id_profesi = m_tasks.tasks', 'left outer');
        $this->db->group_by('m_tasks.tasks');
        $this->db->where("m_tasks.isActive = '1'");
        $this->db->where('master_login.uid',  $data['user']['uid']);
        $this->db->where("m_tasks.user_id != '690'");

        return $this->db->get('m_tasks')->result_array();
    }

    public function getListBawahan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['user']           = $this->db->get_where('simrs.master_login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('m_tasks.id,m_tasks.tasks,m_tasks.ruang,m_tasks.user_id, karu_koordinator_uid');
        $this->db->select('master_login.uid,master_login.pd_nickname');

        // $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = m_tasks.ruang', 'left outer');
        $this->db->join('simrs.master_login', 'simrs.master_login.uid = m_tasks.user_id', 'left outer');
        $where = "m_tasks.karu_koordinator_uid = '".$data['user']['uid']."'";
        $this->db->group_by('m_tasks.user_id');
        $this->db->where($where, NULL, FALSE);
        return $this->db->get('m_tasks')->result_array();
    }

}
