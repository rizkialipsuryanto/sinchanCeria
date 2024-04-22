<?php


    function getBillDetailTarifDetail($id_bill_detail_tarif, $strcol)
    {
        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.bill_detail_tarif_detail', ['bill_detail_tarif_detail.id_bill_detail_tarif' => $id_bill_detail_tarif])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getBillDetailKetEkg($idx, $strcol)
    {
        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.bill_detail_keterangan_ekg', ['bill_detail_keterangan_ekg.idxdaftar' => $idx])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getBillDetailKetUsg($idx, $strcol)
    {
        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.bill_detail_keterangan_usg', ['bill_detail_keterangan_usg.idxdaftar' => $idx])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getLaporanOperasi($idx, $strcol)
    {
        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.bill_detail_tarif_ibs', ['id_bill_detail_tarif_ibs.idxdaftar' => $idx])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

?>