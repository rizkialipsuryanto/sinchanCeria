<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
    }

    public function getKontrak($user)
    {
        $this->db->order_by('t_kegiatan.kegiatan_id', 'ASC');
        return $this->db->get_where('t_kegiatan', ['user_id' => $user])->result_array();
        
    }

    public function getKontrakList($limit, $start, $user = null, $caribulan = null, $caritahun = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_kegiatan.kegiatan_id,t_kegiatan.bulan,t_kegiatan.tahun,t_kegiatan.kontrak,t_kegiatan.flag');
        if ($caribulan) {
            $where = "t_kegiatan.bulan = '". $caribulan ."' and user_id = '". $user ."'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($caritahun) {
            $where = "t_kegiatan.tahun = '". $caritahun ."' and user_id = '". $user ."'";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = "user_id = '". $user ."'";
        $this->db->where($where, NULL, FALSE);
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by('t_kegiatan.kegiatan_id', 'DESC');
        return $this->db->get('t_kegiatan')->result_array();
    }

    public function insertkontrakbulanan($input)
    {

        $data["bulan"]           = $input['bulan'];
        $data["tahun"]           = $input['tahun'];
        $data["kontrak"]           = $input['kontrak'];
        // $data["waktu"]           = $input['waktu'];
        // $data["satuan"]           = $input['satuan'];
        $data["created_at"]         = date("Y-m-d H:i:s");
        $data["user_id"]           = $input['user_input'];

        $this->db->insert('t_kegiatan',$data);
    }
}
