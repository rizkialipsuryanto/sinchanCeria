<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_pendaftaran_list($limit, $start, $keyword = null)
    {
        // $this->db->cache_on();
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.TGLREG');
        $this->db->select('t_pendaftaran.KDDOKTER');
        $this->db->select('t_pendaftaran.NOJAMINAN');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('t_pendaftaran.KDRUJUK');
        $this->db->select('t_pendaftaran.KDCARABAYAR');
        $this->db->select('t_pendaftaran.NO_SJP');
        $this->db->select('t_pendaftaran.JAMREG');
        $this->db->select('t_pendaftaran.NIP');
        $this->db->select('t_pendaftaran.SHIFT');
        $this->db->select('t_pendaftaran.NOKARTU');
        $this->db->select('t_pendaftaran.BATAL');
        $this->db->select('t_pendaftaran.PASIENBARU');

        $this->db->select('m_pasien.NAMA');

        if ($keyword) {
            // $this->db->where('NOMR', $keyword);
            $where = "(t_pendaftaran.NOMR='" . $keyword . "' OR m_pasien.NAMA LIKE '%" . $keyword . "%' )";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->join('m_pasien', 't_pendaftaran.NOMR = m_pasien.NOMR', 'left outer');
        $query = $this->db->get('t_pendaftaran', $limit, $start)->result_array();
        return $query;
    }

    public function getPendaftaranrajalonline($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null, $batal = null)
    {

        // $this->db->cache_on();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_pendaftaran_android.nomr,t_pendaftaran_android.tanggal');
        $this->db->select('t_pendaftaran_android.dokter');
        $this->db->select('t_pendaftaran_android.poliklinik');
        $this->db->select('t_pendaftaran_android.pasienbaru');
        $this->db->select('t_pendaftaran_android.nama');
        $this->db->select('t_pendaftaran_android.nik');
        $this->db->select('t_pendaftaran_android.jenis_kelamin');
        $this->db->select('t_pendaftaran_android.alamat_sesuai_ktp');
        $this->db->select('t_pendaftaran_android.bookingcode');
        $this->db->select('t_pendaftaran_android.isBoarded');
        $this->db->select('t_pendaftaran_android.penjamin');
        $this->db->select('t_pendaftaran_android.nobpjs');
        $this->db->select('t_pendaftaran_android.norujukan');
        // $this->db->select('t_pendaftaran.IDXDAFTAR');
        if ($keyword) {
            $this->db->where("t_pendaftaran_android.nomr", $keyword);
        }
        if ($poli) {
            $this->db->where("t_pendaftaran_android.poliklinik", $poli);
        }


        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('t_pendaftaran_android.tanggal', $tanggal);
        $this->db->where('t_pendaftaran_android.isBoarded',  1);
        // $this->db->join('t_pendaftaran', 't_pendaftaran.NOMR = t_pendaftaran_android.nomr and t_pendaftaran.TGLREG = t_pendaftaran_android.tanggal and t_pendaftaran.KDDOKTER = t_pendaftaran_android.dokter and t_pendaftaran.KDPOLY = t_pendaftaran_android.poliklinik', 'left outer');


        return $this->db->get('t_pendaftaran_android')->result_array();
    }

    public function getPendaftaranrajalonsite($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null, $batal = null)
    {

        // $this->db->cache_on();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_pendaftaran.NOMR as nomr,t_pendaftaran.TGLREG as tanggal');
        $this->db->select('t_pendaftaran.KDDOKTER as dokter');
        $this->db->select('t_pendaftaran.KDPOLY as poliklinik');
        $this->db->select('t_pendaftaran.PASIENBARU as pasienbaru');
        $this->db->select('m_pasien.NAMA as nama');
        $this->db->select('m_pasien.NOKTP as nik');
        $this->db->select('m_pasien.JENISKELAMIN as jenis_kelamin');
        $this->db->select('m_pasien.ALAMAT as alamat_sesuai_ktp');
        $this->db->select('t_pendaftaran.bookingcode');
        $this->db->select('t_pendaftaran.KDCARABAYAR as penjamin');
        $this->db->select('t_pendaftaran.NOKARTU as nobpjs');
        $this->db->select('t_pendaftaran.NOJAMINAN as norujukan');
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.BATAL');
        if ($keyword) {
            $this->db->where("t_pendaftaran.NOMR", $keyword);
        }
        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
        }


        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('t_pendaftaran.TGLREG', $tanggal);
        $this->db->where('t_pendaftaran.BATAL',  0);
        $this->db->join('m_pasien', 'm_pasien.NOMR = t_pendaftaran.NOMR', 'left outer');
        return $this->db->get('t_pendaftaran')->result_array();
    }

    function getPendaftaranRawatJalanByDateAndPoliklinik($tanggal, $Poliklinik)
    {

        // $this->db->group_by("t_pendaftaran.KDDOKTER");
        $this->db->order_by('t_pendaftaran.KDDOKTER ASC, t_pendaftaran.IDXDAFTAR ASC');


        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.KDDOKTER');
        $this->db->select('t_pendaftaran.KDCARABAYAR');
        $this->db->select('t_pendaftaran.KDRUJUK');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('t_pendaftaran.NOMR');
        $this->db->select('t_pendaftaran.NIP');
        $this->db->select('t_pendaftaran.NO_SJP');
        $this->db->select('t_pendaftaran.SHIFT');
        $this->db->select('t_pendaftaran.JAMREG');
        $this->db->select('t_pendaftaran.NOKARTU');
        $this->db->select('t_pendaftaran.PASIENBARU');
        $this->db->where('t_pendaftaran.TGLREG', $tanggal);
        $this->db->where('t_pendaftaran.KDPOLY', $Poliklinik);


        return $this->db->get('t_pendaftaran')->result_array();
    }

    function get_pendaftaran_list_with_search($limit, $start, $keyword)
    {
        $this->db->like('NOMR', $keyword);
        $query = $this->db->get('t_pendaftaran', $limit, $start)->result_array();;
        return $query;
    }

    public function get_pendaftaran_rawat_jalan_list($limit, $start)
    {
        $tanggal = date("Y-m-d");
        $this->db->where('TGLREG', $tanggal);
        $query = $this->db->get('t_pendaftaran', $limit, $start);
        return $query;
    }

    public function get_total()
    {
        return $this->db->count_all("t_pendaftaran");
    }
    public function get_total_with_search($keyword)
    {
        //$this->db->like('NOMR', $keyword);
        //return $this->db->count_all("t_pendaftaran");

        return $this->db->like('NOMR', $keyword)->from("t_pendaftaran")->count_all_results();
    }

    public function get_total_rawat_jalan()
    {
        $tanggal = date("Y-m-d");
        $this->db->where('TGLREG', $tanggal);
        return $this->db->count_all_results("t_pendaftaran");
    }

    public function getLastIDXDAFTAR($param = 0)
    {

        $this->db->limit(1);
        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->select('IDXDAFTAR');
        $data = $this->db->get('t_pendaftaran')->row_array();;

        $temp_lastIdx = $data['IDXDAFTAR'];
        $new_lastIdx = 0;
        if ($temp_lastIdx > 0) {
            $new_lastIdx = $temp_lastIdx + $param;
        } else {
            $new_lastIdx = 1;
        }

        return $new_lastIdx;
    }


    public function getDetailPendaftaranRajal($idx)
    {
        $this->db->limit(1);
        return $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idx])->row_array();
    }


    public function getDetailPendaftaranPasien($tglawal, $tglakhir, $kunjungan)
    {
        if ($kunjungan == 2) {
            $query = "call simrs2012.laporan_pendaftaran_rajal('" . $tglawal . "', '" . $tglakhir . "');";
        } else {
            $query = "call simrs2012.laporan_pendaftaran_rawat_inap('" . $tglawal . "', '" . $tglakhir . "');";
        }
        return $this->db->query($query)->result_array();
        // return $query;
    }
    public function listPendaftaranMobile()
    {

        $query = "call simrs2012.sp_listPendaftaranMobile();";

        return $this->db->query($query)->result_array();
        // return $query;
    }



    public function getDetailPendaftaranISO($tglawal, $tglakhir, $kunjungan, $petugas)
    {
        if ($kunjungan == 2) {
            $query = "SELECT a.start_daftar,a.stop_daftar,a.IDXDAFTAR, b.NIP, a.NOMR, d.NAMA, b.TGLREG, c.NAMA as 'CARABAYAR', 
                            HOUR(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'JAM', MINUTE(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'MENIT', 
                            SECOND(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'DETIK', TIMEDIFF(a.stop_daftar,a.start_daftar) as 'DURASI' 
                            FROM simrs2012.t_pendaftaran_iso a 
                            left  OUTER JOIN t_pendaftaran b ON (a.idxdaftar = b.IDXDAFTAR) 
                            left  OUTER JOIN m_carabayar c ON (b.KDCARABAYAR=c.KODE) 
                            left  OUTER JOIN m_pasien d ON (a.NOMR = d.NOMR) 
                            WHERE !isnull(b.NIP) 
                            and b.NIP = '" . $petugas . "' AND  b.TGLREG between CAST('" . $tglawal . "' AS DATE) AND CAST('" . $tglakhir . "' AS DATE) ";

            //$query = "call simrs2012.sp_laporan_waktu_input_petugas_pendaftaran('" . $petugas . "', '" . $tglawal . "', '" . $tglakhir . "');";
            //return   $query;
        }
        return $this->db->query($query)->result_array();
    }
    public function getDetailPendaftaranISO2($tglawal, $tglakhir, $kunjungan, $petugas)
    {
        if ($kunjungan == 2) {
            $query = "SELECT  a.IDXDAFTAR,  b.uid,  a.NOMR,  a.start_daftar, a.stop_daftar, b.TGLREG,  b.KDCARABAYAR , HOUR(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'JAM', MINUTE(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'MENIT',  SECOND(TIMEDIFF(a.stop_daftar,a.start_daftar)) as 'DETIK', TIMEDIFF(a.stop_daftar,a.start_daftar) as 'DURASI'  FROM simrs2012.t_pendaftaran_iso a  left  OUTER JOIN t_pendaftaran b ON (a.idxdaftar = b.IDXDAFTAR)  WHERE !isnull(b.uid)  AND b.uid = '" . $petugas . "'  AND TGLREG BETWEEN  CAST('" . $tglawal . "' AS DATE) AND CAST('" . $tglakhir . "' AS DATE) ORDER BY  a.IDXDAFTAR DESC ";

            //$query = "call simrs2012.sp_laporan_waktu_input_petugas_pendaftaran('" . $petugas . "', '" . $tglawal . "', '" . $tglakhir . "');";
            // return   $query;
        }
        return $this->db->query($query)->result_array();
    }

    public function getDetailSUMAVG($tglawal, $tglakhir, $kunjungan, $petugas)
    {
        if ($kunjungan == 2) {
            $query = "SELECT  SEC_TO_TIME( SUM(time_to_sec( TIMEDIFF(a.stop_daftar,a.start_daftar)))) as timeSum,
            sec_to_time(FLOOR(AVG(TIMEDIFF(a.stop_daftar,a.start_daftar)))) as timeAvg
            FROM simrs2012.t_pendaftaran_iso a left  OUTER JOIN t_pendaftaran b ON (a.idxdaftar = b.IDXDAFTAR) left  OUTER JOIN m_carabayar c ON (b.KDCARABAYAR=c.KODE) left  OUTER JOIN m_pasien d ON (a.NOMR = d.NOMR) WHERE !isnull(b.NIP) and b.NIP = '" . $petugas . "' AND  b.TGLREG between CAST('" . $tglawal . "' AS DATE) AND CAST('" . $tglakhir . "' AS DATE) ";
        }

        return $this->db->query($query)->result_array();
    }
    public function getDetailSUMAVG2($tglawal, $tglakhir, $kunjungan, $petugas)
    {
        if ($kunjungan == 2) {
            $query = "SELECT  SEC_TO_TIME( SUM(time_to_sec( TIMEDIFF(a.stop_daftar,a.start_daftar)))) as timeSum,
            sec_to_time(FLOOR(AVG(TIMEDIFF(a.stop_daftar,a.start_daftar)))) as timeAvg
            FROM simrs2012.t_pendaftaran_iso a left  OUTER JOIN t_pendaftaran b ON (a.idxdaftar = b.IDXDAFTAR) left  OUTER JOIN m_carabayar c ON (b.KDCARABAYAR=c.KODE) left  OUTER JOIN m_pasien d ON (a.NOMR = d.NOMR) WHERE !isnull(b.NIP) and b.uid = '" . $petugas . "' AND  b.TGLREG between CAST('" . $tglawal . "' AS DATE) AND CAST('" . $tglakhir . "' AS DATE) ";
        }

        return $this->db->query($query)->row_array();
    }


    public function getPendaftaranrajalByDate($tanggal = null, $tanggalakhir = null)
    {
        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }
        if ($tanggalakhir) {
            $_tanggalakhir = $tanggalakhir;
        } else {
            $_tanggalakhir = date('Y-m-d');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->db->cache_on();
        $sql_query = $this->db->query("call simrs2012.laporan_pendaftaran_rajal('" . $_tanggal . "','" . $_tanggalakhir . "')");
        mysqli_next_result($this->db->conn_id);
        if ($sql_query->num_rows() > 0) {
            return $sql_query->result_array();
        }
        $this->db->cache_off();
    }

    public function getPendaftaranrajal($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null, $batal = null)
    {

        // $this->db->cache_on();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_pendaftaran.NOMR,t_pendaftaran.IDXDAFTAR,t_pendaftaran.TGLREG,t_pendaftaran.BATAL');
        $this->db->select('t_pendaftaran.KDDOKTER');
        $this->db->select('t_pendaftaran.KDCARABAYAR');
        $this->db->select('t_pendaftaran.KDRUJUK');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('t_pendaftaran.NOJAMINAN');
        $this->db->select('t_pendaftaran.NIP');
        $this->db->select('t_pendaftaran.NO_SJP');
        $this->db->select('t_pendaftaran.SHIFT');
        $this->db->select('t_pendaftaran.JAMREG');
        $this->db->select('t_pendaftaran.NOKARTU');
        $this->db->select('t_pendaftaran.PASIENBARU');
        $this->db->select('t_sep.nomer_sep');
        // $this->db->select('m_pasien.NAMA,m_pasien.ALAMAT');
        // $this->db->select('m_dokter.NAMADOKTER');
        // $this->db->select('m_carabayar.NAMA AS `CARABAYAR` ');
        // $this->db->select('m_poly.nama AS `NAMAPOLY` ');
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
        // if ($tanggal) {
        //     $_tanggal = $tanggal;
        // } else {
        //     $_tanggal = date('Y-m-d');
        // }


        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('t_pendaftaran.TGLREG', $tanggal);
        // $this->db->join('m_pasien', 't_pendaftaran.NOMR = m_pasien.NOMR', 'left outer');
        // $this->db->join('m_dokter', 't_pendaftaran.KDDOKTER = m_dokter.KDDOKTER', 'left outer');
        // $this->db->join('m_carabayar', 't_pendaftaran.KDCARABAYAR = m_carabayar.KODE', 'left outer');
        $this->db->join('t_sep', 't_pendaftaran.NOMR = t_sep.nomr and t_pendaftaran.TGLREG = SUBSTRING(t_sep.tgl_sep, 1, 10)', 'left outer');
        return $this->db->get('t_pendaftaran')->result_array();
    }

    public function CountAllPendaftaranrajal()
    {
        return $this->db->get('t_pendaftaran')->num_rows();
    }

    public function listKasir($limit, $start, $keyword = null, $poli = null, $tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->db->select('t_pendaftaran.KDPOLY,t_pendaftaran.KDCARABAYAR,t_pendaftaran.NOMR,t_pendaftaran.IDXDAFTAR,t_pendaftaran.TGLREG,t_pendaftaran.STATUS_PEMBAYARAN,t_pendaftaran.BIAYA_BILLING_RAJAL,t_pendaftaran.BIAYA_BILLING_IGD');
        $this->db->select('t_pendaftaran.BIAYA_PENDAFTARAN,t_pendaftaran.BIAYA_TARIF_DOKTER,t_pendaftaran.TARIF_JASA_SARANA,t_pendaftaran.TARIF_PENUNJANG_NON_MEDIS,t_pendaftaran.TARIF_ASUHAN_KEPERAWATAN');
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.BIAYA_TINDAKAN_LABORAT');
        $this->db->select('t_pendaftaran.MASUKPOLY');
        $this->db->select('t_pendaftaran.KELUARPOLY');
        $this->db->select('t_pendaftaran.TOTAL_BIAYA_OBAT_RAJAL');
        $this->db->select('t_pendaftaran.BIAYA_TINDAKAN_RADIOLOGI');
        $this->db->select('t_pendaftaran.SHIFT');
        $this->db->select('t_pendaftaran.PASIENBARU');
        $this->db->select('m_pasien.NAMA,m_pasien.ALAMAT');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_carabayar.NAMA AS `CARABAYAR` ');
        $this->db->select('m_poly.nama AS `NAMAPOLY` ');
        $this->db->select('m_rujukan.NAMA AS `NAMA_RUJUKAN`');

        $this->db->select('l_status_pembayaran_kasir.STATUS AS `STATUS_PEMBAYARAN_STATUS`');
        if ($keyword) {
            //$this->db->where("t_pendaftaran.NOMR", $keyword);
            $where = "(`t_pendaftaran`.`NOMR`='" . $keyword . "' OR `m_pasien`.`NAMA` LIKE '%" . $keyword . "%' )";
            $this->db->where($where, NULL, FALSE);
        }
        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
        }
        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }
        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->limit($limit, $start);

        $this->db->where('t_pendaftaran.KDCARABAYAR', 1);
        $this->db->join('m_pasien', 't_pendaftaran.NOMR = m_pasien.NOMR', 'left outer');
        $this->db->join('m_dokter', 't_pendaftaran.KDDOKTER = m_dokter.KDDOKTER', 'left outer');
        $this->db->join('m_carabayar', 't_pendaftaran.KDCARABAYAR = m_carabayar.KODE', 'left outer');
        $this->db->join('m_poly', 't_pendaftaran.KDPOLY = m_poly.kode', 'left outer');
        $this->db->join('m_rujukan', 't_pendaftaran.KDRUJUK = m_rujukan.KODE', 'left outer');
        $this->db->join('l_status_pembayaran_kasir', 't_pendaftaran.STATUS_PEMBAYARAN = l_status_pembayaran_kasir.KODE_STATUS', 'left outer');

        return $this->db->get_where('t_pendaftaran', ['TGLREG' =>  $_tanggal])->result_array();
    }

    public function billingpasienrawatjalan($limit, $start, $keyword = null, $poli = null, $tanggal = null)
    {
        $this->db->distinct();
        $this->db->limit($limit, $start);

        $this->db->select('m_pasien.NOMR,   m_pasien.NAMA,   m_pasien.ALAMAT');
        $this->db->select('m_poly.NAMA AS `NAMAPOLY`');
        $this->db->select('m_carabayar.NAMA AS `NAMACARABAYAR`');
        $this->db->select('t_billrajal.IDXDAFTAR');
        $this->db->where('t_billrajal.CARABAYAR', 1);


        if ($poli) {
            $this->db->where("t_billrajal.UNIT", $poli);
        }

        $this->db->order_by('t_bayarrajal.IDXDAFTAR', 'DESC');

        $this->db->join('m_pasien', 't_billrajal.NOMR = m_pasien.NOMR', 'left');
        $this->db->join('m_carabayar', 'm_carabayar.KODE = t_billrajal.CARABAYAR', 'left');
        $this->db->join('t_bayarrajal ', 't_bayarrajal.IDXDAFTAR  = t_billrajal.IDXDAFTAR ', 'left');
        $this->db->join('m_poly', 't_billrajal.KDPOLY = m_poly.kode', 'left outer');

        return $this->db->get_where('t_billrajal', ['t_billrajal.TANGGAL' =>  $tanggal])->result_array();
    }

    public function listKasirByID($idx)
    {
        $this->db->select('t_pendaftaran.KDPOLY,t_pendaftaran.KDCARABAYAR,t_pendaftaran.NOMR,t_pendaftaran.IDXDAFTAR,t_pendaftaran.TGLREG,t_pendaftaran.STATUS_PEMBAYARAN,t_pendaftaran.BIAYA_BILLING_RAJAL,t_pendaftaran.BIAYA_BILLING_IGD');
        $this->db->select('t_pendaftaran.BIAYA_PENDAFTARAN,t_pendaftaran.BIAYA_TARIF_DOKTER,t_pendaftaran.TARIF_JASA_SARANA,t_pendaftaran.TARIF_PENUNJANG_NON_MEDIS,t_pendaftaran.TARIF_ASUHAN_KEPERAWATAN');
        $this->db->select('t_pendaftaran.IDXDAFTAR');
        $this->db->select('t_pendaftaran.BIAYA_TINDAKAN_LABORAT');
        $this->db->select('t_pendaftaran.TOTAL_BIAYA_OBAT_RAJAL');
        $this->db->select('t_pendaftaran.BIAYA_TINDAKAN_RADIOLOGI');
        $this->db->select('t_pendaftaran.STATUS_PEMBAYARAN');
        $this->db->select('t_pendaftaran.MASUKPOLY');
        $this->db->select('t_pendaftaran.KELUARPOLY');


        $this->db->select('t_pendaftaran.PENANGGUNGJAWAB_NAMA,t_pendaftaran.PENANGGUNGJAWAB_PHONE,t_pendaftaran.PENANGGUNGJAWAB_ALAMAT');


        $this->db->select('m_pasien.NAMA,m_pasien.ALAMAT,m_pasien.JENISKELAMIN,m_pasien.NOKTP,m_pasien.NO_KARTU,m_pasien.NOTELP');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_carabayar.NAMA AS `CARABAYAR` ');
        $this->db->select('m_poly.nama AS `NAMAPOLY` ');
        $this->db->select('l_status_pembayaran_kasir.STATUS AS `STATUS_PEMBAYARAN_STATUS`');

        $this->db->order_by('IDXDAFTAR', 'DESC');
        $this->db->limit(1);
        $this->db->join('m_pasien', 't_pendaftaran.NOMR = m_pasien.NOMR', 'left outer');
        $this->db->join('m_dokter', 't_pendaftaran.KDDOKTER = m_dokter.KDDOKTER', 'left outer');
        $this->db->join('m_carabayar', 't_pendaftaran.KDCARABAYAR = m_carabayar.KODE', 'left outer');
        $this->db->join('m_poly', 't_pendaftaran.KDPOLY = m_poly.kode', 'left outer');
        $this->db->join('l_status_pembayaran_kasir', 't_pendaftaran.STATUS_PEMBAYARAN = l_status_pembayaran_kasir.KODE_STATUS', 'left outer');
        return $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' =>  $idx])->row_array();
    }


    public function getTagihanTMNOPoli($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_diagnosa_tindakan.TOTAL_TMNO', 'total_biaya_tmno_poli');
        $this->db->group_by("y_tindakan_diagnosa_tindakan.IDXDAFTAR");
        $this->db->join('y_tmno_poli', 'y_tmno_poli.ID_TMNO = y_tindakan_diagnosa_tindakan.ID_TMNO', 'left outer');

        $biaya =   $this->db->get_where('y_tindakan_diagnosa_tindakan', [
            'y_tindakan_diagnosa_tindakan.IDXDAFTAR' => $idxdaftar
        ])->row_array();
        return $biaya;
    }

    public function getStatusPasienBaru()
    {
        $pasienbaru =  [
            ["id" => "0", "status" => "Pasien Lama"],
            ["id" => "1", "status" => "Pasien Baru"]
        ];
        return $pasienbaru;
    }
    public function getStatusPasienBaruPendaftaranOnline()
    {
        $pasienbaru =  [
            ["id" => "0", "status" => "Pasien Lama"]
        ];
        return $pasienbaru;
    }


    public function getShift()
    {
        $shift =  [
            ["id" => "1", "shift" => "1 "],
            ["id" => "2", "shift" => "2 "],
            ["id" => "3", "shift" => "3 "]
        ];
        return $shift;
    }

    public function bataldaftar($idx)
    {
        $this->db->set('BATAL', 1);
        $this->db->where('IDXDAFTAR', $idx);
        $this->db->update('t_pendaftaran');

        $hapus_temp = $this->hapustemp_pendaftaran($idx);
        return $this->db->affected_rows() > 0;
    }


    public function hapustemp_pendaftaran($idx)
    {

        $this->db->where('IDXDAFTAR', $idx);
        $this->db->delete('temp_pendaftaran');
        return $this->db->affected_rows() > 0;
    }


    function simpanPendafataran($nomr)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $tanggalperiksa = $this->input->post('dtp_tanggal_daftar');
        $gab_noantrian      = $this->input->post('kdAntrian').''.$this->input->post('noantrian');
        $gab_kodebooking      = $this->input->post('kdAntrian').''.$this->input->post('noantrian');
        // print_r($gab_noantrian);
        // die();
        $var = $tanggalperiksa;
        $date = str_replace('-', '-', $var);
        $tanggalperiksaconvert = date('Y-m-d', strtotime($date));
        $kodebooking = date("Ymd", strtotime($tanggalperiksaconvert)).''.$gab_kodebooking;

        if ($this->input->post('rbParentCarabayar') > 1) {
            $carabayar           = $this->input->post('cb_carabayar');
        } else {
            $carabayar            = 1;
        }

        $data["NOMR"]           = $nomr;
        $data["TGLREG"]         = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dtp_tanggal_daftar'))));
        $data["KDDOKTER"]       = $this->input->post('cb_dokterjaga');
        $data["KDPOLY"]         = $this->input->post('cb_poly');
        $data["KDRUJUK"]        = $this->input->post('cb_rujukan');
        $data["KDCARABAYAR"]    = $carabayar;
        $data["no_antian"]      = $gab_noantrian;
        $data["jam_ambil_antrian"]      = date("Y-m-d H:i:s");
        $data["PASIENBARU"]     = $this->input->post('rbflagstatusPasienDaftar');
        $data["SHIFT"]          = $this->input->post('rbShift');
        $data["STATUS"]         = 0;
        $data["PASIENBARU"]     = $this->input->post('rbflagstatusPasienDaftar');
        $data["NIP"]            = $user["firstname"] . " " . $user["lastname"];
        $data["uid"]            = $user["id"];
        $data["bookingcode"]      = $kodebooking;

        //simpan perusahaan
        $data["KDPERUSAHAAN"]    = $this->input->post('cb_perusahaan');

        if ($this->input->post('cb_poly') == 9) {
            $data["MASUKPOLY"]            = date("H:i:s");
        }

        $data["KDRUJUK"]     = $this->input->post('cb_rujukan');

        if ($this->input->post('cb_rujukan') > 1) {
            $data["KETRUJUK"]            = $this->input->post('ketrujuk');
        }


        $data["PENANGGUNGJAWAB_NAMA"]           = $this->input->post('tx_namapenanggungjawab');
        $data["PENANGGUNGJAWAB_HUBUNGAN"]       = $this->input->post('cb_hubungan');
        $data["PENANGGUNGJAWAB_ALAMAT"]         = $this->input->post('tx_alamatpenanggungjawab');
        $data["PENANGGUNGJAWAB_PHONE"]          = $this->input->post('tx_notel_penanggungjawab');
        $data["JAMREG"]          = date("Y-m-d H:i:s");
        $data["BATAL"]          = 0;


        if ($this->input->post('nokabpjs')) {
            $data["NOKARTU"]          = $this->input->post('nokabpjs');
            $data["NOKARTU_BPJS"]          = $this->input->post('nokabpjs');
            $data["NO_PESERTA"]          = $this->input->post('nokabpjs');
            $data["NORUJUKAN_SEP"]          = $this->input->post('tx_no_rujukan_bpjs');
            // $data["NO_SJP"]          = $this->input->post('tx_no_rujukan_bpjs');
            if ($this->input->post('faskes2')) {
                $asalfaskes = 2;
            } else {
                $asalfaskes = 1;
            }
            $data["asalfaskes"]          =  $asalfaskes;
        }

        if($this->input->post('rbflagstatusPasienDaftar') == 1){
            $data["taskid"] = 1;
        }
        else{
            $data["taskid"] = 3;
        }
        $data["jenis_kunjungan"]      = $this->input->post('cb_jeniskunjungan');


        $this->db->insert('t_pendaftaran', $data);



        $id = $this->getLastPendaftaran([
            'NOMR' => $nomr,
            'TGLREG' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dtp_tanggal_daftar')))),
            'KDDOKTER' => $this->input->post('cb_dokterjaga'),
            'KDPOLY' => $this->input->post('cb_poly'),
            'KDRUJUK' => $this->input->post('cb_rujukan'),
            'PASIENBARU' => $this->input->post('rbflagstatusPasienDaftar'),
            'KDCARABAYAR' => $carabayar
        ]);

        return $id;
    }

    function getLastPendaftaran($where)
    {
        $this->db->select('IDXDAFTAR');
        $this->db->where($where);
        $this->db->limit(1);
        $this->db->order_by('IDXDAFTAR', 'DESC');
        $data = $this->db->get('t_pendaftaran')->row_array();
        return $data["IDXDAFTAR"];
    }

    function getLastPendaftaranByIdxNorm($idx, $norm)
    {
        $queryMenu = "SELECT 
                            a.id_bill_detail_tarif, a.idxdaftar
                        FROM
                            simrs.bill_detail_tarif a
                        WHERE
                            a.nomr = '".$norm."'
                                AND a.idxdaftar <> '".$idx."'
                        ORDER BY a.id_bill_detail_tarif DESC
                        LIMIT 1";

        return $this->db->query($queryMenu)->result_array();
    }

    function getLastNoBILL($param = 0)
    {
        $this->db->select('nomor');
        $data = $this->db->get('M_MAXNOBILL')->row_array();
        if ($data) {
            $result = $data["nomor"] + $param;
        } else {
            $result = 0 + $param;
        }

        return $result;
    }

    function simpanBilling($kdpoly, $pasienbaru)
    {
        $this->db->select('objid');
        $this->db->select('jenispoly');
        $this->db->select('tarif');
        $this->db->select('pasienbaru');
        $this->db->where("jenispoly", $kdpoly);
        $this->db->where("pasienbaru", $pasienbaru);
        return $this->db->get('m_tarifpendaftaran')->result_array();
    }

    public function simpantemp()
    {
        $kdpoly = $this->input->post('cb_poly');
        $pasienbaru = $this->input->post('rbflagstatusPasienDaftar');
        $dokter = $this->input->post('cb_dokterjaga');

        date_default_timezone_set('Asia/Jakarta');
        $data = $this->simpanBilling($kdpoly, $pasienbaru);
        if ($data) {
            $where = " WHERE `pasienbaru` = '" . $pasienbaru . "' ";
            $where .= " AND jenispoly = '" . $kdpoly . "' ";

            $sql = "INSERT INTO tmp_cartbayar (IP,IDPENDAFTARAN,poly,KDDOKTER,QTY,TARIF,TOTTARIF) ";
            $sql .= " SELECT '" . getRealIpAddr() . "',objid," . $kdpoly . ", " . $dokter . " , 1, tarif,(tarif*1) from simrs2012.m_tarifpendaftaran " . $where . " ORDER BY objid ASC  ";
            $this->db->query($sql);
            $result = $this->db->affected_rows();

            return $result;
        }
    }

    public function saveBillrajal($carabayar, $nomr, $nobill, $idxdaftar)
    {
        date_default_timezone_set('Asia/Jakarta');
        $kdpoly = $this->input->post('cb_poly');
        $pasienbaru = $this->input->post('rbflagstatusPasienDaftar');
        $dokter = $this->input->post('cb_dokterjaga');

        $data = $this->simpanBilling($kdpoly, $pasienbaru);
        if ($data) {

            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $sh = $this->input->post('rbShift');
            $shift  = isset($sh) ?  $sh : '0';
            $NIP  = $user["firstname"];

            if ($carabayar > 1) {
                $sql = " insert into t_billrajal (NOMR,KDPOLY,TANGGAL,SHIFT,NIP,QTY,IDXDAFTAR,NOBILL,ASKES,COSTSHARING,KETERANGAN,KDDOKTER,STATUS,CARABAYAR,APS,JASA_SARANA,JASA_PELAYANAN,UNIT,TARIFRS,IDOBJ) ";
                $sql .= " SELECT '" . $nomr . "',poly,CURDATE(),'" . $shift . "', '" . $NIP . "',1,'" . $idxdaftar . "','" . $nobill . "',0,0,'KARCIS PENDAFTARAN',KDDOKTER,'SELESAI','" . $carabayar . "',0,0,0,poly,TARIF,IDPENDAFTARAN   FROM tmp_cartbayar WHERE IP = '" . getRealIpAddr() . "' ";
            } else {
                $sql = " insert into t_billrajal (NOMR,KDPOLY,KDDOKTER,TANGGAL,SHIFT,NIP,QTY,IDXDAFTAR,STATUS,KETERANGAN,CARABAYAR,UNIT,TARIFRS,NOBILL,IDOBJ) ";
                $sql .= " SELECT '" . $nomr . "'  ,poly, KDDOKTER, CURDATE()  ,'" . $shift . "' ,'" . $NIP . "',1, '" . $idxdaftar . "'  , 'SELESAI','KARCIS PENDAFTARAN','" . $carabayar . "' ,poly,TARIF,'" . $nobill . "',IDPENDAFTARAN FROM tmp_cartbayar WHERE IP = '" . getRealIpAddr() . "'";
            }


            $this->db->query($sql);
            $result = $this->db->affected_rows();

            return $result;
        }
    }

    public function saveBayarrajal($carabayar, $nomr, $nobill, $idxdaftar)
    {
        date_default_timezone_set('Asia/Jakarta');
        $kdpoly = $this->input->post('cb_poly');
        $pasienbaru = $this->input->post('rbflagstatusPasienDaftar');
        $data = $this->simpanBilling($kdpoly, $pasienbaru);
        if ($data) {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $sh = $this->input->post('rbShift');
            $shift  = isset($sh) ?  $sh : '0';
            $NIP  = $user["firstname"];

            if ($carabayar > 1) {
                $sql = " insert into t_bayarrajal (NOMR,IDXDAFTAR,NOBILL,TOTTARIFRS,TOTJASA_SARANA,TOTJASA_PELAYANAN,APS,CARABAYAR,TGLBAYAR,JAMBAYAR,JMBAYAR,NIP,SHIFT,TBP,UNIT,LUNAS,STATUS)";
                $sql .= " SELECT '" . $nomr . "','" . $idxdaftar . "','" . $nobill . "',SUM(TARIFRS),0,0,0,'" . $carabayar . "',CURDATE(),CURTIME(),SUM(TARIFRS),'" . $NIP . "','" . $shift . "',0,UNIT,1,'LUNAS' FROM t_billrajal WHERE NOBILL ='" . $nobill . "'  ";
            } else {
                $sql = " insert into t_bayarrajal (NOMR,IDXDAFTAR,NOBILL,TOTTARIFRS,TOTJASA_SARANA,UNIT,TOTJASA_PELAYANAN,CARABAYAR) ";
                $sql .= " SELECT '" . $nomr . "' , '" . $idxdaftar . "' , '" . $nobill . "',SUM(TARIFRS),0,UNIT,0,'" . $carabayar . "' FROM t_billrajal WHERE NOBILL ='" . $nobill . "' ";
            }

            $this->db->query($sql);
            $result = $this->db->affected_rows();

            if ($result) {
                $this->deleteTMP();
            }
            return $result;
        }
    }

    function deleteTMP()
    {
        $this->db->where('IP', getRealIpAddr());
        $this->db->delete('tmp_cartbayar');
        return  $this->db->affected_rows();
    }

    function updateMaxBill($nobill)
    {
        $this->db->set('nomor', $nobill);
        $this->db->update('m_maxnobill');
        return  $this->db->affected_rows();
    }



    function updateBPJSMembershipNumber($idxdaftar)
    {

        $noPeserta = $this->input->post('tx_susulannokepesertaan_bpjs');
        $noRujukan = $this->input->post('tx_susulannorujukan_bpjs');
        $asalRujukan = $this->input->post('cb_asalrujukan');


        if ($noPeserta) {
            $this->db->set('NOKARTU',  $noPeserta);
            $this->db->set('NO_PESERTA',  $noPeserta);

            $this->db->set('NORUJUKAN_SEP',  $noRujukan);
            $this->db->set('NO_SJP',  $noRujukan);


            $this->db->set('asalfaskes', $asalRujukan);


            $this->db->where('IDXDAFTAR', $idxdaftar);
            $this->db->update('t_pendaftaran');
            return $this->db->affected_rows();
        }
    }



    function countOutpatientRegister($tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');

        if ($tanggal) {
            $date_selected = $tanggal;
        } else {
            $date_selected = date("Y-m-d");
        }

        $queryMenu = "SELECT COUNT(DISTINCT(NOMR)) as 'count' FROM t_pendaftaran where TGLREG  = '" . $date_selected . "' ";

        return $this->db->query($queryMenu)->row_array();
    }

    function countOutpatientSEP($tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($tanggal) {
            $date_selected = $tanggal;
        } else {
            $date_selected = date("Y-m-d");
        }

        $queryMenu = "SELECT COUNT(DISTINCT(NOMR)) as 'count' FROM t_pendaftaran where TGLREG  = '" . $date_selected . "'  AND length(NO_SJP) > 5 ";

        return $this->db->query($queryMenu)->row_array();
    }


    function graphCounterPatentsOfWeeks($week = 0)
    {
        $queryMenu = "SELECT COUNT(*) total, DATE(r.TGLREG) tanggal, DATE_FORMAT(r.TGLREG, '%d') tanggal, DATE_FORMAT(r.TGLREG, '%w') hari FROM simrs2012.t_pendaftaran r WHERE YEARWEEK(r.TGLREG, 0) = YEARWEEK(NOW() - INTERVAL " . $week . " DAY, 0) GROUP BY DATE(r.TGLREG) ORDER BY DATE(r.TGLREG) ASC";

        return $this->db->query($queryMenu)->result_array();
    }

    function YearlyGraphPatientStatusMark($statusMark = 0)
    {
        $queryMenu = "SELECT MONTH(TGLREG) AS bulan, COUNT(DISTINCT(NOMR)) AS count
        FROM simrs2012.t_pendaftaran
        WHERE 
        PASIENBARU = " . $statusMark . "
        AND year(TGLREG) = year(CURDATE())
        GROUP BY MONTH(TGLREG)";

        return $this->db->query($queryMenu)->result_array();
    }



    function countNewOutPatient($tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($tanggal) {
            $date_selected = $tanggal;
        } else {
            $date_selected = date("Y-m-d");
        }

        $queryMenu = "select COUNT(DISTINCT(NOMR)) as 'count' FROM t_pendaftaran where TGLREG = '" . $date_selected . "' AND PASIENBARU = 1";

        return $this->db->query($queryMenu)->row_array();
    }


    function countNewOrderInpatientRegister()
    {
        date_default_timezone_set('Asia/Jakarta');

        $queryMenu = "SELECT COUNT(IDXORDER) as 'count' FROM simrs2012.t_orderadmission WHERE STATUS  = '0'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countOutPatientRegisterGroupByDoctor($tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($tanggal) {
            $date_selected = $tanggal;
        } else {
            $date_selected = date("Y-m-d");
        }
        $queryMenu = "SELECT a.KDDOKTER,b.NAMADOKTER, COUNT(a.KDDOKTER)  as JUMLAH, a.KDPOLY from t_pendaftaran  a LEFT OUTER JOIN m_dokter b ON (a.KDDOKTER=b.KDDOKTER) WHERE a.TGLREG =  '" . $date_selected . "'  GROUP  BY a.KDDOKTER,a.KDPOLY ORDER BY COUNT(a.KDDOKTER)  DESC  ";

        return $this->db->query($queryMenu)->result_array();
    }

    function countOutPatientGroupByPoliklinik($tanggal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($tanggal) {
            $date_selected = $tanggal;
        } else {
            $date_selected = date("Y-m-d");
        }
        $queryMenu = "select * FROM  vw_jumlah_pendaftaran_pasien_rajal_by_poli WHERE JMLPASIEN > 0 ORDER BY JMLPASIEN DESC";

        return $this->db->query($queryMenu)->result_array();
    }

    function outPatientRegistrationEdit($idx, $data)
    {
        $user   =  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->set('SHIFT', $data["rbShift"]);
        $this->db->set('NOMR', $data["nomr"]);
        $this->db->set('KDPOLY', $data["cb_poly"]);
        $this->db->set('KDDOKTER', $data["cb_dokterjaga"]);
        $this->db->set('NO_SJP', $data["tx_no_rujukan_bpjs"]);
        $this->db->set('NORUJUKAN_SEP', $data["tx_no_rujukan_bpjs"]);
        $this->db->set('NOKARTU', $data["nokabpjs"]);

        $this->db->set('PASIENBARU', $data["rbflagstatusPasienDaftar"]);

        $this->db->set('KDRUJUK', $data["cb_rujukan"]);
        $this->db->set('KETRUJUK', $data["ketrujuk"]);

        if ($data["rbParentCarabayar"] == 1) {
            $this->db->set('KDCARABAYAR', 1);
        } else {
            $this->db->set('KDCARABAYAR', $data["cb_carabayar"]);
        }
        // catatan ; rubah juga di table t_sep
        $this->db->set('NOKARTU_BPJS', $data["nokabpjs"]);
        $this->db->set('NO_PESERTA', $data["nokabpjs"]);

        $this->db->set('TGLREG',  date('Y-m-d', strtotime($data["dtp_tanggal_daftar"])));
        $this->db->set('NIP',  $user["firstname"] . " " . $user["lastname"]);

        $this->db->set('PENANGGUNGJAWAB_HUBUNGAN', $data["cb_hubungan"]);
        $this->db->set('PENANGGUNGJAWAB_NAMA', $data["tx_namapenanggungjawab"]);
        $this->db->set('PENANGGUNGJAWAB_PHONE', $data["tx_notel_penanggungjawab"]);
        $this->db->set('PENANGGUNGJAWAB_ALAMAT', $data["tx_alamatpenanggungjawab"]);

        $this->db->where('IDXDAFTAR', $idx);
        $this->db->update('t_pendaftaran');
        setMessage($this->db->affected_rows());
    }

    function cancelOutpatienRegistration($idx)
    {
        $this->db->set('BATAL', 1);
        $this->db->where('IDXDAFTAR', $idx);
        $this->db->update('t_pendaftaran');
        return $this->db->affected_rows();
    }

    function cancelOutpatienRegistration_on_temp_pendaftaran($idx)
    {
        $this->db->where('IDXDAFTAR', $idx);
        $this->db->delete('temp_pendaftaran');
        return $this->db->affected_rows();
    }

    public function getEklaimri($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tgldaftar = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_sep.id,t_sep.tgl_sep,t_sep.nomer_sep,t_sep.nomr,t_sep.idx, t_sep.no_kartubpjs,
    t_sep.jenis_layanan,t_sep.signature');
        $this->db->select('t_pendaftaran.TGLREG,t_pendaftaran.KDPOLY');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif,bill_detail_tarif.userlevelid');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('userlevels.id_pelayanan');

        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('simrs.userlevels.id_pelayanan', '2');


        if ($keyword) {
            $this->db->where("t_sep.nomr", $keyword);
            $this->db->where('simrs.userlevels.id_pelayanan', '2');
            // $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }
        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
        }
        if ($tgldaftar) {
            $this->db->where("t_pendaftaran.TGLREG", $tgldaftar);
        }
        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }

        $this->db->join('m_pasien', 't_sep.nomr = m_pasien.NOMR', 'left outer');
        $this->db->join('t_pendaftaran', 't_sep.idx = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->join('simrs.bill_detail_tarif', 't_sep.idx = simrs.bill_detail_tarif.idxdaftar', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.bill_detail_tarif.userlevelid = simrs.userlevels.userlevelid', 'left outer');

        return $this->db->get('t_sep')->result_array();
    }

    public function getEklaim($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tanggalcari = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_sep.id,t_sep.tgl_sep,t_sep.nomer_sep,t_sep.nomr,t_sep.idx, t_sep.no_kartubpjs,t_sep.nomer_sep,
    t_sep.jenis_layanan as jenis_layanan,t_sep.idx,t_sep.signature');
        $this->db->select('t_pendaftaran.KDPOLY');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif,bill_detail_tarif.userlevelid,bill_detail_tarif.tglreg as TGLREG,bill_detail_tarif.total_keseluruhan');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('userlevels.id_pelayanan');
        // $this->db->select('bill_detail_tarif_detail.id_bill_detail_tarif_detail');
        if ($keyword) {
            $where = "(t_sep.nomr='" . $keyword . "' OR m_pasien.NAMA LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }
        if ($poli) {
            $this->db->where("t_pendaftaran.KDPOLY", $poli);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }
        if ($tanggalcari) {
            $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }

        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }


        $this->db->order_by('t_pendaftaran.TGLREG', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('simrs.userlevels.id_pelayanan', '1');
        $this->db->join('m_pasien', 't_sep.nomr = m_pasien.NOMR', 'left outer');
        $this->db->join('t_pendaftaran', 't_sep.idx = t_pendaftaran.IDXDAFTAR', 'left outer');
        $this->db->join('simrs.bill_detail_tarif', 't_sep.idx = simrs.bill_detail_tarif.idxdaftar', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.bill_detail_tarif.userlevelid = simrs.userlevels.userlevelid', 'left outer');
        return $this->db->get('t_sep')->result_array();
    }

    public function getIdbildetailtarifdetail($id_bill_detail_tarif_detail)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('id_bill_detail_tarif_detail,id_bill_detail_tarif');
        $this->db->where('id_bill_detail_tarif', $id_bill_detail_tarif);
        return $this->db->get('simrs.bill_detail_tarif_detail')->result_array();
    }

    public function getEklaimtes($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tanggalcari = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif,
    bill_detail_tarif.userlevelid as KDPOLY,
    bill_detail_tarif.tglreg AS TGLREG,
    bill_detail_tarif.total_keseluruhan,
    bill_detail_tarif.IDXDAFTAR AS idx,bill_detail_tarif.nomr');
        // $this->db->select('t_pendaftaran.KDPOLY');
        // $this->db->select('bill_detail_tarif.id_bill_detail_tarif,bill_detail_tarif.userlevelid,bill_detail_tarif.tglreg as TGLREG,bill_detail_tarif.total_keseluruhan');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('userlevels.id_pelayanan');

        if ($keyword) {
            $where = "(bill_detail_tarif.nomr='" . $keyword . "' OR m_pasien.NAMA LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }
        if ($poli) {
            $this->db->where("bill_detail_tarif.userlevelid", $poli);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }
        if ($tanggalcari) {
            $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
            $this->db->where("simrs.userlevels.id_pelayanan", '1');
        }

        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }


        $this->db->order_by('bill_detail_tarif.tglreg', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('simrs.userlevels.id_pelayanan', '1');
        $where = '(simrs.bill_detail_tarif.kdcarabayar=3 or simrs.bill_detail_tarif.kdcarabayar = 4)';
        $this->db->where($where);
        $this->db->join('m_pasien', 'bill_detail_tarif.nomr = m_pasien.NOMR', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.bill_detail_tarif.userlevelid = simrs.userlevels.userlevelid', 'left outer');
        return $this->db->get('simrs.bill_detail_tarif')->result_array();
    }

    public function getEklaiminap($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tanggalcari = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('bill_detail_tarif.id_bill_detail_tarif,
    bill_detail_tarif.userlevelid as KDPOLY,
    bill_detail_tarif.tglreg AS TGLREG,
    bill_detail_tarif.total_keseluruhan,
    bill_detail_tarif.IDXDAFTAR AS idx,bill_detail_tarif.nomr');
        // $this->db->select('t_pendaftaran.KDPOLY');
        // $this->db->select('bill_detail_tarif.id_bill_detail_tarif,bill_detail_tarif.userlevelid,bill_detail_tarif.tglreg as TGLREG,bill_detail_tarif.total_keseluruhan');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('userlevels.id_pelayanan');

        if ($keyword) {
            $where = "(bill_detail_tarif.nomr='" . $keyword . "' OR m_pasien.NAMA LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
            $this->db->where("simrs.userlevels.id_pelayanan", '2');
        }
        if ($poli) {
            $this->db->where("bill_detail_tarif.userlevelid", $poli);
            $this->db->where("simrs.userlevels.id_pelayanan", '2');
        }
        if ($tanggalcari) {
            $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
            $this->db->where("simrs.userlevels.id_pelayanan", '2');
        }

        if ($tanggal) {
            $_tanggal = $tanggal;
        } else {
            $_tanggal = date('Y-m-d');
        }


        $this->db->order_by('bill_detail_tarif.tglreg', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('simrs.userlevels.id_pelayanan', '2');
        $where = '(simrs.bill_detail_tarif.kdcarabayar=3 or simrs.bill_detail_tarif.kdcarabayar = 4)';
        $this->db->where($where);
        $this->db->join('m_pasien', 'bill_detail_tarif.nomr = m_pasien.NOMR', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.bill_detail_tarif.userlevelid = simrs.userlevels.userlevelid', 'left outer');
        return $this->db->get('simrs.bill_detail_tarif')->result_array();
    }

    // public function getTujuanKunj()
    // {
    //     return $this->db->get('simrs2012.l_tujuan_kunjungan')->result_array();
    // }

    public function getListPerusahaan()
    {
        // $this->db->where('KODE !=', 1);
        // $this->db->order_by('ORDERS', 'ASC');
        $this->db->order_by('kode_perusahaan', 'ASC');
        return $this->db->get_where('m_perusahaan')->result_array();
    }

    public function getkdAntrian($kodepoli)
    {
        return $this->db->get_where('simrs2012.m_poly', ['kode' => $kodepoli])->result_array();
    }

    public function saveToPendaftaran($input){
        $this->db->set('NO_PESERTA',  $input['noka']);
        $this->db->set('NOKARTU',  $input['noka']);
        $this->db->where('IDXDAFTAR',  $input['idxdaftar']);
        $this->db->update('t_pendaftaran');
        return $this->db->affected_rows();
    }

    public function getJenisKunjungan()
    {
        return $this->db->get_where('simrs2012.l_jeniskunjungan')->result_array();
    }
}
