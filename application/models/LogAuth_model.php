<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LogAuth_model  extends CI_Model
{

    public function save($data)
    {
        $data = array(
            'ip' => get_client_ip(),
            'flag' => $data["flag"],
            'date_created' => time()
        );

        $this->db->insert('log_auth', $data);
        $result = $this->db->affected_rows();
        return $result;
    }
}
