<?php

    function getBidang($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT bidang from m_bidang
            where bidang_id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getKasi($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT kasi from m_kasi
            where kasi_id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getProfesinya($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT nama_profesi from simrs.master_profesi
            where id_profesi ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }
?>