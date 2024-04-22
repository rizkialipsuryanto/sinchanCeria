<?php

    function getSet($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT ket from l_cssd_set
            where set_id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getStokKeluara($uid, $strcol)
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

    function getStokKeluar($jenis, $instrumen, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT id, jenis_id, instrumen_id, sum(jumlah) as stok from t_cssd_distribusi
                    GROUP BY '".$jenis."', '".$instrumen."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getInstrumen($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT nama_alat from m_alat_cssd
            where alat_id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getCount($tahun, $bulan, $ruang, $instrumen, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and instrumen = '".$instrumen."' and ruang = '".$ruang."'  AND t_cssd.status_sterilisasi = '2'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountTotal($tahun, $bulan, $strcol)
    {
        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' AND t_cssd.status_sterilisasi = '2'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountBulanan($tahun, $bulan, $tanggal, $ruang, $instrumen, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and SUBSTRING(t_cssd.created_sterilisasi_at, 9, 2) = '".$tanggal."' and instrumen = '".$instrumen."' and ruang = '".$ruang."'  AND t_cssd.status_sterilisasi = '2'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountTotalBulanan($tahun, $bulan, $tanggal, $strcol)
    {
        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and SUBSTRING(t_cssd.created_sterilisasi_at, 9, 2) = '".$tanggal."' AND t_cssd.status_sterilisasi = '2'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getMesin($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT mesin from l_mesin_cssd
            where id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function getCountDekontaminasiBulanan($tahun, $bulan, $tanggal, $ruang, $instrumen, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and SUBSTRING(t_cssd.created_sterilisasi_at, 9, 2) = '".$tanggal."' and instrumen = '".$instrumen."' and ruang = '".$ruang."' AND (t_cssd.petugas_dekontaminasi != '' OR t_cssd.petugas_dekontaminasi is not null)";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountTotalDekontaminasiBulanan($tahun, $bulan, $tanggal, $strcol)
    {
        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and SUBSTRING(t_cssd.created_sterilisasi_at, 9, 2) = '".$tanggal."' AND (t_cssd.petugas_dekontaminasi != '' OR t_cssd.petugas_dekontaminasi is not null)";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountDekontaminasiTahunan($tahun, $bulan, $ruang, $instrumen, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' and instrumen = '".$instrumen."' and ruang = '".$ruang."'  AND (t_cssd.petugas_dekontaminasi != '' OR t_cssd.petugas_dekontaminasi is not null)";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getCountTotalDekontaminasiTahunan($tahun, $bulan, $strcol)
    {
        $ci =   get_instance();
        $sql = "SELECT coalesce(sum(jumlah),0) as jumlah from t_cssd
                where (t_cssd.flag = '3' or t_cssd.flag = '4') and SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) = '".$tahun."' and SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) = '".$bulan."' AND (t_cssd.petugas_dekontaminasi != '' OR t_cssd.petugas_dekontaminasi is not null)";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "0";
        }
        return $response;
    }

    function getBulan($uid, $strcol)
    {

        $ci =   get_instance();
        $sql = "SELECT bulan_nama from l_bulan
            where bulan_id ='".$uid."'";

        $result = $ci->db->query($sql)->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }
?>