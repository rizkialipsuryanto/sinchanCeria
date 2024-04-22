<?php
    function getKaryawan($uid, $strcol)
    {
        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.master_login', ['master_login.uid' => $uid])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getUserLogin($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT CONCAT(a.firstname, ' ', a.lastname) as nama from user a 
            where a.id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }
?>