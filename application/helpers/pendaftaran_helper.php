<?php

function getTasks($tasks, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.m_tasks', ['m_tasks.id' => $tasks])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function isLocalSEP($noSEP)
{
    $ci =   get_instance();
    $ci->db->cache_on();
    $ci->db->limit(1);
    $ci->db->select('nomer_sep');
    $result = $ci->db->get_where('simrs2012.t_sep', ['t_sep.nomer_sep' => $noSEP])->row_array();
    if ($result) {
        $response =  " success";
    } else {
        $response =  " danger";
    }
    return $response;
}

function getTSep($idx, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.t_sep', ['t_sep.idx' => $idx, 't_sep.jenis_layanan' => '2'])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}


function getDetailSep($idx, $jenislayanan, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.t_sep', ['t_sep.idx' => $idx, 't_sep.jenis_layanan' => $jenislayanan])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}




function getTSepRanap($idx, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.t_sep', ['t_sep.idx' => $idx, 't_sep.jenis_layanan' => '1'])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}

function getDetailPasien($nomr, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.m_pasien', ['m_pasien.NOMR' => $nomr])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}


function getPoli($userlevelid, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.userlevels', ['userlevels.userlevelid' => $userlevelid])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

// function getProfesinya($idprofesi, $strcol)
// {
//     $ci =   get_instance();
//     $result = $ci->db->get_where('simrs.master_profesi', ['master_profesi.id_profesi' => $idprofesi])->row_array();
//     if ($result) {
//         $response =  $result[$strcol];
//     } else {
//         $response =  "-";
//     }
//     return $response;
// }

function getPoliMapping($kode, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs2012.m_poly', ['m_poly.kode' => $kode])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}

function getDokter($kddokter, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.m_dokter', ['m_dokter.kddokter' => $kddokter])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getDokterMappingByKddokter($kddokter, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.master_login', ['master_login.kddokter' => $kddokter])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}

function getDokterMapping($kddpjpvclaim, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.master_login', ['master_login.mapping_dokter_bpjs' => $kddpjpvclaim])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getCaraBayar($kdcarabayar, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_carabayar', ['m_carabayar.KODE' => $kdcarabayar])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getRupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function statusbatal($status)
{
    if ($status == 1) {
        $response =   '<span class="label label-danger">Batal Daftar</span>';
    } else {
        $response =  "";
    }
    return $response;
}
function statusbatalReport($status)
{
    if ($status == 1) {
        $response =   'BATAL';
    } else {
        $response =  '-';
    }
    return  $response;
}

function mintaRujukanReport($status)
{
    if ($status == 1) {
        $response =   'BATAL';
    } else {
        $response =  '-';
    }
    return  $response;
}

function datediff($d1, $d2)
{
    date_default_timezone_set('Asia/Jakarta');
    $diff     = abs(strtotime($d2) - strtotime($d1));
    $a    = array();
    $a[]     = floor($diff / (365 * 60 * 60 * 24));
    $a[] = floor(($diff - $a[0] * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $a[]     = floor(($diff - $a[0] * 365 * 60 * 60 * 24 - $a[1] * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    return $a;
}

function hitungumur($tgllahir)
{
    date_default_timezone_set('Asia/Jakarta');

    $umur = datediff($tgllahir, date("Y-m-d"));

    $result = $umur[0] . " tahun ";
    $result .= $umur[1] . " bulan ";
    $result .= $umur[2] . " hari ";
    return $result;
}


function getNamaEtnis($kdetnis)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_etnis', ['m_etnis.id' => $kdetnis])->row_array();
    if ($result) {
        $response =  $result["nama_etnis"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaBahasa($kdbahasa)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_bahasa_harian', ['m_bahasa_harian.id' => $kdbahasa])->row_array();
    if ($result) {
        $response =  $result["bahasa_harian"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getNamaPendidikan($kdpendidikan)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('l_pendidikanterakhir', ['l_pendidikanterakhir.id' => $kdpendidikan])->row_array();
    if ($result) {
        $response =  $result["pendidikan"];
    } else {
        $response =  "-";
    }
    return $response;
}


function getNamaRuangPerawatan($kode)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('m_ruang', ['m_ruang.no' => $kode])->row_array();
    if ($result) {
        $response =  $result["nama"];
    } else {
        $response =  "-";
    }
    return $response;
}

function getStatusPerkawinan($kdstatus)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('l_statusperkawin', ['l_statusperkawin.id' => $kdstatus])->row_array();
    if ($result) {
        $response =  $result["statusperkawinan"];
    } else {
        $response =  "-";
    }
    return $response;
}


function getAgama($kdagama)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('l_agama', ['l_agama.id' => $kdagama])->row_array();
    if ($result) {
        $response =  $result["agama"];
    } else {
        $response =  "-";
    }
    return $response;
}

function pasienBaru($status)
{
    $status = null;
    if ($status == 1) {
        $status = "B";
    } else {
        $status = "L";
    }
    return $status;
}

function genderByEklaim($gender)
{
    $gender = null;
    if ($gender == "L") {
        $gender = 1;
    } else {
        $gender = 2;
    }
    return $gender;
}

function getJumlahTotalPasien($kdPoly, $tglreg, $carabayar, $status)
{
    $ci =   get_instance();
    if (!isset($status)) {
        $pasienbaru = "";
    } else {
        $pasienbaru = " and PASIENBARU = " . $status . " ";
    }

    if (!isset($carabayar)) {
        $cara_bayar_pasien = "";
    } else {
        $cara_bayar_pasien = " AND KDCARABAYAR = " . $carabayar . " ";
    }

    $sql = "SELECT COUNT(distinct(a.NOMR)) as 'TOTAL' FROM vw_sensus_harian_rawat_jalan a  where a.TGLREG = '" . $tglreg . "'  AND a.KDPOLY = " . $kdPoly . " " . $cara_bayar_pasien . "   " . $pasienbaru . " ";

    $data = $ci->db->query($sql)->row_array();
    return  $data["TOTAL"];
}


function getSEPlocal($noSEP)
{
    $ci =   get_instance();
    // $ci->db->select("nomer_sep");
    // $ci->db->where("", $noSEP);
    // $result =   $ci->db->count_all('t_sep');
    //  $result = $ci->db->get_where('t_sep', ['t_sep.nomer_sep' => $noSEP])->row_array();

    $ci->db->where('nomer_sep', $noSEP);
    $ci->db->from('t_sep');
    $result = $ci->db->count_all_results();
    if ($result) {
        $response =  1;
    } else {
        $response =  0;
    }
    return $response;
}

function filter_array($array, $coloum, $term)
{
    $matches = array();
    foreach ($array as $a) {
        if ($a[$coloum] == $term)
            $matches[] = $a;
    }
    return $matches;
}

function getBillDetailKeterangan($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.bill_detail_keterangan', ['bill_detail_keterangan.id_bill_detail_tarif' => $id_bill_detail_tarif])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}
function getBillDetailFarmasi($idxdaftar, $strcol)
{
    $ci =   get_instance();
    $result = $ci->db->get_where('simrs.bill_detail_tarif', ['bill_detail_tarif.idxdaftar' => $idxdaftar])->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}
function getNotaRincianTindakan($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT a.id_tindakan from simrs.bill_detail_tindakan a 
        where a.id_bill_detail_tarif =$id_bill_detail_tarif and (a.id_jenis_tindakan=1 or a.id_jenis_tindakan=2 or a.id_jenis_tindakan=3 or a.id_jenis_tindakan=8 or a.id_jenis_tindakan=22 or (a.id_jenis_tindakan=23 or a.id_jenis_tindakan=24))";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getSuratKontrol($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT a.id_bill_detail_lain from simrs.bill_detail_lain a 
        LEFT JOIN
        simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        where a.id_bill_detail_tarif = $id_bill_detail_tarif ORDER BY a.id_bill_detail_lain DESC";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getListRadiologi($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT z.id_expertise_radiologi from simrs.expertise_radiologi z 
        LEFT JOIN
    simrs.bill_detail_tarif_detail a ON a.id_bill_detail_tarif_detail = z.id_bill_detail_tarif_detail
        where a.id_bill_detail_tarif = $id_bill_detail_tarif";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getListSlitLamp($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT 
    (SELECT 
            GROUP_CONCAT(keterangan
                    SEPARATOR ', ')
        FROM
            simrs.bill_detail_penyakit
        WHERE
            id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY id_bill_detail_tarif) AS diagnosa
FROM
    simrs.bill_detail_tarif a
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getListAdmissionnote($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT 
    a.no_admission
FROM
    simrs.bill_detail_transfer_pasien a
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif and a.id_status_keluar=2";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "-";
    }
    return $response;
}

function getListResep($id_bill_detail_tarif, $strcol)
{
    $ci =   get_instance();
    $sql = "SELECT 
    id_bill_detail_permintaan_obat_master as id_master
FROM
    simrs.bill_detail_permintaan_obat_master
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND (id_jenis_resep = 2 OR id_jenis_resep = 3)";

    $result = $ci->db->query($sql)->row_array();
    if ($result) {
        $response =  $result[$strcol];
    } else {
        $response =  "";
    }
    return $response;
}


function getPendaftaranRawatJalanByDateAndPoliklinik($tanggal, $Poliklinik)
{
    $CI = get_instance();

    $CI->load->model('Pendaftaran_model', 'pendaftaran');

    $result  = $CI->pendaftaran->getPendaftaranRawatJalanByDateAndPoliklinik($tanggal, $Poliklinik);

    return $result;
}

function getDetailSepByIDXandType($jenis_layanan, $idx, $strTarget)
{
    $CI = get_instance();

    $CI->load->model('Sep_model', 'sep');

    $result  = $CI->sep->getDetailSepByIDXandType($jenis_layanan, $idx);

    return $result[$strTarget];
}
