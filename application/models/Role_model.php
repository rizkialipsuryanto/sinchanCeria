<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model  extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function addNewRole($data)
    {
        $payload["role"] = $data["role"];
        $this->db->insert('user_role', $payload);
        return $this->db->affected_rows();
    }
}
