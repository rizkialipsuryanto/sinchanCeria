<!-- .php -->

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model  extends CI_Model
{
    public function loadOnlineUser($role = null)
    {
        $this->db->select('user.firstname');
        $this->db->select('user.lastname');
        $this->db->select('user.image');
        $this->db->select('user.lastlogin');
        $this->db->select('user.lastip');
        if ($role) {
            $this->db->where('user.role_id', $role);
        }
        $this->db->where('user.online', 1);
        return $this->db->get_where('user')->result_array();
    }
}
