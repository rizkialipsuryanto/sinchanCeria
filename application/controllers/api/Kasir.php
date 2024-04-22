<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        // $this->load->model('Vclaim_model', 'vclaim');
        $this->load->model('Simrs_model', 'kucluk');
    }


    public function tambahcart()
    {
        $idx = $this->input->post('idx');
        $idpemeriksaanmedis = $this->input->post('idpemeriksaanmedis');
        $this->kucluk->addCartPemeriksaanPasien($idx,  $idpemeriksaanmedis);
    }


    public function hapuscart()
    {
        $idx = $this->input->post('idx');
        $idbaris = $this->input->post('iddetailtindakan');
        $this->kucluk->removeCartPemeriksaanPasien($idx,  $idbaris);
    }


    public function ubahStatusPembayaran()
    {
        $id = $this->input->post('id');
        $idx = $this->input->post('idx');
        $detailtarif = $this->input->post('detailtarif');


        // echo json_encode(array($id, $idx, $detailtarif));
        // $idx = $this->input->post('idx');
        // $idbaris = $this->input->post('iddetailtindakan');
        // $this->kucluk->removeCartPemeriksaanPasien($idx,  $idbaris);

        // ubah id_status_transaksi
        // kirim flaging 
    }
}
