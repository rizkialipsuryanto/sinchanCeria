<?php


function getTagihanTMNOPoli($idxdaftar)
{

    $ci =   get_instance();
    $ci->db->select_sum('y_tindakan_diagnosa_tindakan.TOTAL_TMNO', 'total_biaya_tmno_poli');
    $ci->db->group_by("y_tindakan_diagnosa_tindakan.IDXDAFTAR");
    $ci->db->join('y_tmno_poli', 'y_tmno_poli.ID_TMNO = y_tindakan_diagnosa_tindakan.ID_TMNO', 'left');

    $biaya =   $ci->db->get_where('y_tindakan_diagnosa_tindakan', [
        'y_tindakan_diagnosa_tindakan.IDXDAFTAR' => $idxdaftar
    ])->row_array();
    return $biaya;
}


function check_pembayaran_kasir($idxdaftar, $nomr, $flag)
{
    $ci =   get_instance();
    $ci->db->where('idxdaftar', $idxdaftar);
    $ci->db->where('nomr', $nomr);
    $ci->db->where('flag', $flag);
    $result = $ci->db->get('api_tagihan_pasien');

    if ($result->num_rows() > 0) {
        return "checked = 'checked'";
    }
}

function get_jumlah_lunas_rawat_jalan($idxdaftar, $nomr)
{
    $ci =   get_instance();

    $ci->db->select('(SELECT ifnull(SUM(api_tagihan_pasien.tagihan),0)  FROM api_tagihan_pasien WHERE api_tagihan_pasien.idxdaftar=' . $idxdaftar . ' and nomr = ' . $nomr . '  and status_lunas = 1    ) AS sudahbayar', FALSE);

    $data = $ci->db->get('api_tagihan_pasien');
    $result =  $data->row_array();
    return  $result["sudahbayar"];
}


function link_set_pembayaran($idxdaftar, $nomr, $flag, $tagihan)
{
    $ci =   get_instance();
    $ci->db->where('idxdaftar', $idxdaftar);
    $ci->db->where('nomr', $nomr);
    $ci->db->where('flag', $flag);
    $ci->db->where('status_lunas', 1);
    $result = $ci->db->get('api_tagihan_pasien');

    if ($tagihan > 0) {
        if ($result->num_rows() > 0) {

            $data =  $result->row_array();
            return '<span class="label label-success">  LUNAS   </span>&nbsp;<a  data-tagihan="' . $tagihan . '" data-idxdaftar="' . $idxdaftar . '" data-nomr="' . $nomr . '" data-jenislayanan="2" data-flag="' . $flag . '" class="hapus_marking_pembayaran"> Batal</a><label class="pull-right"> ' . number_format($data["tagihan"], 2, ",", ".") . '  &nbsp;&nbsp;(' . setNamaPetugas($data["uid"]) . ' ' . date("Y-m-d H:i:s", $data["tgl_bayar"]) . ')</label> ';
        } else {
            return '<input class="flag-tagihan-kasir" class="form-check-input" type="checkbox" data-tagihan="' . $tagihan . '" data-idxdaftar="' . $idxdaftar . '" data-nomr="' . $nomr . '" data-jenislayanan="2" data-flag="' . $flag . '"> <label  data-toggle="tooltip" data-placement="top" title="Tandai Tagihan ini sebagai tagihan lunas: selesai pembayaran"> SET LUNAS</label>';
        }
    } else {
        return '<label class="text-danger"> Tidak ada Tagihan </label>';
    }
}


function setNamaPetugas($uid)
{
    $ci =   get_instance();
    $ci->db->where('id', $uid);
    $result = $ci->db->get('user')->row_array();
    return $result["firstname"];
}
