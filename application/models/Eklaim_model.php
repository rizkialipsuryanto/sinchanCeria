<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eklaim_model  extends CI_Model
{
    public function getlistSEP($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->where("t_sep.nomr", $keyword);
        }

        $this->db->select('t_sep.id,t_sep.nomer_sep, t_sep.nomr, t_sep.no_kartubpjs,t_sep.tgl_sep, t_sep.jenis_layanan, t_sep.idx ,t_sep.signature ');
        $this->db->select('m_pasien.NAMA AS `NAMAPASIEN` ');

        $this->db->join('m_pasien', 't_sep.nomr = m_pasien.NOMR', 'left');
        $this->db->order_by('t_sep.tgl_sep', 'DESC');
        $this->db->limit($limit, $start);


        return $this->db->get('t_sep')->result_array();
    }

    public function newClaim($data)
    {
        $ws_query["metadata"]["method"] = "new_claim";
        $ws_query["data"]["nomor_kartu"] = $data["nomor_kartu"]; //"0002349469833";
        $ws_query["data"]["nomor_sep"] = $data["nomor_sep"]; //"1111R0100120V003078";
        $ws_query["data"]["nomor_rm"] =  $data["nomor_rm"]; //"240935";
        $ws_query["data"]["nama_pasien"] =  $data["nama_pasien"]; //"SUHERI";
        $ws_query["data"]["tgl_lahir"] =  $data["tgl_lahir"]; //"1991-06-09";
        $ws_query["data"]["gender"] =  $data["gender"]; //"1";

        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }

    public function update_patient($data)
    {
        $ws_query["metadata"]["method"] = "update_patient";
        $ws_query["metadata"]["nomor_rm"] = $data["nomor_rm"];

        $ws_query["data"]["nomor_kartu"] =  $data["nomor_kartu"];
        $ws_query["data"]["nama_pasien"] =  $data["nama_pasien"];

        $ws_query["data"]["nomor_rm"] =  $data["nomor_rm"];
        $ws_query["data"]["tgl_lahir"] =  $data["tgl_lahir"];
        $ws_query["data"]["gender"] =  $data["gender"];

        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }



    public function setClaim($data)
    {
        $ws_query["metadata"]["method"] = "set_claim_data";
        $ws_query["metadata"]["nomor_sep"] = $data["nomor_sep"];

        $ws_query["data"]["nomor_sep"] = $data["nomor_sep"];
        $ws_query["data"]["nomor_kartu"] = $data["nomor_kartu"];
        $ws_query["data"]["tgl_masuk"] = $data["tgl_masuk"];
        $ws_query["data"]["tgl_pulang"] = $data["tgl_pulang"];
        $ws_query["data"]["jenis_rawat"] = $data["jenis_rawat"];
        $ws_query["data"]["kelas_rawat"] = $data["kelas_rawat"];
        $ws_query["data"]["adl_sub_acute"] = $data["adl_sub_acute"];
        $ws_query["data"]["adl_chronic"] = $data["adl_chronic"];
        $ws_query["data"]["icu_indikator"] = $data["icu_indikator"];
        $ws_query["data"]["icu_los"] = $data["icu_los"];

        $ws_query["data"]["ventilator_hour"] = $data["ventilator_hour"];
        $ws_query["data"]["upgrade_class_ind"] = $data["upgrade_class_ind"];
        $ws_query["data"]["upgrade_class_class"] = $data["upgrade_class_class"];
        $ws_query["data"]["upgrade_class_los"] = $data["upgrade_class_los"];
        $ws_query["data"]["add_payment_pct"] = $data["add_payment_pct"];
        $ws_query["data"]["birth_weight"] = $data["birth_weight"];
        $ws_query["data"]["discharge_status"] = $data["discharge_status"];
        $ws_query["data"]["diagnosa"] = $data["diagnosa"];
        $ws_query["data"]["procedure"] = $data["procedure"];

        $ws_query["data"]["tarif_rs"]["prosedur_non_bedah"] = $data["prosedur_non_bedah"];
        $ws_query["data"]["tarif_rs"]["prosedur_bedah"] = $data["prosedur_bedah"];
        $ws_query["data"]["tarif_rs"]["konsultasi"] = $data["konsultasi"];
        $ws_query["data"]["tarif_rs"]["tenaga_ahli"] = $data["tenaga_ahli"];
        $ws_query["data"]["tarif_rs"]["keperawatan"] = $data["keperawatan"];
        $ws_query["data"]["tarif_rs"]["penunjang"] = $data["penunjang"];
        $ws_query["data"]["tarif_rs"]["radiologi"] = $data["radiologi"];
        $ws_query["data"]["tarif_rs"]["laboratorium"] = $data["laboratorium"];
        $ws_query["data"]["tarif_rs"]["pelayanan_darah"] = $data["pelayanan_darah"];
        $ws_query["data"]["tarif_rs"]["rehabilitasi"] = $data["rehabilitasi"];
        $ws_query["data"]["tarif_rs"]["kamar"] = $data["kamar"];
        $ws_query["data"]["tarif_rs"]["rawat_intensif"] = $data["rawat_intensif"];
        $ws_query["data"]["tarif_rs"]["obat"] = $data["obat"];
        $ws_query["data"]["tarif_rs"]["obat_kronis"] = $data["obat_kronis"];
        $ws_query["data"]["tarif_rs"]["obat_kemoterapi"] = $data["obat_kemoterapi"];
        $ws_query["data"]["tarif_rs"]["alkes"] = $data["alkes"];
        $ws_query["data"]["tarif_rs"]["bmhp"] = $data["bmhp"];
        $ws_query["data"]["tarif_rs"]["sewa_alat"] = $data["sewa_alat"];

        $ws_query["data"]["tarif_poli_eks"] = $data["tarif_poli_eks"];
        $ws_query["data"]["nama_dokter"] = $data["nama_dokter"];
        $ws_query["data"]["kode_tarif"] = $data["kode_tarif"];
        $ws_query["data"]["payor_id"] = $data["payor_id"];
        $ws_query["data"]["payor_cd"] = $data["payor_cd"];
        $ws_query["data"]["cob_cd"] = $data["cob_cd"];
        $ws_query["data"]["coder_nik"] = $data["coder_nik"];


        $json_request = json_encode($ws_query);


        $result = wscall($json_request);
        return  $result;
    }

    public function send_claim_collective($data)
    {
        $ws_query["metadata"]["method"] = "send_claim";
        $ws_query["data"]["start_dt"] =  date('Y-m-d', strtotime(str_replace('/', '-',  $data["start_dt"])));
        $ws_query["data"]["stop_dt"] =   date('Y-m-d', strtotime(str_replace('/', '-', $data["stop_dt"])));
        $ws_query["data"]["jenis_rawat"] = $data["jenis_rawat"];
        $ws_query["data"]["date_type"] =   $data["date_type"];
        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }
    public function send_claim_individual($data)
    {
        $ws_query["metadata"]["method"] = "send_claim_individual";
        $ws_query["data"]["nomor_sep"] =   $data["nomor_sep"];
        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }

    function get_claim_data($data)
    {
        $ws_query["metadata"]["method"] = "get_claim_data";
        $ws_query["data"]["nomor_sep"] =   $data["nomor_sep"];
        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }


    function search_diagnosis($data)
    {
        $ws_query["metadata"]["method"] = "search_diagnosis";
        $ws_query["data"]["keyword"] =   $data["keyword"];
        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }


    function search_procedures($data)
    {
        $ws_query["metadata"]["method"] = "search_procedures";
        $ws_query["data"]["keyword"] =   $data["keyword"];
        $json_request = json_encode($ws_query);
        $result = wscall($json_request);
        return  $result;
    }

    public function getEklaim($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null, $batal = null)
    {

        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_pendaftaran.NOMR,t_pendaftaran.IDXDAFTAR,t_pendaftaran.TGLREG,t_pendaftaran.BATAL');
        $this->db->select('t_pendaftaran.KDDOKTER');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('t_pendaftaran.NO_SJP');
        $this->db->select('t_pendaftaran.NOKARTU');
        if ($keyword) {
            $this->db->where("t_pendaftaran.NOMR", $keyword);
        }
        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
        }
        if ($carabayar) {
            $this->db->where("t_pendaftaran.KDCARABAYAR", $carabayar);
        }
        if ($batal) {
            $this->db->where("t_pendaftaran.BATAL", $batal);
        }
        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }


        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('t_pendaftaran.TGLREG', $tanggal);
        $this->db->where('t_pendaftaran.no_sjp !=', NULL);
        $this->db->where('t_pendaftaran.no_sjp <>', '');
        $this->db->where('t_pendaftaran.no_sjp <>', '-');
        $this->db->join('simrs.bill_detail_tarif', 't_pendaftaran.IDXDAFTAR = simrs.bill_detail_tarif.idxdaftar', 'left outer');
        return $this->db->get('t_pendaftaran')->result_array();
    }

    public function getTarif($idx)
    {
        $this->db->select('SUM(v_bill_inacbg.inacbg_non_bedah) AS total_bedah,
            SUM(v_bill_inacbg.inacbg_tenaga_ahli) AS total_tenaga_ahli,
            SUM(v_bill_inacbg.inacbg_radiologi) AS total_radiologi,
            SUM(v_bill_inacbg.inacbg_fisioterapi) AS total_fisioterapi,
            SUM(v_bill_inacbg.inacbg_obat) AS total_obat,
            SUM(v_bill_inacbg.inacbg_tmo) AS total_tmo,
            SUM(v_bill_inacbg.inacbg_keperawatan) AS total_keperawatan,
            SUM(v_bill_inacbg.inacbg_laboratorium) AS total_laboratorium,
            SUM(v_bill_inacbg.inacbg_akomodasi) AS total_akomodasi,
            SUM(v_bill_inacbg.inacbg_konsultasi) AS total_konsultasi,
            SUM(v_bill_inacbg.inacbg_penunjang) AS total_penunjang,
            SUM(v_bill_inacbg.inacbg_pelayanan_darah) AS total_pelayanan_darah,
            SUM(v_bill_inacbg.inacbg_bhp) AS total_bhp,
            SUM(v_bill_inacbg.inacbg_rawat_intensive) AS total_rawat_intensive,
            SUM(v_bill_inacbg.inacbg_sewa_alat) AS total_sewa_alat,
            SUM(v_bill_inacbg.total_keseluruhan) AS grand_total_keseluruhan');
        $this->db->where('simrs.v_bill_inacbg.idxdaftar', $idx);
        return $this->db->get('simrs.v_bill_inacbg')->row_array();
    }
}
