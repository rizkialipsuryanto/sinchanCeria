<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rawatjalan_model extends CI_Model
{
    public function getPatient($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tanggalcari = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif,bill_detail_tarif.nomr,bill_detail_tarif.tglreg,bill_detail_tarif.userlevelid,bill_detail_tarif.kelas,bill_detail_tarif.kdcarabayar,bill_detail_tarif.kddokter,bill_detail_tarif.total_keseluruhan');
        $this->db->select('m_pasien.NAMA');
        
        // $this->db->select('bill_detail_tarif_detail.id_bill_detail_tarif_detail');
        if ($keyword) {
            $where = "(bill_detail_tarif.nomr='" . $keyword . "' OR m_pasien.NAMA LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($poli) {
            $this->db->where("bill_detail_tarif.userlevelid", $poli);
        }
        if ($tanggalcari) {
            $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
        }
        
        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }


        $this->db->order_by('bill_detail_tarif.tglreg', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->join('m_pasien', 'bill_detail_tarif.nomr = m_pasien.NOMR', 'left outer');
        return $this->db->get('simrs.bill_detail_tarif')->result_array();
    }

    public function getIdbildetailtarifdetail($id_bill_detail_tarif_detail)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('id_bill_detail_tarif_detail,id_bill_detail_tarif');
        $this->db->where('id_bill_detail_tarif', $id_bill_detail_tarif);
        return $this->db->get('simrs.bill_detail_tarif_detail')->result_array();
    }

}
