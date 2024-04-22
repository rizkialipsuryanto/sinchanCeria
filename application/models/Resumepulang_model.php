<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resumepulang_model  extends CI_Model
{

    // public function __construct()
    // {
    //     parent::__construct();
    // }



    public function getByIDX($idx)
    {

        return $this->db->get_where('t_resumepulang', ['IDADMISSION' => $idx])->row_array();
    }

    public function update($data)
    {
        $this->db->set('TGLKELUAR', date('Y-m-d', strtotime(str_replace('/', '-', $data["dtp_tanggal"]))));
        $this->db->set('CARAPULANG', $data["cb_carapulang"]);
        $this->db->set('NOMR', $data["tx_nomr"]);
        $this->db->where('IDADMISSION', $data["tx_idx"]);
        $this->db->update('t_resumepulang');
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $newdata["TGLKELUAR"]        =   date('Y-m-d', strtotime(str_replace('/', '-', $data["dtp_tanggal"])));
        $newdata["CARAPULANG"]        = $data["cb_carapulang"];
        $newdata["NOMR"]        = $data["tx_nomr"];
        $newdata["IDADMISSION"]        = $data["tx_idx"];
        $this->db->insert('t_resumepulang', $newdata);
        return $this->db->affected_rows();
    }

    public function prosesResume($data)
    {
        $status  = $this->getByIDX($data["tx_idx"]);
        // return $status;
        if ($status) {
            return $this->update($data);
        } else {
            return $this->insert($data);
        }
    }
}
