<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Simrs_model  extends CI_Model
{
    protected $db_simrs;
    function __construct()
    {
        parent::__construct();
        $this->db_simrs = $this->load->database('simrs', TRUE);
    }


    function pendaftaran_online($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null)
    {

        //$this->db_simrs->limit(5);
        $this->db_simrs->where('pendaftaran_online.TGLREG', $tanggal);
        $this->db_simrs->limit($limit, $start);
        $this->db_simrs->order_by('id_pendaftaran_online', 'DESC');
        if ($poli) {
            $this->db_simrs->where('pendaftaran_online.KDPOLY', $poli);
        }
        if ($carabayar) {
            $this->db_simrs->where('pendaftaran_online.KDCARABAYAR', $carabayar);
        }
        if ($keyword) {
            $this->db_simrs->where('pendaftaran_online.NOMR', $keyword);
        }

        //$this->db_simrs->where('pendaftaran_online.status_dilayani', null);
        $this->db_simrs->where('pendaftaran_online.status_dilayani IS NULL', null, false);


        $this->db_simrs->select('pendaftaran_online.NOMR');
        $this->db_simrs->select('pendaftaran_online.TGLREG,');
        $this->db_simrs->select('pendaftaran_online.KDDOKTER');
        $this->db_simrs->select('pendaftaran_online.KDCARABAYAR');
        $this->db_simrs->select('pendaftaran_online.KDPOLY');
        $this->db_simrs->select('pendaftaran_online.PASIENBARU');
        $this->db_simrs->select('pendaftaran_online.KDDOKTER');
        $this->db_simrs->select('pendaftaran_online.no_antrian');
        $this->db_simrs->select('pendaftaran_online.jam_pemeriksaan');
        $this->db_simrs->select('pendaftaran_online.status_dilayani');
        $this->db_simrs->select('pendaftaran_online.id_pendaftaran_online');


        $response =  $this->db_simrs->get('simrs.pendaftaran_online')->result_array();
        return $response;
    }

    function selesai_pendaftaran_online($keyword = null, $poli = null, $tanggal = null, $carabayar = null)
    {
        $this->db_simrs->where('pendaftaran_online.TGLREG', $tanggal);
        //$this->db_simrs->limit($limit, $start);
        $this->db_simrs->order_by('id_pendaftaran_online', 'DESC');
        if ($poli) {
            $this->db_simrs->where('pendaftaran_online.KDPOLY', $poli);
        }
        if ($carabayar) {
            $this->db_simrs->where('pendaftaran_online.KDCARABAYAR', $carabayar);
        }

        //$this->db_simrs->where('pendaftaran_online.status_dilayani', null);
        $this->db_simrs->where('pendaftaran_online.status_dilayani', 1);


        $this->db_simrs->select('pendaftaran_online.NOMR');
        $this->db_simrs->select('pendaftaran_online.TGLREG,');
        $this->db_simrs->select('pendaftaran_online.KDDOKTER');
        $this->db_simrs->select('pendaftaran_online.KDCARABAYAR');
        $this->db_simrs->select('pendaftaran_online.KDPOLY');
        $this->db_simrs->select('pendaftaran_online.KDDOKTER');
        $this->db_simrs->select('pendaftaran_online.no_antrian');
        $this->db_simrs->select('pendaftaran_online.jam_pemeriksaan');
        $this->db_simrs->select('pendaftaran_online.status_dilayani');
        $this->db_simrs->select('pendaftaran_online.id_pendaftaran_online');


        $response =  $this->db_simrs->get('simrs.pendaftaran_online')->result_array();
        return $response;
    }

    function delete_on_bill_detail_tarif($idx)
    {
        $this->db_simrs->where('idxdaftar', $idx);
        $this->db_simrs->delete('simrs.bill_detail_tarif');
        return $this->db_simrs->affected_rows();
    }

    function getPendaftaranOnlineDetailById($id)
    {
        $this->db_simrs->where('pendaftaran_online.id_pendaftaran_online', $id);
        $this->db_simrs->limit(1);
        $response =  $this->db_simrs->get('simrs.pendaftaran_online')->row_array();
        return $response;
    }

    function setTelahDilayani($id_pendaftaran_online)
    {
        $pasien  = $this->getPendaftaranOnlineDetailById($id_pendaftaran_online);
        if ($pasien) {
            $data = array('status_dilayani' => 1);
            $this->db_simrs->where('pendaftaran_online.id_pendaftaran_online', $id_pendaftaran_online);
            $this->db_simrs->update('simrs.pendaftaran_online', $data);
            return $this->db_simrs->affected_rows();
        }
    }

    function edit_temp_pendaftaran($idx, $data)
    {
        if ($idx) {
            //$this->db_simrs->set('KDCARABAYAR', $data["cb_carabayar"]);

            if ($data["rbParentCarabayar"] == 1) {
                $this->db_simrs->set('KDCARABAYAR', 1);
            } else {
                $this->db_simrs->set('KDCARABAYAR', $data["cb_carabayar"]);
            }


            $this->db_simrs->set('KDDOKTER', $data["cb_dokterjaga"]);
            $this->db_simrs->set('KDPOLY', $data["cb_poly"]);
            $this->db_simrs->set('TGLREG', date('Y-m-d', strtotime($data["dtp_tanggal_daftar"])));
            $this->db_simrs->set('NOMR', $data["nomr"]);
            $this->db_simrs->set('PASIENBARU', $data["rbflagstatusPasienDaftar"]);
            $this->db_simrs->set('KDRUJUK', $data["cb_rujukan"]);
            $this->db_simrs->where('temp_pendaftaran.IDXDAFTAR', $idx);
            $this->db_simrs->update('simrs.temp_pendaftaran');
            return $this->db_simrs->affected_rows();
        }
    }


    function edit_bill_detail_tarif($idx, $data)
    {
        if ($idx) {
            // $this->db_simrs->set('kdcarabayar', $data["cb_carabayar"]);
            $this->db_simrs->set('kddokter', $data["cb_dokterjaga"]);

            //$this->db_simrs->set('kdcarabayar', $data["cb_carabayar"]);

            if ($data["rbParentCarabayar"] == 1) {
                $this->db_simrs->set('kdcarabayar', 1);
            } else {
                $this->db_simrs->set('kdcarabayar', $data["cb_carabayar"]);
            }

            // $where = "bill_detail_tarif.idxdaftar '". $idx ."' and (bill_detail_tarif.userlevelid < '100' or bill_detail_tarif.userlevelid = '10' or bill_detail_tarif.userlevelid ='40')";
            


            $this->db_simrs->set('kdrujuk', $data["cb_rujukan"]);
            $this->db_simrs->set('id_pasienbaru', $data["rbflagstatusPasienDaftar"]);
            $this->db_simrs->set('tglreg', date('Y-m-d', strtotime($data["dtp_tanggal_daftar"])));
            $this->db_simrs->set('nomr', $data["nomr"]);
            $this->db_simrs->set('userlevelid', $data["kuclukbanget"]);
            // $this->db->where($where, NULL, FALSE);
            $this->db_simrs->where('bill_detail_tarif.idxdaftar', $idx);
            $this->db_simrs->update('simrs.bill_detail_tarif');
            return $this->db_simrs->affected_rows();
        }
    }

    public function trace_all_new_rooms($sql)
    {
        return $this->db_simrs->query($sql)->result_array();
    }

    function getNamaPoliKlinik_kucluk($id)
    {
        $result =  $this->db_simrs->get_where('userlevels', ['userlevels.userlevelid' => $id])->row_array();
        if ($result) {
            $response =  $result["userlevelname"];
        } else {
            $response =  "-";
        }
        return $response;
    }


    function getUserLevelRanap_kucluk()
    {
        $cat = array('0', '1');
        $this->db_simrs->where_not_in('userlevels.id_pelayanan', $cat);
        $response =  $this->db_simrs->get('simrs.userlevels')->result_array();
        return $response;
    }


    function getUserLevelRajal_kucluk()
    {
        $cat = array('2', '3');
        $this->db_simrs->where_not_in('userlevels.id_pelayanan', $cat);
        $response =  $this->db_simrs->get('simrs.userlevels')->result_array();
        return $response;
    }

    function getUserLevelRajal()
    {
        $cat = '1';
        $this->db_simrs->where('userlevels.is_open', $cat);
        $response =  $this->db_simrs->get('simrs.userlevels')->result_array();
        return $response;
    }


    function getNIPDetails($NIP, $strcol)
    {

        $ci =   get_instance();
        $result = $ci->db->get_where('simrs.master_login', ['master_login.username' => $NIP])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }

    function pindahRuang($data)
    {
        if ($data["idadmission"]) {

            $this->db_simrs->set('noruang', $data["koderuang"]);
            $this->db_simrs->set('userlevelid', $data["cb_kamar_kopet"]);
            $this->db_simrs->set('kelas_to', $data["kelasRawat"]);

            $this->db_simrs->where('idxdaftar', $data["idadmission"]);
            $this->db_simrs->update('bill_detail_tarif');
            return $this->db_simrs->affected_rows();
        }
    }

    function changeInpatientPayment($data)
    {
        if ($data["idadmission"]) {

            $this->db_simrs->set('kdcarabayar', $data["cb_carabayar"]);
            $this->db_simrs->where('idxdaftar', $data["idadmission"]);
            $this->db_simrs->update('bill_detail_tarif');
            return $this->db_simrs->affected_rows();
        }
    }


    function inquiry($nomr, $date = null)
    {
        $date = date('Y-m-d');
        $this->db_simrs->select_sum('total_keseluruhan', 'biaya_total');
        $result =  $this->db_simrs->get_where('simrs.bill_detail_tarif', [
            'bill_detail_tarif.nomr' => $nomr,
            'bill_detail_tarif.tglreg' => $date
        ])->row_array();

        return $result;
    }


    function STATUS_TRANSAKS_KASIR()
    {

        $this->db_simrs->select("l_status_transaksi_kasir.id_status_transaksi AS `KODE_STATUS`", FALSE);
        $this->db_simrs->select("l_status_transaksi_kasir.nama_status_transaksi AS STATUS", FALSE);
        $result =  $this->db_simrs->get_where('simrs.l_status_transaksi_kasir')->result_array();
        return $result;
    }

    function DETAIL_TINDAKAN($idxdaftar)
    {
        // $this->db_simrs->where('tarif_pelayanan is NOT NULL', NULL, FALSE);
        $result =  $this->db_simrs->get_where('bill_detail_tindakan', [
            'idxdaftar' => $idxdaftar
        ])->result_array();
        return $result;
    }


    function masterUserLevelsByID($id, $strcol)
    {

        $ci =   get_instance();
        $result = $this->db_simrs->get_where('userlevels', ['userlevels.userlevelid' => $id])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }


    function masterTindakanByID($id, $strcol)
    {

        $ci =   get_instance();
        $result = $this->db_simrs->get_where('master_tindakan', ['master_tindakan.id_tindakan' => $id])->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response = 0;
        }
        return $response;
    }

    function masterTindakan($kelas = 3, $keywordtindakan = null)
    {

        $this->db_simrs->order_by('id_jenis_tindakan', 'DESC');

        $this->db_simrs->limit(5);
        if ($keywordtindakan) {
            // $this->db_simrs->like("master_tindakan.nama_tindakan", $keywordtindakan);
            $this->db_simrs->like('master_tindakan.nama_tindakan', $keywordtindakan, 'after');
        }

        if ($kelas == 3) {
            $this->db_simrs->where('kelas', $kelas);
            return $this->db_simrs->get_where('master_tindakan')->result_array();
        } else {
            return $this->db_simrs->get_where('master_tindakan')->result_array();
        }
    }

    function getLookupJenisTindakan($id, $strcol)
    {

        $ci =   get_instance();
        $result = $this->db_simrs->get_where(
            'l_jenis_tindakan',
            [
                'l_jenis_tindakan.id_jenis_tindakan' => $id
            ]
        )->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }


    function getLookupTypeTindakan($id, $strcol)
    {

        $ci =   get_instance();
        $result = $this->db_simrs->get_where(
            'l_type_tindakan',
            [
                'l_type_tindakan.id_type_tindakan' => $id
            ]
        )->row_array();
        if ($result) {
            $response =  $result[$strcol];
        } else {
            $response =  "-";
        }
        return $response;
    }


    function addCartPemeriksaanPasien($idx = null, $kodepemeriksaan = null)
    {
        if ($idx != null || $kodepemeriksaan != null) {
            $data["idxdaftar"] = $idx;
            $data["id_tindakan"] = $kodepemeriksaan;

            $detailPendaftaran = $this->getDetailPendaftaranByIDX($idx);
            $detailBilletails = $this->convertIDXtoBillDetailTarif($idx);

            $data["kdcarabayar"] = $detailPendaftaran["KDCARABAYAR"];
            $data["id_bill_detail_tarif"] = $detailBilletails["id_bill_detail_tarif"];


            $data["qty"] = 1;

            //
            $data["tarif_pelayanan"] = $this->masterTindakanByID($kodepemeriksaan, "tarif_pelayanan");
            $data["tarif_bhp"] =  $this->masterTindakanByID($kodepemeriksaan, "tarif_bhp");
            $data["tarif_jasa_sarana"] =  $this->masterTindakanByID($kodepemeriksaan, "tarif_jasa_sarana");
            $data["total"] =  $data["tarif_pelayanan"] + $data["tarif_bhp"] +  $data["tarif_jasa_sarana"];

            //
            $data["id_jenis_tindakan"] = $this->masterTindakanByID($kodepemeriksaan, "id_jenis_tindakan");
            $data["id_type_tindakan"] = $this->masterTindakanByID($kodepemeriksaan, "id_type_tindakan");
            $data["kelas"] = $this->masterTindakanByID($kodepemeriksaan, "kelas");

            //
            $data["total_pelayanan"] = $data["qty"] *  $data["tarif_pelayanan"];
            $data["total_bhp"] = $data["qty"] *  $data["tarif_bhp"];
            $data["total_jasa_sarana"] = $data["qty"] *  $data["tarif_jasa_sarana"];


            $data["userlevelid"] = $detailPendaftaran["KDPOLY"]; // INI SUKA BERUBAH.... TANDAI


            $this->db_simrs->insert('bill_detail_tindakan', $data);
        }
    }


    function  removeCartPemeriksaanPasien($idx = null, $idbaris = null)
    {
        if ($idx != null || $idbaris != null) {
            $this->db_simrs->where('id_bill_detail_tindakan', $idbaris);
            $this->db_simrs->where('idxdaftar', $idx);
            $this->db_simrs->delete('bill_detail_tindakan');
        }
    }


    function getDetailPendaftaranByIDX($idxdaftar)
    {
        if ($idxdaftar) {
            $this->db->limit(1);
            $this->db->SELECT('NOMR');
            $this->db->SELECT('TGLREG');
            $this->db->SELECT('KDDOKTER');
            $this->db->SELECT('KDPOLY');
            $this->db->SELECT('KDCARABAYAR');
            $this->db->SELECT('SHIFT');
            $this->db->SELECT('PASIENBARU');
            $this->db->SELECT('uid');
            // $this->db->where('IDXDAFTAR', $idxdaftar);
            $result  = $this->db->get_where('t_pendaftaran', ["IDXDAFTAR" => $idxdaftar])->row_array();
            return $result;
        }
    }



    function convertIDXtoBillDetailTarif($idxdaftar)
    {
        if ($idxdaftar) {
            $this->db_simrs->limit(1);
            $this->db_simrs->order_by("id_bill_detail_tarif", "ASC");
            $this->db_simrs->SELECT('id_bill_detail_tarif');
            $this->db_simrs->SELECT('userlevelid');
            $this->db_simrs->SELECT('idxdaftar');
            $this->db_simrs->where('idxdaftar', $idxdaftar);
            $result  = $this->db_simrs->get('bill_detail_tarif')->row_array();
            return $result;
        }
    }

    function getDetailBillDetailTarif($id)
    {
        if ($id) {
            $this->db_simrs->limit(1);
            // $this->db_simrs->order_by("id_bill_detail_tarif", "ASC");
            $this->db_simrs->SELECT('id_bill_detail_tarif');
            $this->db_simrs->SELECT('userlevelid');
            $this->db_simrs->SELECT('id_status_transaksi');
            $this->db_simrs->SELECT('idxdaftar');
            $this->db_simrs->where('id_bill_detail_tarif', $id);
            $result  = $this->db_simrs->get('bill_detail_tarif')->row_array();
            return $result;
        }
    }
}
