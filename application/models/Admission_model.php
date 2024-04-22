<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admission_model  extends CI_Model
{
    public function listadmission($limit, $start, $kamar = null, $keyword = null, $carabayar, $tgl)
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->db->select('t_admission.id_admission');
        $this->db->select('t_admission.nomr');
        $this->db->select('t_admission.statusbayar');
        $this->db->select('t_admission.noruang');
        $this->db->select('t_admission.nott');
        $this->db->select('t_admission.masukrs');


        $this->db->select('m_pasien.NAMA');


        $this->db->select('m_ruang.nama `NAMARUANG`');



        $this->db->select('m_carabayar.NAMA `NAMACARABAYAR`');


        if ($kamar) {
            $this->db->where("t_admission.noruang", $kamar);
        }


        if ($carabayar) {
            $this->db->where("t_admission.statusbayar", $carabayar);
        }

        if ($keyword) {
            $this->db->where("t_admission.nomr", $keyword);
        }

        $this->db->limit($limit, $start);
        $this->db->where("t_admission.keluarrs", null);
        $this->db->join('m_pasien', 't_admission.nomr = m_pasien.NOMR', 'left outer');
        $this->db->join('m_ruang', 't_admission.noruang = m_ruang.no', 'left outer');
        $this->db->join('m_carabayar', 't_admission.statusbayar = m_carabayar.KODE', 'left outer');
        return $this->db->get('t_admission')->result_array();
    }

    public function getListAdmission($limit, $start, $kamar = null, $keyword = null, $carabayar = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($kamar) {
            $this->db->where("t_admission.noruang", $kamar);
        }
        if ($keyword) {
            $this->db->where("t_admission.nomr", $keyword);
        }
        if ($carabayar) {
            $this->db->where("t_admission.statusbayar", $carabayar);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by("id_admission", "DESC");
        return $this->db->get('t_admission')->result_array();
    }

    public function listPasienMenginap()
    {
        $this->db->limit(200);
        $this->db->order_by('id_admission', 'DESC');
        return $this->db->get('t_admission')->result_array();
    }

    public function listKelasPerawatan()
    {
        $this->db->order_by('kelasperawatan_id', 'ASC');
        return $this->db->get_where('l_kelas_perawatan')->result_array();
    }

    public function simpanRawatInap($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $time = date('H:i:s');
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $data["tanggal"])));
        $input["id_admission"] = $data["idxdaftar"];
        $input["nomr"] = $data["tx_nomr"];
        $input["dokterpengirim"] = $data["dokterpengirim"];
        $input["statusbayar"] = $data["cb_carabayar"];
        $input["kirimdari"] = $data["polipengirim"];

        $input["keluargadekat"] = $data["keluargadekat"];
        $input["panggungjawab"] = $data["penaggungjawab"];

        $input["panggungjawab"] = $data["penaggungjawab"];
        $input["masukrs"] = $date . " " . $time;
        $input["tglreg"] = $date . " " . $time;

        $input["keluarrs"] = null;
        $input["icd_masuk"] = $data["kodediagnosa"];
        $input["NIP"] =     $user["firstname"] . " " . $user["lastname"];
        $input["nott_asal"] = $data["bed"];
        $input["nott"] = $data["bed"];
        $input["nott_to"] = $data["bed"];
        $input["dokter_penanggungjawab"] = $data["dokter"];
        $input["KELASPERAWATAN_ID"] = $data["kelasRawat"];
        $input["kelas_to"] = $data["kelasRawat"];
        $input["noruang"] = $data["koderuang"];
        $input["noruang_asal"] = $data["koderuang"];
        $input["kd_rujuk"] = $data["rujukan"];
        $input["st_bayar"] = 0;
        $input["deposit"] = 0;
        $input["userlevelid_to"] = $data["cb_kamar_kopet"]; //jancuk
        $this->db->insert('t_admission',  $input);

        $flag =  $this->db->affected_rows();

        if ($flag == 1) {
            //
            $this->addHistoryChangePayment($data);
        }

        return
            [
                'status' =>  $flag,
                'message' => $this->db->error()
            ];
    }

    function updateOrderAdmission($kode, $data)
    {
        if ($kode == 1) {
            $this->db->set('STATUS', '1');
            $this->db->where('IDXORDER', $data["txt_idxorder"]);
            $this->db->update('t_orderadmission');
            $this->db->affected_rows();
        }
    }

    function getAdmissionDetailbyID($id)
    {
        // $this->db->cache_on();
        $this->db->limit(1);
        $data =  $this->db->get_where('t_admission', ['id_admission' => $id])->row_array();
        // $this->db->cache_off();
        return $data;
    }


    function pindahRuang($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($data["idadmission"]) {
            $this->db->set('noruang', $data["koderuang"]);
            $this->db->set('nott', $data["bed"]);
            $this->db->set('KELASPERAWATAN_ID', $data["kelasRawat"]);
            $this->db->set('userlevelid_to', $data["cb_kamar_kopet"]);
            $this->db->set('kelas_to', $data["kelasRawat"]);
            $this->db->where('id_admission', $data["idadmission"]);
            $this->db->update('t_admission');
            $flag = $this->db->affected_rows();

            if ($flag == 1) {
                $this->addHistoryPindahRuang($data);
            }

            return $flag;
        }
    }
    function changeInpatientPayment($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($data["idadmission"]) {
            $this->db->set('statusbayar', $data["cb_carabayar"]);
            $this->db->where('id_admission', $data["idadmission"]);
            $this->db->update('t_admission');
            $flag = $this->db->affected_rows();

            if ($flag == 1) {
                $this->addHistoryChangePayment($data);
            }

            return $flag;
        }
    }

    function addHistoryPindahRuang($data)
    {

        date_default_timezone_set('Asia/Jakarta');

        $input["id_admission"] = $data["idadmission"];
        $input["noruang"] = $data["koderuang"];
        $input["nott"] = $data["bed"];
        $input["masukruang"] = date("Y-m-d H:i:s");
        $this->db->insert('t_pindah_ruang',  $input);
    }

    function addHistoryChangePayment($data)
    {

        date_default_timezone_set('Asia/Jakarta');
        $input["jenis_layanan"] = 1;
        $input["idx"] = $data["idxdaftar"];
        $input["payment_id"] = $data["cb_carabayar"];
        $input["date"] = date("Y-m-d H:i:s");
        $this->db->insert('t_history_chenge_payments',  $input);
    }
}
