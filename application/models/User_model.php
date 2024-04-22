<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model  extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataKaryawan()
    {
        $this->db->order_by('pd_nickname','ASC');
        return $this->db->get('simrs.master_login')->result_array();
    }

    public function updateLastLogin($id)
    {

        $ip = getRealIpAddr();
        $logintime = time();

        // $this->db->set('online', 1);
        $this->db->set('lastip', $ip);
        $this->db->set('last_login',  $logintime);

        $this->db->where('id', $id);
        $this->db->update('master_login');
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

    public function getDailyByUser($limit, $start, $tanggal = null, $userid, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('dailyrecords.id as idcatatan,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan,dailyrecords.jumlah,dailyrecords.satuan,dailyrecords.created_by,dailyrecords.feedback');
        $this->db->select('m_tasks.id,m_tasks_detail.id,m_tasks_detail.id_tasks');
        if ($tanggal) {
            $where = "dailyrecords.tanggal = '". $tanggal ."'";
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

    public function getDailyByUsers($where)
    {
        $this->db->where($where);
        $this->db->like('tanggal', date('Y-m'));
        $query = $this->db->get('dailyrecords');
        return $query->result_array();
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

        // $waktu_awal        =strtotime("".$input['tanggal']." ".$input['jam_mulai'].":00");
        // $waktu_akhir    =strtotime("".$input['tanggal']." ".$input['jam_selesai'].":00"); // bisa juga waktu sekarang now()
            
            //menghitung selisih dengan hasil detik
        // $diff    =$waktu_akhir - $waktu_awal;
            
            //membagi detik menjadi jam
        // $jam    =floor($diff / (60 * 60));
            
            //membagi sisa detik setelah dikurangi $jam menjadi menit
        // $menit    =$diff - $jam * (60 * 60);

            //menampilkan / print hasil
        // echo 'Hasilnya adalah '.number_format($menit,0,",",".").' menit<br /><br />';
        // die();
        // $detik = number_format($diff,0,",",".");

        $data["tanggal"]           = $input['tanggal'];
        // $data["jam_mulai"]           = $input['jam_mulai'];
        $data["id_tupoksi"]           = $input['tupoksi'];
        // $data["jam_selesai"]           = $input['jam_selesai'];
        // $data["durasi"]           = $menit;
        $data["catatan"]           = $input['catatan_harian'];
        $data["jumlah"]           = $input['jumlah'];
        $data["satuan"]           = $input['satuan'];
        $data["created_at"]           = date("Y-m-d H:i:s");
        $data["uid"]           = $input['user_input'];
        
        $this->db->insert('catatan_harian',$data);
    }

    public function updatedailyRecords($input)
    {
        $id           = $input['modal_id'];

        $waktu_awal        =strtotime("".$input['tanggal']." ".$input['jam_mulai'].":00");
        $waktu_akhir    =strtotime("".$input['tanggal']." ".$input['jam_selesai'].":00"); // bisa juga waktu sekarang now()
            
            //menghitung selisih dengan hasil detik
        $diff    =$waktu_akhir - $waktu_awal;
            
            //membagi detik menjadi jam
        $jam    =floor($diff / (60 * 60));
            
            //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit    =$diff - $jam * (60 * 60);

        $data = array(
            'tanggal' => $input['tanggal'],
            // 'jam_mulai' => $input['jam_mulai'],
            'id_tasks_detail' => $input['tasks'],
            'jumlah' => $input['jumlah'],
            'satuan' => $input['satuan'],
            'catatan' => $input['catatan'],
            'created_at' => date("Y-m-d H:i:s")
            // 'created_by' => $input['user_input']
        );

        $this->db->where('id', $id);
        $this->db->update('dailyrecords', $data);
    }

    public function deletedailyRecords($input)
    {
        $id = $input['modal_id'];

        // $this->db->delete('dailyrecords', array('id' => $id));
        print_r($this->db->delete('dailyrecords', array('id' => $id)));
        die();
    }

}
