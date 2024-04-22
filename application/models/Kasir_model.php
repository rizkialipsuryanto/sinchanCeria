<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_model  extends CI_Model
{
    public function getStatusPembayaranKasir()
    {
        return $this->db->get_where('l_status_pembayaran_kasir')->result_array();
    }


    public function get_tmno($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_diagnosa_tindakan.TOTAL_TMNO', 'total_biaya_tmno_poli');
        $this->db->group_by("y_tindakan_diagnosa_tindakan.IDXDAFTAR");
        $this->db->join('y_tmno_poli', 'y_tmno_poli.ID_TMNO = y_tindakan_diagnosa_tindakan.ID_TMNO', 'left');

        $data =  $this->db->get_where('y_tindakan_diagnosa_tindakan', [
            'y_tindakan_diagnosa_tindakan.IDXDAFTAR' => $idxdaftar
        ])->row_array();

        return $data["total_biaya_tmno_poli"];
    }

    public function get_pembayaranlunas_umum($tgl)
    {
        $sql = "select  sum(tagihan) as jumlah from api_tagihan_pasien WHERE status_lunas = 1 and  from_unixtime(tgl_bayar,'%Y-%m-%d') = '" . $tgl . "' ";
        return $this->db->query($sql)->row_array();
    }

    public function get_pembayaranlunas_umumByPetugas($tgl)
    {
        $sql = "select  CONCAT(b.firstname,' ',b.lastname) as 'petugas',sum(a.tagihan) as jumlah from api_tagihan_pasien a LEFT OUTER JOIN user b on (a.uid=b.id) WHERE a.status_lunas = 1 and  from_unixtime(a.tgl_bayar,'%Y-%m-%d') =  '" . $tgl . "' GROUP BY a.uid";
        return $this->db->query($sql)->result_array();
    }

    public function get_obat_igd($idxdaftar)
    {
        $this->db->select_sum('TOTAL', 'total_obat_igd');

        $data =  $this->db->get_where('z_detail_penjualan_igd', [
            'z_detail_penjualan_igd.IDXDAFTAR' => $idxdaftar
        ])->row_array();

        return $data["total_obat_igd"];
    }

    public function hapusmarkingPayment()
    {

        $tagihan = $this->input->post('tagihan');
        $idxdaftar = $this->input->post('idxdaftar');
        $nomr = $this->input->post('nomr');
        $jenislayanan = $this->input->post('jenislayanan');
        $flag = $this->input->post('flag');


        $this->db->where('idxdaftar', $idxdaftar);
        $this->db->where('tipe', $jenislayanan);
        $this->db->where('flag', $flag);
        $this->db->delete('api_tagihan_pasien');
    }


    function getJumlahPembayaranRealPasien($idaxdaftar, $flagLunas)
    {
        return $this->db->get_where('t_bayarrajal', [
            'IDXDAFTAR' => $idaxdaftar,
            'LUNAS' => $flagLunas
        ])->result_array();
    }

    function getJumlahBillRealPasien($idaxdaftar)
    {
        return $this->db->get_where('t_billrajal', [
            'IDXDAFTAR' => $idaxdaftar
        ])->result_array();
    }
}
