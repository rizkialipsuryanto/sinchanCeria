<?php

function jenisPendaftaranPasien($kode)
{
    if ($kode == 0) {
        $response =  "PENDAFTARAN PASIEN LAMA";
    } else if ($kode == 1) {
        $response =  "PENDAFTARAN PASIEN BARU";
    } else {
        $response = "----";
    }
    return $response;
}

function getDetailUser($id, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.user', ['user.id' => $id])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

// function getNamaPoliKlinik($kdpoliklinik)
// {
//     $ci =   get_instance();
//     $result = $ci->db->get_where('m_poly', ['m_poly.kode' => $kdpoliklinik])->row_array();
//     if ($result) {
//         $response =  $result["nama"];
//     } else {
//         $response =  "-";
//     }
//     return $response;
// }

// function getDetailUser($id, $strcol)
// {
//     $ci =   get_instance();
//     $result = $ci->db->get_where('simrs2012.user', ['user.id' => $id])->row_array();
//     if ($result) {
//         $response =  $result[$strcol];
//     } else {
//         $response =  "-";
//     }
//     return $response;
// }

function getRekening($id_rekening,$strcol)
{
    $ci = get_instance();
    $result = $ci->db->get_where('simrs.master_rekening',['master_rekening.id_rekening' => $id_rekening])->row_array();

    if ($result) {
        $response = $result[$strcol];
    } else {
        $response = "-";
    }
    return $response;
}

function getSupplier($id_supplier,$strcol)
{
    $ci = get_instance();
    $result = $ci->db->get_where('simrs.master_supplier',['master_supplier.id_master_supplier' => $id_supplier])->row_array();
    if ($result) {
        $response = $result[$strcol];
    } else {
        $response = "-";
    }
    return $response;
}

function getObat($id_obat,$strcol)
{
    $ci = get_instance();
    $result = $ci->db->get_where('simrs.master_obat', ['master_obat.id_obat' => $id_obat])->row_array();
    if ($result) {
        $response = $result[$strcol];
    } else {
        $response = "-";
    }
    return $response;
}

function getJenisSupplier($id_jenis_supplier,$strcol)
{
    $ci = get_instance();
    $result = $ci->db->get_where('simrs.l_jenis_supplier', ['l_jenis_supplier.id_jenis_supplier' => $id_jenis_supplier])->row_array();
    if ($result) {
        $response = $result[$strcol];
    } else {
        $response = "-";
    }
    return $response;
}

?>