<?php


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

function getDetailUserMaster($id, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.master_login', ['master_login.uid' => $id])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getTasksDetail($tasks, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.m_tasks_detail', ['m_tasks_detail.id' => $tasks])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getProfesi($idprofesi, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.master_profesi', ['master_profesi.id_profesi' => $idprofesi])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getRole($idrole, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.user_role', ['user_role.id' => $idrole])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getRuang($idpoly, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.m_poly', ['m_poly.kode' => $idpoly])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getSatuanSinchan($id, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.l_satuan_sinchan', ['l_satuan_sinchan.id' => $id])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaHari($date)
{
    $datetime = DateTime::createFromFormat('Y-m-d', $date);
     $day = $datetime->format('l');
    switch ($day) {
     case 'Sunday':
      $hari = 'MINGGU';
      break;
     case 'Monday':
      $hari = 'SENIN';
      break;
     case 'Tuesday':
      $hari = 'SELASA';
      break;
     case 'Wednesday':
      $hari = 'RABU';
      break;
     case 'Thursday':
      $hari = 'KAMIS';
      break;
     case 'Friday':
      $hari = 'JUMAT';
      break;
     case 'Saturday':
      $hari = 'SABTU';
      break;
     default:
      $hari = 'Tidak ada';
      break;
    }
    return $hari;
}

// simpeg
function getRuangan($id, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.userlevels', ['userlevels.userlevelid' => $id])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getStatus($id,$strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.l_status_karyawan', ['l_status_karyawan.id_status_karyawan' => $id])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

// function getBidang($bidang, $strcol)
// {
//     $ci =   get_instance();
//     $result = $ci->db->get_where('simrs2012.m_bidang', ['m_bidang.bidang_id' => $bidang])->row_array();
//     if ($result) {
//         $response =  $result[$strcol];
//     } else {
//         $response =  "-";
//     }
//     return $response;
// }

// function getBulan($uid, $strcol)
// {

//   $ci =   get_instance();
//   $sql = "SELECT bulan_nama from simrs2012.l_bulan where bulan_id ='".$uid."'";

//         $result = $ci->db->query($sql)->row_array();
//         if ($result) {
//             $response =  $result[$strcol];
//         } else {
//             $response =  "-";
//         }
//         return $response;
// }