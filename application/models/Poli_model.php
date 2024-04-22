<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poli_model  extends CI_Model
{


    //public $db2;

    function __construct()
    {
        parent::__construct();
        //$_dbSimrs2 = $this->load->database('simrs', TRUE);
        //load our second db and put in $db2
        //$this->db2 = $this->load->database('simrs', TRUE);
    }



    public function getListPoli($kodePoli)
    {
        $this->db->order_by('m_poly.nama', 'ASC');
        $this->db->where('isOpen', 1);
        if ($kodePoli == null) {
            return $this->db->get('m_poly')->result_array();
        } else {
            return $this->db->get_where('m_poly', ['kode' => $kodePoli])->result_array();
        }
    }

    public function getListPoliAntrian($kodePoli)
    {
        $this->db->order_by('m_poly.nama', 'ASC');
        $this->db->where('isOpen', 1);
        if ($kodePoli == null) {
            return $this->db->get('m_poly')->result_array();
        } else {
            return $this->db->get_where('m_poly', ['kode' => $kodePoli])->result_array();
        }
    }
	
	public function getListPoliSimrs($kodePoli)
    {
        $this->db->order_by('m_poly.nama', 'ASC');
        $this->db->where('isOpen', 1);
            // $this->db->where("simrs.userlevels.userlevelid = '114' or simrs.userlevels.userlevelid = '115' or simrs.userlevels.userlevelid > '0'");
            return $this->db->get('m_poly')->result_array();
    }
	
    public function getAllPoli()
    {
        $this->db->order_by('m_poly.isOpen', 'DESC');
        $this->db->order_by('m_poly.nama', 'ASC');
        return $this->db->get('m_poly')->result_array();
    }

    public function activatingPoliklinik($kode, $state)
    {

        if ($state == true) {
            $activating = 1;
        } else {
            $activating = 0;
        }

        $this->db->set('isOpen', $activating);
        $this->db->where('kode', $kode);
        $this->db->update('m_poly');
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getListRuang()
    {
        $this->db->order_by('userlevels.userlevelname', 'ASC');
        if ($kodePoli == null) {
            $this->db->where("simrs.userlevels.userlevelid = '114' or simrs.userlevels.userlevelid = '115' or simrs.userlevels.userlevelid > '0'");
            return $this->db->get('simrs.userlevels')->result_array();
        } else {
            return $this->db->get_where('simrs.userlevels', ['userlevelid' => $kodePoli, 'id_pelayanan' => '1'])->result_array();
        }
    }

    public function getListRuangFarmasi($kodePoli)
    {
        $this->db->order_by('userlevels.userlevelname', 'ASC');
        if ($kodePoli == null) {
            $this->db->where("simrs.userlevels.userlevelid = '114' or simrs.userlevels.userlevelid = '115' or simrs.userlevels.userlevelid = '116' or simrs.userlevels.userlevelid = '117'");
            return $this->db->get('simrs.userlevels')->result_array();
        } else {
            return $this->db->get_where('simrs.userlevels', ['userlevelid' => $kodePoli, 'id_pelayanan' => '1'])->result_array();
        }
    }

    public function getListPoliUser($kodePoli)
    {
        $this->db->order_by('userlevels.userlevelname', 'ASC');
        if ($kodePoli == null) {
            return $this->db->get_where('simrs.userlevels', ['id_pelayanan' => '1'])->result_array();
        } else {
            return $this->db->get_where('simrs.userlevels', ['userlevelid' => $kodePoli, 'id_pelayanan' => '1'])->result_array();
        }
    }

    public function getListRuangRanap($kodePoli)
    {
        $this->db->order_by('userlevels.userlevelname', 'ASC');
        if ($kodePoli == null) {
            return $this->db->get_where('simrs.userlevels', ['id_pelayanan' => '2'])->result_array();
        } else {
            return $this->db->get_where('simrs.userlevels', ['userlevelid' => $kodePoli, 'id_pelayanan' => '1'])->result_array();
        }
    }

    public function getListPoliByName($keyword)
    {
        if ($keyword != null) {
            $this->db->like('m_poly.nama', $keyword);
        } else {
            $keyword = null;
        }
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('m_poly')->result_array();
    }

    public function listPoli($limit, $start, $poli = null, $keyword = null, $carabayar, $tgl)
    {
        date_default_timezone_set('Asia/Jakarta');


        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.TGLREG');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('m_pasien.ALAMAT');
        $this->db->select('m_carabayar.NAMA AS `CARABAYAR` ');

        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
        }


        if ($carabayar) {
            $this->db->where("t_pendaftaran.KDCARABAYAR", $carabayar);
        }

        if ($keyword) {
            $this->db->where("t_pendaftaran.NOMR", $keyword);
            //$this->db->or_like("m_pasien.NAMA", $keyword);
        }

        $this->db->limit($limit, $start);
        $this->db->join('m_pasien', 't_pendaftaran.NOMR = m_pasien.NOMR', 'left outer');
        $this->db->join('m_dokter', 't_pendaftaran.KDDOKTER = m_dokter.KDDOKTER', 'left outer');
        $this->db->join('m_carabayar', 't_pendaftaran.KDCARABAYAR = m_carabayar.KODE', 'left outer');
        $this->db->join('m_poly', 't_pendaftaran.KDPOLY = m_poly.kode', 'left outer');
        return $this->db->get_where('t_pendaftaran', ['TGLREG' =>  $tgl])->result_array();
    }


    public function getAnamnesa($idxdaftar)
    {
        $this->db->where("IDXDAFTAR", $idxdaftar);
        return $this->db->get('y_tindakan_penanganan_pasien_dokter')->row_array();
    }

    public function getDiagnosaPoli($idxdaftar)
    {
        $this->db->where("IDXDAFTAR", $idxdaftar);
        //$this->db->order_by("IDXDAFTAR", 'DESC');
        return $this->db->get('y_diagnosa_poli')->row_array();
    }

    public function getTMNOPoli($idxdaftar)
    {
        $this->db->select('y_tindakan_diagnosa_tindakan.QTY');
        $this->db->select('y_tindakan_diagnosa_tindakan.BHP');
        $this->db->select('y_tindakan_diagnosa_tindakan.ID_TMNO');
        $this->db->select('y_tindakan_diagnosa_tindakan.TARIF_TMNO');
        $this->db->select('y_tmno_poli.TINDAKAN');


        $this->db->where("y_tindakan_diagnosa_tindakan.IDXDAFTAR", $idxdaftar);
        $this->db->join('y_tmno_poli', 'y_tindakan_diagnosa_tindakan.ID_TMNO = y_tmno_poli.ID_TMNO', 'left outer');
        return $this->db->get('y_tindakan_diagnosa_tindakan')->result_array();
    }

    public function getTMOPoli($idxdaftar)
    {
        $this->db->select('y_tindakan_tmo_poli.QTY');
        $this->db->select('y_tmo_poli.TINDAKAN');
        $this->db->select('y_tindakan_tmo_poli.ID_TMO');
        $this->db->select('y_tindakan_tmo_poli.TARIF_TMO');
        $this->db->select('y_tindakan_tmo_poli.TOTAL_TMO');
        $this->db->select('y_tindakan_tmo_poli.TOTAL_BHP');
        $this->db->select('y_tindakan_tmo_poli.JASA_SARANA');


        $this->db->where("y_tindakan_tmo_poli.IDXDAFTAR", $idxdaftar);
        $this->db->join('y_tmo_poli', 'y_tmo_poli.ID_TMO = y_tindakan_tmo_poli.ID_TMO', 'left outer');
        return $this->db->get('y_tindakan_tmo_poli')->result_array();
    }

    public function getTindakanKeperawatan($idxdaftar)
    {

        //
        $this->db->select('y_tindakan_keperawatan.IDXDAFTAR');
        $this->db->select('y_tmno_keperawatan.TINDAKAN');
        $this->db->select('y_tindakan_keperawatan.ID_TINDAKAN_KEPERAWATAN');
        $this->db->select('y_tindakan_keperawatan.TARIF');
        $this->db->select('y_tindakan_keperawatan.QTY');
        $this->db->select('y_tindakan_keperawatan.BHP');


        $this->db->where("y_tindakan_keperawatan.IDXDAFTAR", $idxdaftar);
        $this->db->join('y_tmno_keperawatan', 'y_tmno_keperawatan.ID_TMNO_KEPERAWATAN = y_tindakan_keperawatan.ID_TMNO_KEPERAWATAN', 'left outer');
        return $this->db->get('y_tindakan_keperawatan')->result_array();
    }


    public function getSuratKontrol($idxdaftar)
    {
        $DB2 = $this->load->database('simrs', TRUE);
        $DB2->limit(1);
        $DB2->select('*');
        $DB2->where("bill_detail_lain.idxdaftar", $idxdaftar);
        $query = $DB2->get('bill_detail_lain')->row_array();
        return $query;
    }

    public function simpanNewSuratKontrol()
    {
        $DB2 = $this->load->database('simrs', TRUE);

        $rb_perlukontrol   = $this->input->post('rb_perlukontrol');
        $IDXDAFTAR  = $this->input->post('IDXDAFTAR');

        $userlevelid  = $this->input->post('KDPOLY');
        $userlevelid_kontrol  = $this->input->post('KDPOLY');
        $alasan_kontrol  = $this->input->post('ta_alasan');
        $tanggal  = $this->input->post('tanggal');

        $data["id_kontrol"] = $rb_perlukontrol;
        $data["idxdaftar"] = $IDXDAFTAR;

        $data["userlevelid_kontrol"] = $userlevelid;
        $data["userlevelid"] = $userlevelid_kontrol;

        $data["alasan_kontrol"] = $alasan_kontrol;
        $data["tanggal_kontrol"] = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));

        $DB2->insert('simrs.bill_detail_lain', $data);
        $status  = $DB2->affected_rows();

        if ($status > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL SIMPAN SURAT KONTROL</div>'
            );
        }
    }
    public function simpanEditSuratKontrol()
    {

        // print_r($_POST);
        $DB2 = $this->load->database('simrs', TRUE);


        $IDXDAFTAR  = $this->input->post('IDXDAFTAR');
        $id_bill_detail_lain  = $this->input->post('id_bill_detail_lain');
        $tanggal  = $this->input->post('tanggal');
        $cb_poliklinik  = $this->input->post('cb_poliklinik');
        $ta_alasan  = $this->input->post('ta_alasan');

        $tanggal_conv = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));
        $DB2->set('tanggal_kontrol',  $tanggal_conv);
        $DB2->set('alasan_kontrol', $ta_alasan);


        $DB2->set('userlevelid', $cb_poliklinik);
        $DB2->set('userlevelid_kontrol', $cb_poliklinik);


        $DB2->where('id_bill_detail_lain', $id_bill_detail_lain);
        $DB2->where('idxdaftar', $IDXDAFTAR);
        $DB2->update('bill_detail_lain');


        $status  = $DB2->affected_rows();

        if ($status > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Berhasil Ubah Suarat Kontrol</div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL Ubah SURAT KONTROL</div>'
            );
        }
    }



    public function getRiwayatSuratKontrol($nomr)
    {

        $sql = "SELECT a.NOMR,a.IDXDAFTAR,a.TGLREG,c.NAMADOKTER,d.NAMA,b.no_kontrol FROM simrs2012.t_pendaftaran a
        LEFT OUTER JOIN simrs.bill_detail_lain b ON (a.IDXDAFTAR = b.idxdaftar)
        LEFT OUTER JOIN simrs2012.m_dokter c ON (c.KDDOKTER=a.KDDOKTER)
        LEFT OUTER JOIN simrs2012.m_carabayar d  ON (d.KODE=a.KDCARABAYAR)
        where a.NOMR = '024631'
        AND b.no_kontrol IS NOT NULL
        ORDER BY a.IDXDAFTAR DESC";
        // $querysubMenu = "   SELECT `user_sub_menu`.`title`,`user_sub_menu`.`icon`,`user_sub_menu`.`url`
        // FROM  `user_sub_menu` JOIN `user_menu`
        // ON  `user_sub_menu`.`menu_id` = `user_menu`.`id`
        // WHERE  `user_sub_menu`.`menu_id` = {$m['id']}
        // AND `user_sub_menu`.`is_active` = 1";

        $riwayatKontrol = $this->db->query($sql)->result_array();
        return  $riwayatKontrol;
    }


    public function getOrderLaboratorium($idxdaftar)
    { //

        $this->db->select('y_tmno_laboratorium.NAMA_TMNO_LABORATORIUM');
        $this->db->select('y_tindakan_laboratorium.ID_TMNO');
        $this->db->select('y_tindakan_laboratorium.TARIF_TMNO');
        $this->db->select('y_tindakan_laboratorium.BHP');
        $this->db->select('y_tindakan_laboratorium.JASA_SARANA');




        $this->db->where("y_tindakan_laboratorium.IDXDAFTAR", $idxdaftar);
        $this->db->join('y_tmno_laboratorium', 'y_tmno_laboratorium.ID_TMNO_LABORATORIUM = y_tindakan_laboratorium.ID_TMNO', 'left outer');
        return $this->db->get('y_tindakan_laboratorium')->result_array();
    }


    public function getOrderRadiologi($idxdaftar)
    { //

        $this->db->select('y_tmno_radiologi.NAMA_TMNO_RADIOLOGI');
        $this->db->select('y_tindakan_radiologi.IDXDAFTAR');
        $this->db->select('y_tindakan_radiologi.ID_TMNO');
        $this->db->select('y_tindakan_radiologi.TARIF_TMNO');
        $this->db->select('y_tindakan_radiologi.BHP');
        $this->db->select('y_tindakan_radiologi.JASA_SARANA');
        $this->db->select('y_tindakan_radiologi.ID_TINDAKAN_RADIOLOGI');


        $this->db->where("y_tindakan_radiologi.IDXDAFTAR", $idxdaftar);
        $this->db->join('y_tmno_radiologi', 'y_tmno_radiologi.ID_TMNO_RADIOLOGI = y_tindakan_radiologi.ID_TMNO', 'left outer');
        return $this->db->get('y_tindakan_radiologi')->result_array();
    }

    public function getSPRI($idxdaftar)
    {
        // $this->db->select('y_tmno_radiologi.NAMA_TMNO_RADIOLOGI');
        // $this->db->select('y_tindakan_radiologi.IDXDAFTAR');
        // $this->db->select('y_tindakan_radiologi.ID_TMNO');
        // $this->db->select('y_tindakan_radiologi.TARIF_TMNO');
        // $this->db->select('y_tindakan_radiologi.BHP');
        // $this->db->select('y_tindakan_radiologi.JASA_SARANA');

        $this->db->limit(1);
        $this->db->where("t_spri.idx", $idxdaftar);
        //$this->db->join('y_tmno_radiologi', 'y_tmno_radiologi.ID_TMNO_RADIOLOGI = y_tindakan_radiologi.ID_TMNO', 'left outer');
        return $this->db->get('t_spri')->row_array();
    }
    public function getRiwayatSPRI($nomr)
    {

        $this->db->select('t_spri.id');
        $this->db->select('t_spri.no_spri');
        $this->db->select('t_spri.idx');
        $this->db->select('t_spri.nomr');
        $this->db->select('t_spri.diagnosa');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_poly.nama');
        $this->db->where("t_spri.nomr", $nomr);
        $this->db->join('m_dokter', 'm_dokter.KDDOKTER = t_spri.dpjp', 'left outer');
        $this->db->join('m_poly', 'm_poly.kode = t_spri.kdpoly', 'left outer');
        return $this->db->get('t_spri')->result_array();
    }

    public function getRiwayatAnamnesa($nomr)
    {
        $this->db->limit(10);
        $this->db->where('t_pendaftaran.NOMR', $nomr);
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.TGLREG');
        $this->db->select('y_tindakan_penanganan_pasien_dokter.ISI');
        $this->db->select('y_tindakan_penanganan_pasien_dokter.ID_TINDAKAN_PENANGANAN_DOKTER_PASIEN');
        $this->db->select('y_tindakan_penanganan_pasien_dokter.PENUNJANG');
        $this->db->select('y_tindakan_penanganan_pasien_dokter.KETERANGAN_LAIN');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_poly.nama');
        $this->db->order_by('t_pendaftaran.IDXDAFTAR', 'DESC');
        $this->db->join('y_tindakan_penanganan_pasien_dokter', 'y_tindakan_penanganan_pasien_dokter.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->join('m_dokter', 'm_dokter.KDDOKTER = t_pendaftaran.KDDOKTER', 'left outer');
        $this->db->join('m_poly', 'm_poly.kode = t_pendaftaran.KDPOLY', 'left outer');
        return $this->db->get('t_pendaftaran')->result_array();
    }



    public function jeniskasus()
    {

        $tkp =  [
            ["kode" => "0", "jeniskasus" => "KASUS LAMA"],
            ["kode" => "1", "jeniskasus" => "KASUS BARU"],

        ];


        return $tkp;
    }
    public function getDIagnosa($idxdaftar)
    {
        $this->db->where("IDXDAFTAR", $idxdaftar);
        return $this->db->get('y_diagnosa_poli')->row_array();
    }

    public function getRiwayatDiagnosa($nomr)
    {
        $this->db->limit(10);
        $this->db->where('t_pendaftaran.NOMR', $nomr);
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.TGLREG');
        $this->db->select('y_diagnosa_poli.DIAGNOSA');
        $this->db->select('y_diagnosa_poli.DIAGNOSA_DOKTER');
        $this->db->select('y_diagnosa_poli.TANGGAL');
        $this->db->select('y_diagnosa_poli.JENIS_KASUS');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_poly.nama');
        $this->db->order_by('t_pendaftaran.IDXDAFTAR', 'DESC');
        $this->db->join('y_diagnosa_poli', 'y_diagnosa_poli.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->join('m_dokter', 'm_dokter.KDDOKTER = t_pendaftaran.KDDOKTER', 'left outer');
        $this->db->join('m_poly', 'm_poly.kode = t_pendaftaran.KDPOLY', 'left outer');
        return $this->db->get('t_pendaftaran')->result_array();
    }

    public function simpanEditDIagnosa()
    {
        $ID_DIAGNOSA_POLI  = $this->input->post('ID_DIAGNOSA_POLI');
        $KDPOLY   = $this->input->post('KDPOLY');
        $IDXDAFTAR   = $this->input->post('IDXDAFTAR');
        $DIAGNOSA_DOKTER  = $this->input->post('DIAGNOSA_DOKTER');
        $DIAGNOSA   = $this->input->post('DIAGNOSA');
        $JENIS_KASUS   = $this->input->post('rbFlagjeniskasus');

        $this->db->set('DIAGNOSA_DOKTER', $DIAGNOSA_DOKTER);
        $this->db->set('DIAGNOSA', $DIAGNOSA);
        $this->db->set('JENIS_KASUS', $JENIS_KASUS);

        $this->db->set('KDPOLY', $KDPOLY);
        $this->db->where('ID_DIAGNOSA_POLI', $ID_DIAGNOSA_POLI);
        $this->db->where('IDXDAFTAR', $IDXDAFTAR);
        $this->db->update('y_diagnosa_poli');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Berhasil Ubah Data</div>'
        );
    }

    public function  simpanEditAnamnesa()
    {
        $ISI  = $this->input->post('ISI');
        $KETERANGAN_LAIN   = $this->input->post('KETERANGAN_LAIN');
        $ID_TINDAKAN_PENANGANAN_DOKTER_PASIEN  = $this->input->post('ID_TINDAKAN_PENANGANAN_DOKTER_PASIEN');
        $KDPOLY   = $this->input->post('KDPOLY');

        $IDXDAFTAR   = $this->input->post('IDXDAFTAR');
        $this->db->set('ISI', $ISI);
        $this->db->set('KETERANGAN_LAIN', $KETERANGAN_LAIN);
        $this->db->set('KDPOLY', $KDPOLY);

        $this->db->where('ID_TINDAKAN_PENANGANAN_DOKTER_PASIEN', $ID_TINDAKAN_PENANGANAN_DOKTER_PASIEN);
        $this->db->where('IDXDAFTAR', $IDXDAFTAR);
        $this->db->update('y_tindakan_penanganan_pasien_dokter');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Berhasil Ubah Data</div>'
        );
    }

    public function simpanAnamnesa()
    {
        $KDPOLY   = $this->input->post('KDPOLY');
        $ISI  = $this->input->post('ISI');
        $KETERANGAN_LAIN   = $this->input->post('KETERANGAN_LAIN');
        $IDXDAFTAR   = $this->input->post('IDXDAFTAR');


        $data["ISI"] = $ISI;
        $data["KDPOLY"] = $KDPOLY;
        $data["KETERANGAN_LAIN"] = $KETERANGAN_LAIN;
        $data["IDXDAFTAR"] = $IDXDAFTAR;
        $this->db->insert('y_tindakan_penanganan_pasien_dokter', $data);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
        );
    }


    public function simpanTambahKeterangan()
    {


        $KDPOLY   = $this->input->post('KDPOLY');
        $IDXDAFTAR  = $this->input->post('IDXDAFTAR');
        $URL   = $this->input->post('URL');
        $cb_dpjp   = $this->input->post('cb_dpjp');
        $cb_statuspulang   = $this->input->post('cb_statuspulang');
        $cb_kamarinap   = $this->input->post('cb_kamarinap');
        $tx_tekanan_darah   = $this->input->post('tx_tekanan_darah');
        $tx_beratbadan   = $this->input->post('tx_beratbadan');
        $tx_tinggibadan   = $this->input->post('tx_tinggibadan');
        $cb_poli_konsul   = $this->input->post('cb_poli_konsul');
        $dokter_konsul   = $this->input->post('dokter_konsul');
        $rbflagOrderLab   = $this->input->post('rbflagOrderLab');
        $rbflagOrderRad   = $this->input->post('rbflagOrderRad');



        $dokterdetail = $this->getDokterDetail($cb_dpjp);


        $data["TEKANAN_DARAH"] = $tx_tekanan_darah;
        $data["BERAT_BADAN"] = $tx_beratbadan;
        $data["TINGGI_BADAN"] = $tx_tinggibadan;

        if ($cb_kamarinap) {

            $data["ID_KAMAR_PASIEN"] = $cb_kamarinap;
        }

        if ($cb_poli_konsul) {


            $data["KDPOLY_KONSUL"] = $cb_poli_konsul;
            $dokterkonsuldetail = $this->getDokterDetail($dokter_konsul);
            $data["KDDOKTER_KONSUL"] = $dokter_konsul;
            $data["TARIF_DOKTER_KONSUL"] = $dokterkonsuldetail["harga"];
        }
        $data["IDXDAFTAR"] = $IDXDAFTAR;
        $data["KDDOKTER"] = $cb_dpjp;
        $data["TARIF_DOKTER"] =  $dokterdetail["harga"];
        $data["STATUS"] = $cb_statuspulang;
        $KDPOLY   = $this->input->post('KDPOLY');
        $data["KDPOLY"] = $KDPOLY;
        $data["IDORDER_LAB"] = $rbflagOrderLab;
        $data["IDORDER_RAD"] = $rbflagOrderRad;
        $this->db->insert('y_keterangan_pasien', $data);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
        );
    }

    public function simpanEditKeterangan()
    {


        $ID_KETERANGAN_PASIEN   = $this->input->post('ID_KETERANGAN_PASIEN');
        $KDPOLY   = $this->input->post('KDPOLY');
        $IDXDAFTAR   = $this->input->post('IDXDAFTAR');
        $URL   = $this->input->post('URL');
        $cb_dpjp   = $this->input->post('cb_dpjp');

        $cb_statuspulang   = $this->input->post('cb_statuspulang');
        $cb_kamarinap   = $this->input->post('cb_kamarinap');
        $tx_tekanan_darah   = $this->input->post('tx_tekanan_darah');
        $tx_beratbadan   = $this->input->post('tx_beratbadan');
        $tx_tinggibadan  = $this->input->post('tx_tinggibadan');
        $cb_poli_konsul  = $this->input->post('cb_poli_konsul');
        $dokter_konsul  = $this->input->post('dokter_konsul');
        $rbflagOrderLab  = $this->input->post('rbflagOrderLab');
        $rbflagOrderRad  = $this->input->post('rbflagOrderRad');
        //  $rbflagOrderRad  = $this->input->post('cb_statuspulang');


        $dokterdetail = $this->getDokterDetail($cb_dpjp);


        $this->db->set('TEKANAN_DARAH', $tx_tekanan_darah);
        $this->db->set('BERAT_BADAN',  $tx_beratbadan);
        $this->db->set('TINGGI_BADAN', $tx_tinggibadan);
        $this->db->set('KDDOKTER',  $cb_dpjp);
        $this->db->set('STATUS',  $cb_statuspulang);
        $this->db->set('KDPOLY', $KDPOLY);
        $this->db->set('TARIF_DOKTER', $dokterdetail["harga"]);
        $this->db->set('KDDOKTER_KONSUL', $dokter_konsul);
        $this->db->set('KDPOLY_KONSUL', $cb_poli_konsul);

        $dokterkonsuldetail = $this->getDokterDetail($dokter_konsul);
        $this->db->set('TARIF_DOKTER_KONSUL', $dokterkonsuldetail["harga"]);
        $this->db->set('IDORDER_LAB', $rbflagOrderLab);
        $this->db->set('IDORDER_RAD',  $rbflagOrderRad);
        $this->db->set('ID_KAMAR_PASIEN',  $cb_kamarinap);



        $this->db->where('IDXDAFTAR', $IDXDAFTAR);
        $this->db->where('ID_KETERANGAN_PASIEN',  $ID_KETERANGAN_PASIEN);
        $this->db->update('y_keterangan_pasien');

        $status  = $this->db->affected_rows();
        if ($status > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL SIMPAN</div>'
            );
        }
    }

    public function simpanDIagnosa()
    {
        $KDPOLY   = $this->input->post('KDPOLY');
        $DIAGNOSA_DOKTER  = $this->input->post('DIAGNOSA_DOKTER');
        $IDXDAFTAR   = $this->input->post('IDXDAFTAR');
        $JENIS_KASUS   = $this->input->post('rbFlagjeniskasus');


        $data["DIAGNOSA_DOKTER"] = $DIAGNOSA_DOKTER;
        $data["KDPOLY"] = $KDPOLY;
        $data["IDXDAFTAR"] = $IDXDAFTAR;
        $data["JENIS_KASUS"] = $JENIS_KASUS;
        $this->db->insert('y_diagnosa_poli', $data);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
        );
    }

    public function RiwayatPemeriksaan($nomr)
    {
        $this->db->limit(5);
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.TGLREG');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('m_carabayar.NAMA `CARABAYAR`');

        $this->db->select('m_poly.nama AS `NAMAPOLIKLINIK` ');

        $this->db->select('m_dokter.NAMADOKTER');

        $this->db->select('y_tindakan_penanganan_pasien_dokter.ISI');
        $this->db->select('y_tindakan_penanganan_pasien_dokter.KETERANGAN_LAIN');

        $this->db->select('y_diagnosa_poli.DIAGNOSA_DOKTER');
        $this->db->select('y_diagnosa_poli.DIAGNOSA');


        $this->db->where("t_pendaftaran.NOMR", $nomr);
        $this->db->join('m_pasien', 'm_pasien.NOMR = t_pendaftaran.NOMR', 'left outer');
        $this->db->join('m_carabayar', 'm_carabayar.KODE = t_pendaftaran.KDCARABAYAR', 'left outer');
        $this->db->join('m_poly', 'm_poly.kode = t_pendaftaran.KDPOLY', 'left outer');
        $this->db->join('m_dokter', 'm_dokter.KDDOKTER = t_pendaftaran.KDDOKTER', 'left outer');
        $this->db->join('y_tindakan_penanganan_pasien_dokter', 'y_tindakan_penanganan_pasien_dokter.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->join('y_diagnosa_poli', 'y_diagnosa_poli.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
        //$this->db->join('y_tindakan_diagnosa_tindakan', 'y_tindakan_diagnosa_tindakan.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->order_by("t_pendaftaran.IDXDAFTAR", 'DESC');
        return $this->db->get('t_pendaftaran')->result_array();
    }

    // public function getTindakanPoliKlinik($nomr)
    // {
    //     $this->db->select('t_pendaftaran.IDXDAFTAR');
    //     $this->db->select('y_tindakan_diagnosa_tindakan.ID_TMNO');
    //     $this->db->where("t_pendaftaran.NOMR", $nomr);
    //     $this->db->join('y_tindakan_diagnosa_tindakan', 'y_tindakan_diagnosa_tindakan.IDXDAFTAR = t_pendaftaran.IDXDAFTAR', 'left outer');
    //     //return $this->db->get('t_pendaftaran')->result_array();
    //     return $this->db->get('y_tindakan_diagnosa_tindakan')->result_array();
    // }

    public function getObatPoliklinik($idxdaftar)
    {
        $this->db->select('z_detail_penjualan_rajal.IDXDAFTAR');
        $this->db->select('z_barang.NAMA_BARANG');
        $this->db->select('z_barang.SATUAN');
        $this->db->select('z_detail_penjualan_rajal.QTY');
        $this->db->select('z_detail_penjualan_rajal.TANGGAL');



        $this->db->where("z_detail_penjualan_rajal.IDXDAFTAR", $idxdaftar);
        $this->db->join('z_detail_barang', 'z_detail_barang.ID_DETAIL_BARANG = z_detail_penjualan_rajal.ID_DETAIL_BARANG', 'left outer');
        $this->db->join('z_barang', 'z_barang.ID_BARANG = z_detail_barang.ID_BARANG', 'left outer');
        return $this->db->get('z_detail_penjualan_rajal')->result_array();
    }

    public function getObatIGD($idxdaftar)
    {
        $this->db->select('z_detail_penjualan_igd.IDXDAFTAR');
        $this->db->select('z_barang.NAMA_BARANG');
        $this->db->select('z_barang.SATUAN');
        $this->db->select('z_detail_penjualan_igd.QTY');
        $this->db->select('z_detail_penjualan_igd.TANGGAL');

        $this->db->where("z_detail_penjualan_igd.IDXDAFTAR", $idxdaftar);
        $this->db->join('z_detail_barang', 'z_detail_barang.ID_DETAIL_BARANG = z_detail_penjualan_igd.ID_DETAIL_BARANG', 'left outer');
        $this->db->join('z_barang', 'z_barang.ID_BARANG = z_detail_barang.ID_BARANG', 'left outer');
        return $this->db->get('z_detail_penjualan_igd')->result_array();
    }


    public function getObatIBS($idxdaftar)
    {
        $this->db->select('z_detail_penjualan_ibs.IDXDAFTAR');
        $this->db->select('z_barang.NAMA_BARANG');
        $this->db->select('z_barang.SATUAN');
        $this->db->select('z_detail_penjualan_ibs.QTY');
        $this->db->select('z_detail_penjualan_ibs.TANGGAL');

        $this->db->where("z_detail_penjualan_ibs.IDXDAFTAR", $idxdaftar);
        $this->db->join('z_detail_barang', 'z_detail_barang.ID_DETAIL_BARANG = z_detail_penjualan_ibs.ID_DETAIL_BARANG', 'left outer');
        $this->db->join('z_barang', 'z_barang.ID_BARANG = z_detail_barang.ID_BARANG', 'left outer');
        return $this->db->get('z_detail_penjualan_ibs')->result_array();
    }

    public function getDokterJagaPoly($kdpoly)
    {
        $this->db->select('m_dokter_jaga.kddokter');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->where("m_dokter_jaga.kdpoly", $kdpoly);
        $this->db->join('m_dokter', 'm_dokter.KDDOKTER = m_dokter_jaga.kddokter', 'left outer');
        $result = $this->db->get('m_dokter_jaga')->result_array();
        return $result;
    }

    public function getNewNoSPRI()
    {

        $max_spri = $this->db->get_where('m_maxspri', ['id' => 1])->row_array();

        if ($max_spri) {
            $result =  $max_spri;
        } else {
            $result =  array(
                "id" => 0, "max" => 0, "no_spri" => ""
            );
        }

        $new_max = $result["max"] + 1;
        $new_nospri = str_pad($new_max, 6, "0", STR_PAD_LEFT);

        $this->db->set('max', $new_max);
        $this->db->set('no_spri', $new_nospri);

        $this->db->where('id', 1);
        $this->db->update('m_maxspri');


        $status  = $this->db->affected_rows();

        if ($status > 0) {
            return $new_nospri;
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL MEMBUAT NOMER</div>'
            );
            return null;
        }
    }

    public function simpanNewSPRI()
    {
        $idx   = $this->input->post('IDXDAFTAR');
        $nomr   = $this->input->post('NOMR');
        $dpjp   = $this->input->post('cb_dpjp');
        $jenisbangsal   = $this->input->post('rb_Bangsal');

        $kelasrawat   = $this->input->post('rb_Kelasperawatan');
        $kdpoly   = $this->input->post('KDPOLY');
        $kdprioritas   = $this->input->post('rb_TingkatPrioritas');
        $infoedu   = $this->input->post('rb_infoedu');
        $diagnosa  = $this->input->post('ta_diagnosa');



        $user   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data["idx"] = $idx;
        $data["no_spri"] = $this->getNewNoSPRI();
        $data["nomr"] = $nomr;
        $data["dpjp"] = $dpjp;
        $data["jenisbangsal"] = $jenisbangsal;
        $data["kelasrawat"] = $kelasrawat;
        $data["kdpoly"] = $kdpoly;
        $data["kdprioritas"] = $kdprioritas;
        $data["info_edu"] = $infoedu;
        $data["diagnosa"] = $diagnosa;
        $data["user"] = $user["firstname"];
        $this->db->insert('t_spri', $data);



        $status  = $this->db->affected_rows();

        if ($status > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL SIMPAN</div>'
            );
        }
    }

    public function simpanEditSPRI()
    {
        $idx   = $this->input->post('IDXDAFTAR');
        $nomr   = $this->input->post('NOMR');
        $dpjp   = $this->input->post('cb_dpjp');
        $no_spri   = $this->input->post('no_spri');
        $jenisbangsal   = $this->input->post('rb_Bangsal');

        $kelasrawat   = $this->input->post('rb_Kelasperawatan');
        $kdpoly   = $this->input->post('KDPOLY');
        $kdprioritas   = $this->input->post('rb_TingkatPrioritas');
        $infoedu   = $this->input->post('rb_infoedu');
        $diagnosa  = $this->input->post('ta_diagnosa');
        $id  = $this->input->post('id');


        $user   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->db->set('dpjp', $dpjp);
        $this->db->set('jenisbangsal', $jenisbangsal);
        $this->db->set('kelasrawat', $kelasrawat);
        $this->db->set('kdpoly', $kdpoly);
        $this->db->set('kdprioritas', $kdprioritas);
        $this->db->set('info_edu', $infoedu);
        $this->db->set('diagnosa', $diagnosa);
        $this->db->set('user', $user["firstname"]);


        $this->db->where('id', $id);
        $this->db->where('nomr', $nomr);
        $this->db->where('no_spri', $no_spri);
        $this->db->where('idx',  $idx);
        $this->db->update('t_spri');

        $status  = $this->db->affected_rows();
        if ($status > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Berhasil Simpan Data</div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">GAGAL SIMPAN</div>'
            );
        }
    }

    public function getListPoliKontrol($kdpoly = null)
    {
        $this->db->select('m_poly.kode');
        $this->db->select('m_poly.nama');
        if ($kdpoly) {
            $this->db->where_not_in('kode', $kdpoly);
        }
        $result = $this->db->get('m_poly')->result_array();
        return $result;
    }

    public function masukkeluarpoli($kd, $IDXDAFTAR)
    {
        if ($kd) {
            $time_dump = time();
            $time = date("H:i:s", $time_dump);
            if ($kd == 1) {
                // MASUK POLI
                $this->db->set('MASUKPOLY', $time);
            } else if ($kd == 2) {
                //KELUAR POLI
                $this->db->set('KELUARPOLY', $time);
            }

            $this->db->where('IDXDAFTAR', $IDXDAFTAR);
            $this->db->update('t_pendaftaran');

            $status  = $this->db->affected_rows();
            if ($status > 0) {
                return $time;
            }
        }
    }


    public function getListTMOPoli($kdpoli = 2, $keywordtindakan = null)
    {
        $this->db->order_by('TINDAKAN', 'ASC');
        $this->db->limit(10);
        if ($keywordtindakan) {
            $this->db->like("y_tmo_poli.TINDAKAN", $keywordtindakan);
        }

        if ($kdpoli == 2) {
            // $this->db->like('TINDAKAN', 'USG');
            return $this->db->get_where('y_tmo_poli', ['KODE_POLI' => 2])->result_array();
        } else {
            return $this->db->get_where('y_tmo_poli', ['KODE_POLI' => $kdpoli])->result_array();
        }
    }


    public function getTempTMO()
    {

        $this->db->select('tmp_cartbayar.IDXBAYAR');
        $this->db->select('tmp_cartbayar.TARIF');
        $this->db->select('tmp_cartbayar.BHP');
        //$this->db->select('tmp_cartbayar.IDTMNO');
        $this->db->select('tmp_cartbayar.QTY');
        $this->db->select('tmp_cartbayar.TOTTARIF');
        $this->db->select('tmp_cartbayar.IDTMO');
        $this->db->select('y_tmo_poli.TINDAKAN');
        $this->db->select('tmp_cartbayar.UID');
        $this->db->select('tmp_cartbayar.INSERTED_AT');
        $this->db->join('y_tmo_poli', 'tmp_cartbayar.IDTMO = y_tmo_poli.ID_TMO', 'left');
        $this->db->where('tmp_cartbayar.IDTMO is NOT NULL', NULL, FALSE);
        return $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->result_array();
    }

    public function simpanKe_y_tindakan_tmo_poli($idxdaftar)
    {

        $ip = getRealIpAddr();
        $sql = "INSERT INTO y_tindakan_tmo_poli (IDXDAFTAR, ID_TMO,QTY,TARIF_TMO,JASA_SARANA,KDPOLY,ID_TYPE_TMO)  

        SELECT '" . $idxdaftar . "',a.IDTMO,a.QTY,a.TARIF,a.BHP,
        (SELECT KODE_POLI FROM y_tmo_poli WHERE ID_TMO  =  a.IDTMO) 'KODE_POLI' ,
        (SELECT ID_TYPE_TMO FROM y_tmo_poli WHERE ID_TMO  =  a.IDTMO) 'ID_TYPE_TMO' 
        FROM simrs2012.tmp_cartbayar a WHERE a.IP = '" . getRealIpAddr() . "' ";
        $this->db->query($sql);
    }

    public function simpanKe_y_tindakan_keperawatan($idxdaftar)
    {

        $ip = getRealIpAddr();
        $sql = "INSERT INTO y_tindakan_keperawatan (IDXDAFTAR, ID_TMNO_KEPERAWATAN, QTY, TARIF,BHP,KDPOLY,ID_TYPE_TMNO)  

        SELECT '" . $idxdaftar . "',a.IDTMNOTINDKEP,a.QTY,a.TARIF,a.BHP,
        (SELECT KODE_POLI FROM y_tmno_keperawatan WHERE ID_TMNO_KEPERAWATAN  =  a.IDTMNOTINDKEP) 'KODE_POLI' ,
        (SELECT ID_TYPE_TMNO FROM y_tmno_keperawatan WHERE ID_TMNO_KEPERAWATAN  =  a.IDTMNOTINDKEP) 'ID_TYPE_TMO' 
        FROM simrs2012.tmp_cartbayar a WHERE a.IP = '" . getRealIpAddr() . "' ";
        $this->db->query($sql);
    }


    public function simpanKe_y_tindakan_laboratorium($idxdaftar)
    {

        $ip = getRealIpAddr();
        $poli = $this->input->post('poli');
        $sql = "INSERT INTO y_tindakan_laboratorium (IDXDAFTAR, ID_TMNO, TARIF_TMNO,BHP,JASA_SARANA,KDPOLY,ID_TYPE_TMNO)  

        SELECT '" . $idxdaftar . "',a.IDTMNOLAB,       
        (SELECT JASA_PELAYANAN FROM y_tmno_laboratorium WHERE ID_TMNO_LABORATORIUM  =  a.IDTMNOLAB) 'TARIF_TMNO' ,
        (SELECT BHP FROM y_tmno_laboratorium WHERE ID_TMNO_LABORATORIUM  =  a.IDTMNOLAB) 'BHP' ,
        (SELECT JASA_SARANA FROM y_tmno_laboratorium WHERE ID_TMNO_LABORATORIUM  =  a.IDTMNOLAB) 'JASA_SARANA' ,
        (SELECT '" . $poli . "') 'KDPOLY' ,
        (SELECT ID_TYPE_TMNO FROM y_tmno_laboratorium WHERE ID_TMNO_LABORATORIUM  =  a.IDTMNOLAB) 'ID_TYPE_TMNO' 
       
        FROM simrs2012.tmp_cartbayar a WHERE a.IP = '" . getRealIpAddr() . "' ";
        $this->db->query($sql);
    }

    public function simpanKe_y_tindakan_radiologi($idxdaftar)
    {
        $ip = getRealIpAddr();
        $poli = $this->input->post('poli');
        $sql = "INSERT INTO y_tindakan_radiologi (IDXDAFTAR, ID_TMNO, TARIF_TMNO,BHP,JASA_SARANA,KDPOLY)  

        SELECT '" . $idxdaftar . "',a.IDTMNORAD,       
        (SELECT TARIF FROM y_tmno_radiologi WHERE ID_TMNO_RADIOLOGI  =  a.IDTMNORAD) 'TARIF_TMNO' ,
        (SELECT BHP FROM y_tmno_radiologi WHERE ID_TMNO_RADIOLOGI  =  a.IDTMNORAD) 'BHP' ,
        (SELECT JASA_SARANA FROM y_tmno_radiologi WHERE ID_TMNO_RADIOLOGI  =  a.IDTMNORAD) 'JASA_SARANA' ,
        (SELECT '" . $poli . "') 'KDPOLY' 
        FROM simrs2012.tmp_cartbayar a WHERE a.IP = '" . getRealIpAddr() . "' ";
        $this->db->query($sql);
    }

    public function getListTindakanKeperawatan($kdpoli = 2, $keywordtindakan = null)
    {
        $this->db->order_by('y_tmno_keperawatan.TINDAKAN', 'ASC');
        $this->db->limit(10);
        if ($keywordtindakan) {
            $this->db->like("y_tmno_keperawatan.TINDAKAN", $keywordtindakan);
        }

        if ($kdpoli == 2) {
            return $this->db->get_where('y_tmno_keperawatan', ['KODE_POLI' => 2])->result_array();
        } else {
            return $this->db->get_where('y_tmno_keperawatan', ['KODE_POLI' => $kdpoli])->result_array();
        }
    }

    public function getListTindakanLaboratorium($keywordtindakan = null)
    {
        $this->db->order_by('y_tmno_laboratorium.NAMA_TMNO_LABORATORIUM', 'ASC');
        $this->db->limit(10);
        if ($keywordtindakan) {
            $this->db->like("y_tmno_laboratorium.NAMA_TMNO_LABORATORIUM", $keywordtindakan);
        }

        return $this->db->get_where('y_tmno_laboratorium')->result_array();
    }

    public function getListTindakanRadiologi($keywordtindakan = null)
    {
        $this->db->order_by('y_tmno_radiologi.NAMA_TMNO_RADIOLOGI', 'ASC');
        $this->db->limit(5);
        if ($keywordtindakan) {
            $this->db->like("y_tmno_radiologi.NAMA_TMNO_RADIOLOGI", $keywordtindakan);
        }

        return $this->db->get_where('y_tmno_radiologi')->result_array();
    }

    public function detailKeteranganPasienPoli($idxdaftar)
    {
        //y_keterangan_pasien
        $this->db->where("IDXDAFTAR", $idxdaftar);
        return $this->db->get('y_keterangan_pasien')->row_array();
    }
    public function getStatusPulang()
    {
        //y_keterangan_pasien
        //$this->db->where("IDXDAFTAR", $idxdaftar);
        return $this->db->get('m_statuskeluar')->result_array();
    }

    public function getlist_y_igd_kamar_pasien()
    {
        return $this->db->get('y_igd_kamar_pasien')->result_array();
    }

    public function getlistOrderPenunjang($str)
    {

        $this->db->select('m_poly.kode');
        $this->db->select('m_poly.nama');
        $this->db->select('m_poly.jenispoly');
        $this->db->where_in('kode', 40);
        if ($str == 'LAB') {
            $this->db->or_where_in('kode', 16);
        } else if ($str == 'RAD') {
            $this->db->or_where_in('kode', 17);
        }

        return $this->db->get('m_poly')->result_array();
    }

    public function getDokterDetail($kdDokter)
    {
        $this->db->where("KDDOKTER", $kdDokter);
        return $this->db->get('m_dokter')->row_array();
    }

    public function getPasienTerlayaniPoliklinik($tanggal, $kdpoly)
    {
        $sql = "SELECT COUNT(IDXDAFTAR) 'JUMLAH' FROM t_pendaftaran 
        WHERE TGLREG = '" . $tanggal . "' 
        AND KDPOLY = '" . $kdpoly . "'
        AND (MASUKPOLY ='00:00:00' OR isnull(MASUKPOLY)  OR KELUARPOLY ='00:00:00' OR isnull(KELUARPOLY) )";

        return   $this->db->query($sql)->row_array();
    }

    public function getJumlahPasienPendaftaranPoliklinik($tanggal, $kdpoly)
    {
        $sql = "SELECT COUNT(IDXDAFTAR) 'JUMLAH' FROM t_pendaftaran 
        WHERE TGLREG = '" . $tanggal . "' 
        AND KDPOLY = '" . $kdpoly . "'  ";

        return   $this->db->query($sql)->row_array();
    }
    public function getJumlahPasienBaruPendaftaranPoliklinik($tanggal, $kdpoly)
    {
        $sql = "SELECT COUNT(IDXDAFTAR) 'JUMLAH' FROM t_pendaftaran 
        WHERE TGLREG = '" . $tanggal . "' 
        AND KDPOLY = '" . $kdpoly . "'  AND PASIENBARU = '1' ";

        return   $this->db->query($sql)->row_array();
    }
    public function getJumlahPasienUmumPendaftaranPoliklinik($tanggal, $kdpoly)
    {
        $sql = "SELECT COUNT(IDXDAFTAR) 'JUMLAH' FROM t_pendaftaran 
        WHERE TGLREG = '" . $tanggal . "' 
        AND KDPOLY = '" . $kdpoly . "' AND KDCARABAYAR = '1' ";

        return   $this->db->query($sql)->row_array();
    }
}
