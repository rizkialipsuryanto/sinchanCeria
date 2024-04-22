<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarif_model  extends CI_Model
{
    public function getKodePendaftaran($jenispoly, $kdprofesi)
    {
        return $this->db->get_where('m_tarif2012', [
            'kode_unit' => $jenispoly,
            'kode_profesi' => $kdprofesi
        ])->row_array();
    }

    public function getTarifPendaftaran($kdTindakan)
    {
        return $this->db->get_where('m_tarif2012', [
            'kode_tindakan' => $kdTindakan
        ])->row_array();
    }


    public function getLastNoBILL($param = 0)
    {
        $no_bill = $this->db->get_where('m_maxnobill')->row_array();
        $temp_nobill = $no_bill['nomor'];
        $new_nobill = 0;
        if ($temp_nobill > 0) {
            $new_nobill = $temp_nobill + $param;
        } else {
            $new_nobill = 1;
        }

        return $new_nobill;
    }

    public function getTarif($kode_tindakan)
    {
        return $this->db->get_where('m_tarif2012', [
            'kode_tindakan' => $kode_tindakan
        ])->row_array();
    }

    public function listTarif($limit, $start, $poli)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->limit($limit, $start);
        $this->db->where('m_tarif2012.kode_unit', $poli);
        return $this->db->get('m_tarif2012')->result_array();
    }
}
