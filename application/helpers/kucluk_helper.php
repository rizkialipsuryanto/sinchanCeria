<?php

function getNamaRuangInTppriSimrs2($kode)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->getNamaPoliKlinik_kucluk($kode);

    return $result;
}

function detailnip($nip, $str)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->getNIPDetails($nip, $str);

    return $result;
}

function getInquiry($nomr)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->inquiry($nomr, null);

    return $result["biaya_total"];
}


function getMasterTindakanByID($id, $strcol)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->masterTindakanByID($id, $strcol);

    return $result;
}


function getMasterUserLevelsByID($id, $strcol)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->masterUserLevelsByID($id, $strcol);

    return $result;
}



function getdetailLookupJenisTindakan($id, $strcol)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->getLookupJenisTindakan($id, $strcol);

    return $result;
}
function getdetailLookupTypeTindakan($id, $strcol)
{
    $CI = get_instance();

    $CI->load->model('Simrs_model', 'simrs_kucluk');

    $result  = $CI->simrs_kucluk->getLookupTypeTindakan($id, $strcol);

    return $result;
}
