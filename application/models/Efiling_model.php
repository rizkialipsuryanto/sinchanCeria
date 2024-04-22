<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Efiling_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // public function getData($limit, $start, $keyword = null, $poli = null, $tanggal = null, $carabayar = null, $batal = null)
    // {
    // 	$this->db->cache_on();
    //     date_default_timezone_set('Asia/Jakarta');

    // 	return $this->db->get('t_pendaftaran_android')->result_array();
    // }

    public function getData($limit, $start, $poli = null, $carabayar = null, $tanggal = null, $keyword = null)
    {
        $this->db->cache_on();
        date_default_timezone_set('Asia/Jakarta');

        $this->db->select('t_pendaftaran_android.id');
        $this->db->select('t_pendaftaran_android.pasienbaru');
        $this->db->select('t_pendaftaran_android.nomr');
        $this->db->select('t_pendaftaran_android.tanggal');
        $this->db->select('t_pendaftaran_android.nama');
        $this->db->select('t_pendaftaran_android.poliklinik');
        $this->db->select('t_pendaftaran_android.dokter');
        $this->db->select('t_pendaftaran_android.jenis_pasien');
        $this->db->select('t_pendaftaran_android.hubungan');
        $this->db->select('t_pendaftaran_android.tgl_lahir');
        $this->db->select('t_pendaftaran_android.penjamin');
        $this->db->select('t_pendaftaran_android.nobpjs');
        $this->db->select('t_pendaftaran_android.norujukan');

        if ($poli) {
            $this->db->where("t_pendaftaran_android.poliklinik", $poli);
        }
        if ($carabayar) {
            $this->db->where("t_pendaftaran_android.penjamin", $carabayar);
        }
        if ($tanggal) {
            $this->db->where("t_pendaftaran_android.tanggal", $tanggal);
        }
        if ($keyword) {
            $this->db->where("t_pendaftaran_android.nomr", $keyword);
        }

        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        // $this->db->where('t_pendaftaran_android');

        return $this->db->get('t_pendaftaran_android')->result_array();
    }
    public function getList()
    {
        // $this->db->cache_on();
        date_default_timezone_set('Asia/Jakarta');

        $this->db->select('t_pendaftaran_android.id');
        $this->db->select('t_pendaftaran_android.pasienbaru');
        $this->db->select('t_pendaftaran_android.nomr');
        $this->db->select('t_pendaftaran_android.tanggal');
        $this->db->select('t_pendaftaran_android.nama');
        $this->db->select('t_pendaftaran_android.poliklinik');
        $this->db->select('t_pendaftaran_android.dokter');
        $this->db->select('t_pendaftaran_android.jenis_pasien');
        $this->db->select('t_pendaftaran_android.hubungan');
        $this->db->select('t_pendaftaran_android.tgl_lahir');
        $this->db->select('t_pendaftaran_android.penjamin');
        $this->db->select('t_pendaftaran_android.nobpjs');
        $this->db->select('t_pendaftaran_android.norujukan');


        $this->db->order_by('id', 'DESC');

        return $this->db->get('t_pendaftaran_android')->result_array();
    }
}
