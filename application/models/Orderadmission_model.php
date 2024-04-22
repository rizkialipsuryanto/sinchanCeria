<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderadmission_model  extends CI_Model
{
    public function getListOrder($status)
    {
        //$this->db->cache_on();
        $this->db->limit(100);
        $this->db->order_by('IDXORDER', 'DESC');
        $data = $this->db->get_where('simrs2012.t_orderadmission', ['STATUS' => $status])->result_array();
        //$this->db->cache_off();
        return $data;
    }

    public function getById($idxorder)
    {
        if ($idxorder) {
            //  $this->db->cache_on();
            $this->db->limit(100);
            $this->db->order_by('IDXORDER', 'DESC');
            $data = $this->db->get_where('simrs2012.t_orderadmission', ['IDXORDER' => $idxorder])->row_array();
            /// this->db->cache_off();
            return $data;
        }
    }
}
