<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function getSubMenu($limit, $start)
    {
        $query = "  SELECT      `user_sub_menu`.* , `user_menu`.`menu` 
                    FROM        `user_sub_menu` JOIN `user_menu`
                    ON          `user_sub_menu`.`menu_id` = `user_menu`.id limit   " . $start . ", " . $limit . " ";

        return $this->db->query($query)->result_array();
    }

    public function get_submenu_total()
    {
        return $this->db->count_all("user_sub_menu");
    }
}
