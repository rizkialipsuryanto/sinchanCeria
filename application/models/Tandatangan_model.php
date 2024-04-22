<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tandatangan_model  extends CI_Model
{
    public function update($id,$json)
    {
        $data = array(
            'signature' => $json,
            );
                    // $this->input->post('json')
        $this->db->where('id', $id);
        $this->db->update('t_sep', $data);
    }
}
