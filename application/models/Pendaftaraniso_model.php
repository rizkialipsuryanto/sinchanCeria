<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaraniso_model  extends CI_Model
{
    public function savePendaftaranrajal($idx, $nomr)
    {
        $data["idxdaftar"] = $idx;
        $data["NOMR"] = $nomr;
        $data["start_daftar"] =  $this->input->post('start_daftar');
        $data["stop_daftar"] =  $this->input->post('stop_daftar');
        $this->db->insert('t_pendaftaran_iso', $data);
        return $this->db->affected_rows();
    }
}
