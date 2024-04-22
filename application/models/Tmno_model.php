<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmno_model  extends CI_Model
{
    public function getTmnoPoli($kdpoli = 2, $keywordtindakan = null)
    {
        $this->db->order_by('TINDAKAN', 'ASC');
        $this->db->limit(10);
        if ($keywordtindakan) {
            $this->db->like("y_tmno_poli.TINDAKAN", $keywordtindakan);
        }

        if ($kdpoli == 2) {
            // $this->db->like('TINDAKAN', 'USG');
            return $this->db->get_where('y_tmno_poli', ['KODE_POLI' => 2])->result_array();
        } else {
            return $this->db->get_where('y_tmno_poli', ['KODE_POLI' => $kdpoli])->result_array();
        }
    }

    public function getListTMNOPasien($idxDaftar)
    {

        $this->db->select('y_tmno_poli.TINDAKAN');
        $this->db->select('y_tmno_poli.TARIF');
        $this->db->select('y_tindakan_diagnosa_tindakan.IDXDAFTAR');
        $this->db->select('y_tindakan_diagnosa_tindakan.ID_TINDAKAN_DIAGNOSA_TINDAKAN');
        $this->db->select('y_tmno_poli.BHP');
        $this->db->select('y_tmno_poli.ID_TMNO');
        $this->db->select('y_tindakan_diagnosa_tindakan.QTY');
        $this->db->select('y_tindakan_diagnosa_tindakan.TOTAL_TMNO');
        $this->db->join('y_tmno_poli', 'y_tindakan_diagnosa_tindakan.ID_TMNO = y_tmno_poli.ID_TMNO', 'left');
        return $this->db->get_where('y_tindakan_diagnosa_tindakan', ['y_tindakan_diagnosa_tindakan.IDXDAFTAR' => $idxDaftar])->result_array();
    }

    public function getTempTindakan()
    {

        $this->db->select('tmp_cartbayar.IDXBAYAR');
        $this->db->select('tmp_cartbayar.TARIF');
        $this->db->select('tmp_cartbayar.BHP');
        $this->db->select('tmp_cartbayar.IDTMNO');
        $this->db->select('tmp_cartbayar.QTY');
        $this->db->select('tmp_cartbayar.TOTTARIF');
        $this->db->select('y_tmno_poli.TINDAKAN');
        $this->db->select('tmp_cartbayar.UID');
        $this->db->select('tmp_cartbayar.INSERTED_AT');
        $this->db->join('y_tmno_poli', 'tmp_cartbayar.IDTMNO = y_tmno_poli.ID_TMNO', 'left');
        $this->db->where('tmp_cartbayar.IDTMNO is NOT NULL', NULL, FALSE);
        return $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->result_array();
    }


    public function simpanKe_y_tindakan_diagnosa_tindakan($idxdaftar)
    {

        $ip = getRealIpAddr();
        $sql = "INSERT INTO y_tindakan_diagnosa_tindakan (IDXDAFTAR, ID_TMNO,QTY,TARIF_TMNO,BHP,KDPOLY,ID_TYPE_TMNO)  

        SELECT '" . $idxdaftar . "',a.IDTMNO,a.QTY,a.TARIF,a.BHP,
        (SELECT KODE_POLI FROM y_tmno_poli WHERE ID_TMNO  =  a.IDTMNO) 'KODE_POLI' ,
        (SELECT ID_TYPE_TMNO FROM y_tmno_poli WHERE ID_TMNO  =  a.IDTMNO) 'ID_TYPE_TMNO' 
        FROM simrs2012.tmp_cartbayar a WHERE a.IP = '" . getRealIpAddr() . "' ";
        $this->db->query($sql);
    }

    public function getSUMTempTindakan()
    {
        $this->db->select_sum('tmp_cartbayar.TOTTARIF', 'total');
        $this->db->where('tmp_cartbayar.IDTMNO is NOT NULL', NULL, FALSE);
        $data = $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->row_array();
        return $data["total"];
    }


    public function getSUMTempTindakanKeperawatan()
    {
        $this->db->select_sum('tmp_cartbayar.TOTTARIF', 'total');
        $this->db->where('tmp_cartbayar.IDTMNOTINDKEP is NOT NULL', NULL, FALSE);
        $data = $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->row_array();
        return $data["total"];
    }


    public function getSUMTempTindakanLaboratorium()
    {
        $this->db->select_sum('tmp_cartbayar.TOTTARIF', 'total');
        $this->db->where('tmp_cartbayar.IDTMNOLAB is NOT NULL', NULL, FALSE);
        $data = $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->row_array();
        return $data["total"];
    }

    public function getSUMTempTindakanRadiologi()
    {
        $this->db->select_sum('tmp_cartbayar.TARIF', 'total');
        $this->db->where('tmp_cartbayar.IDTMNORAD is NOT NULL', NULL, FALSE);
        $data = $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->row_array();
        return $data["total"];
    }


    public function getSUMTempTindakan_y_tindakan_diagnosa_tindakan($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_diagnosa_tindakan.TOTAL_TMNO', 'total');
        $data = $this->db->get_where('y_tindakan_diagnosa_tindakan', ['y_tindakan_diagnosa_tindakan.IDXDAFTAR' => $idxdaftar])->row_array();
        return $data["total"];
    }

    public function getSUMTempTindakan_y_tindakan_keperawatan($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_keperawatan.TOTAL_TMNO', 'total');
        $data = $this->db->get_where('y_tindakan_keperawatan', ['y_tindakan_keperawatan.IDXDAFTAR' => $idxdaftar])->row_array();
        return $data["total"];
    }

    public function getSUMTempTindakan_y_tindakan_laboratorium($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_laboratorium.TOTAL_TMNO', 'total');
        $data = $this->db->get_where('y_tindakan_laboratorium', ['y_tindakan_laboratorium.IDXDAFTAR' => $idxdaftar])->row_array();
        return $data["total"];
    }
    public function getSUMTempTindakan_y_tindakan_radiologi($idxdaftar)
    {
        $this->db->select_sum('y_tindakan_radiologi.TOTAL_TMNO', 'total');
        $data = $this->db->get_where('y_tindakan_radiologi', ['y_tindakan_radiologi.IDXDAFTAR' => $idxdaftar])->row_array();
        return $data["total"];
    }


    public function saveCart($idxdaftar, $idtmno)
    {


        $keterangan = $this->input->post('keterangan');

        $existing_qty = $this->db->get_where('tmp_cartbayar', ['IP' => getRealIpAddr(), 'IDTMNO' => $idtmno])->row_array();


        if ($existing_qty) {
            $this->db->set('QTY', $existing_qty["QTY"] + 1);
            $this->db->set('TOTTARIF', ($existing_qty["QTY"] + 1) * ($existing_qty["TARIF"] + $existing_qty["BHP"]));
            $this->db->where('IP', getRealIpAddr());
            $this->db->where('IDTMNO', $idtmno);
            $this->db->update('tmp_cartbayar');
        } else {

            $tmno = $this->db->get_where('y_tmno_poli', ['ID_TMNO' => $idtmno])->row_array();
            $data_pendaftaran = $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idxdaftar])->row_array();
            $user  =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $data["IP"] = getRealIpAddr();
            $data["IDTMNO"] = $idtmno;
            $data["QTY"] = 1;
            $data["poly"] = $data_pendaftaran["KDPOLY"];
            $data["KDDOKTER"] = $data_pendaftaran["KDDOKTER"];
            $data["TARIF"] = $tmno["TARIF"];
            $data["TOTTARIF"] = $tmno["TARIF"] + $tmno["BHP"]; //$tmno["TARIF"] *  $data["QTY"];
            $data["JASA_PELAYANAN"] = '';
            $data["JASA_SARANA"] = '';
            $data["BHP"] = $tmno["BHP"];
            $data["UNIT"] = $data_pendaftaran["KDPOLY"];
            $data["KETERANGAN"] = $keterangan;
            $data["UID"] = $user["id"];
            $data["INSERTED_AT"] = time();
            $this->db->insert('tmp_cartbayar', $data);
        }
    }

    public function saveCartTMNO($idx, $idtmo)
    {
        // $idx = $this->input->post('idx');
        // $idtmo = $this->input->post('idtmo');
        $keterangan = $this->input->post('keterangan');

        $existing_qty = $this->db->get_where('tmp_cartbayar', ['IP' => getRealIpAddr(), 'IDTMO' => $idtmo])->row_array();

        if ($existing_qty) {
            $this->db->set('QTY', $existing_qty["QTY"] + 1);
            $this->db->set('TOTTARIF', ($existing_qty["QTY"] + 1) * ($existing_qty["TARIF"] + $existing_qty["BHP"]));
            $this->db->where('IP', getRealIpAddr());
            $this->db->where('IDTMO', $idtmo);
            $this->db->update('tmp_cartbayar');
        } else {
            $tmo = $this->db->get_where('y_tmo_poli', ['ID_TMO' => $idtmo])->row_array();
            $data_pendaftaran = $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idx])->row_array();
            $user  =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


            $data["IP"] = getRealIpAddr();
            $data["IDTMO"] =  $idtmo;
            $data["QTY"] = 1;
            $data["poly"] = $data_pendaftaran["KDPOLY"];
            $data["KDDOKTER"] = $data_pendaftaran["KDDOKTER"];
            $data["TARIF"] = $tmo["TARIF"];
            $data["TOTTARIF"] = $tmo["TARIF"] + $tmo["BHP"];
            $data["JASA_PELAYANAN"] = '';
            $data["JASA_SARANA"] = '';
            $data["BHP"] = $tmo["BHP"];
            $data["UNIT"] = $data_pendaftaran["KDPOLY"];
            $data["KETERANGAN"] = $keterangan;
            $data["UID"] = $user["id"];
            $data["INSERTED_AT"] = time();
            $this->db->insert('tmp_cartbayar', $data);
        }
    }

    public function saveCartTindakanKeperawatanPoli($idx, $idtmno)
    {
        $keterangan = $this->input->post('keterangan');
        $existing_qty = $this->db->get_where('tmp_cartbayar', ['IP' => getRealIpAddr(), 'IDTMNOTINDKEP' => $idtmno])->row_array();

        if ($existing_qty) {
            $this->db->set('QTY', $existing_qty["QTY"] + 1);
            $this->db->set('TOTTARIF', ($existing_qty["QTY"] + 1) * ($existing_qty["TARIF"] + $existing_qty["BHP"]));
            $this->db->where('IP', getRealIpAddr());
            $this->db->where('IDTMNOTINDKEP', $idtmno);
            $this->db->update('tmp_cartbayar');
        } else {
            $tmno = $this->db->get_where('y_tmno_keperawatan', ['ID_TMNO_KEPERAWATAN' => $idtmno])->row_array();
            $data_pendaftaran = $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idx])->row_array();
            $user  =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


            $data["IP"] = getRealIpAddr();
            $data["IDTMNOTINDKEP"] =  $idtmno;
            $data["QTY"] = 1;
            $data["poly"] = $tmno["KODE_POLI"];
            $data["KDDOKTER"] = $data_pendaftaran["KDDOKTER"];
            $data["TARIF"] = $tmno["TARIF"];
            $data["TOTTARIF"] = $tmno["TARIF"] + $tmno["BHP"];
            $data["JASA_PELAYANAN"] = '';
            $data["JASA_SARANA"] = '';
            $data["BHP"] = $tmno["BHP"];
            $data["UNIT"] = $data_pendaftaran["KDPOLY"];
            $data["KETERANGAN"] = $keterangan;
            $data["UID"] = $user["id"];
            $data["INSERTED_AT"] = time();
            $this->db->insert('tmp_cartbayar', $data);
        }
    }

    public function saveCartTindakanLab($idx, $idtmno)
    {
        $keterangan = $this->input->post('keterangan');
        $existing_qty = $this->db->get_where('tmp_cartbayar', ['IP' => getRealIpAddr(), 'IDTMNOLAB' => $idtmno])->row_array();


        if ($existing_qty) {
            $this->db->set('QTY', $existing_qty["QTY"] + 1);
            $this->db->set('TOTTARIF', ($existing_qty["QTY"] + 1) * ($existing_qty["TARIF"] + $existing_qty["BHP"]));
            $this->db->where('IP', getRealIpAddr());
            $this->db->where('IDTMNOLAB', $idtmno);
            $this->db->update('tmp_cartbayar');
        } else {
            $tmno = $this->db->get_where('y_tmno_laboratorium', ['ID_TMNO_LABORATORIUM' => $idtmno])->row_array();
            $data_pendaftaran = $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idx])->row_array();
            $user  =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


            $data["IP"] = getRealIpAddr();
            $data["IDTMNOLAB"] =  $idtmno;
            $data["QTY"] = 1;
            $data["poly"] = $data_pendaftaran["KDPOLY"];
            $data["KDDOKTER"] = $data_pendaftaran["KDDOKTER"];
            $data["TARIF"] = $tmno["JASA_PELAYANAN"];
            $data["TOTTARIF"] = $tmno["JASA_PELAYANAN"] + $tmno["JASA_SARANA"] + $tmno["BHP"];
            $data["JASA_PELAYANAN"] = '';
            $data["JASA_SARANA"] = '';
            $data["BHP"] = $tmno["BHP"];
            $data["UNIT"] = $data_pendaftaran["KDPOLY"];
            $data["KETERANGAN"] = $keterangan;
            $data["UID"] = $user["id"];
            $data["INSERTED_AT"] = time();
            $this->db->insert('tmp_cartbayar', $data);
        }
    }


    public function saveCartTindakanRad($idx, $idtmno)
    {
        $keterangan = $this->input->post('keterangan');
        $existing_qty = $this->db->get_where('tmp_cartbayar', ['IP' => getRealIpAddr(), 'IDTMNORAD' => $idtmno])->row_array();

        if ($existing_qty) {
            $this->db->set('QTY', $existing_qty["QTY"] + 1);
            $this->db->set('TOTTARIF', ($existing_qty["QTY"] + 1) * ($existing_qty["TARIF"] + $existing_qty["BHP"]));
            $this->db->where('IP', getRealIpAddr());
            $this->db->where('IDTMNORAD', $idtmno);
            $this->db->update('tmp_cartbayar');
        } else {
            $tmno = $this->db->get_where('y_tmno_radiologi', ['ID_TMNO_RADIOLOGI' => $idtmno])->row_array();
            $data_pendaftaran = $this->db->get_where('t_pendaftaran', ['IDXDAFTAR' => $idx])->row_array();
            $user  =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


            $data["IP"] = getRealIpAddr();
            $data["IDTMNORAD"] =  $idtmno;
            $data["QTY"] = 1;
            $data["poly"] = $data_pendaftaran["KDPOLY"];
            $data["KDDOKTER"] = $data_pendaftaran["KDDOKTER"];
            $data["TARIF"] = $tmno["TARIF"];
            $data["TOTTARIF"] = ""; //$tmno["JASA_PELAYANAN"] + $tmno["JASA_SARANA"] + $tmno["BHP"];
            $data["JASA_PELAYANAN"] = '';
            $data["JASA_SARANA"] = $tmno["JASA_SARANA"];
            $data["BHP"] = $tmno["BHP"];
            $data["UNIT"] = $data_pendaftaran["KDPOLY"];
            $data["KETERANGAN"] = $keterangan;
            $data["UID"] = $user["id"];
            $data["INSERTED_AT"] = time();
            $this->db->insert('tmp_cartbayar', $data);
        }
    }
    public function deleteCart($idxbayar, $idtmno)
    {

        // $this->db->where('IDXDAFTAR', $idxdaftar);
        // $this->db->where('ID_TMNO', $idtmno);
        // $this->db->delete('y_tindakan_diagnosa_tindakan');
        // $this->db->where('IDXDAFTAR', $idxdaftar);
        $this->db->where('IDXBAYAR', $idxbayar);
        //$this->db->where('IDTMNO', $idtmno);
        $this->db->delete('tmp_cartbayar');
    }

    public function deleteCart_y_tindakan_diagnosa_tindakan($id, $idxdaftar, $idtmno)
    {
        $this->db->where('IDXDAFTAR', $idxdaftar);
        $this->db->where('ID_TMNO', $idtmno);
        $this->db->where('ID_TINDAKAN_DIAGNOSA_TINDAKAN', $id);
        $this->db->delete('y_tindakan_diagnosa_tindakan');
    }
    public function deleteCart_y_tindakan_keperawatan($id, $idxdaftar, $idtmno)
    {
        $this->db->where('IDXDAFTAR', $idxdaftar);
        $this->db->where('ID_TMNO_KEPERAWATAN', $idtmno);
        $this->db->where('ID_TINDAKAN_KEPERAWATAN', $id);
        $this->db->delete('y_tindakan_keperawatan');
    }
    public function deleteCart_y_tindakan_laboratorium($id, $idxdaftar, $idtmno)
    {
        $this->db->where('IDXDAFTAR', $idxdaftar);
        $this->db->where('ID_TMNO', $idtmno);
        $this->db->where('ID_TINDAKAN_LABORATORIUM', $id);
        $this->db->delete('y_tindakan_laboratorium');
    }
    public function deleteCart_y_tindakan_radiologi($id, $idxdaftar, $idtmno)
    {
        $this->db->where('IDXDAFTAR', $idxdaftar);
        $this->db->where('ID_TMNO', $idtmno);
        $this->db->where('ID_TINDAKAN_RADIOLOGI', $id);
        $this->db->delete('y_tindakan_radiologi');
    }

    public function getTotalTagihanTMNO($idxDaftar, $flag = "KEBIDANAN")
    {

        if ($flag == "KEBIDANAN") {

            $this->db->where('ID_TYPE_TMNO', '10');
            $this->db->where('KDPOLY', 2);
        }
        $this->db->select_sum('y_tindakan_diagnosa_tindakan.TOTAL_TMNO', 'TOTAL');
        $this->db->where('IDXDAFTAR', $idxDaftar);
        $data =  $this->db->get('y_tindakan_diagnosa_tindakan')->row_array();
        return $data["TOTAL"];
    }


    public function getTempTindakanKeperawatanPoli()
    {

        $this->db->select('tmp_cartbayar.IDXBAYAR');
        $this->db->select('tmp_cartbayar.TARIF');
        $this->db->select('tmp_cartbayar.BHP');
        $this->db->select('tmp_cartbayar.IDTMNO');
        $this->db->select('tmp_cartbayar.QTY');
        $this->db->select('tmp_cartbayar.TOTTARIF');
        $this->db->select('y_tmno_keperawatan.TINDAKAN');
        $this->db->select('tmp_cartbayar.UID');
        $this->db->select('tmp_cartbayar.INSERTED_AT');
        $this->db->join('y_tmno_keperawatan', 'tmp_cartbayar.IDTMNOTINDKEP = y_tmno_keperawatan.ID_TMNO_KEPERAWATAN', 'left');
        $this->db->where('tmp_cartbayar.IDTMNOTINDKEP is NOT NULL', NULL, FALSE);
        return $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->result_array();
    }

    public function getTempTindakanLaboratorium()
    {

        $this->db->select('tmp_cartbayar.IDXBAYAR');
        $this->db->select('tmp_cartbayar.TARIF');
        $this->db->select('tmp_cartbayar.BHP');
        $this->db->select('tmp_cartbayar.IDTMNO');
        $this->db->select('tmp_cartbayar.QTY');
        $this->db->select('tmp_cartbayar.TOTTARIF');
        $this->db->select('y_tmno_laboratorium.NAMA_TMNO_LABORATORIUM');
        $this->db->select('tmp_cartbayar.UID');
        $this->db->select('tmp_cartbayar.INSERTED_AT');
        $this->db->join('y_tmno_laboratorium', 'tmp_cartbayar.IDTMNOLAB = y_tmno_laboratorium.ID_TMNO_LABORATORIUM', 'left');
        $this->db->where('tmp_cartbayar.IDTMNOLAB is NOT NULL', NULL, FALSE);
        return $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->result_array();
    }


    public function getTempTindakanRadiologi()
    {

        $this->db->select('tmp_cartbayar.IDXBAYAR');
        $this->db->select('tmp_cartbayar.TARIF');
        $this->db->select('tmp_cartbayar.BHP');
        $this->db->select('tmp_cartbayar.IDTMNO');
        $this->db->select('tmp_cartbayar.QTY');
        $this->db->select('tmp_cartbayar.TOTTARIF');
        $this->db->select('y_tmno_radiologi.NAMA_TMNO_RADIOLOGI');
        $this->db->select('tmp_cartbayar.UID');
        $this->db->select('tmp_cartbayar.INSERTED_AT');
        $this->db->join('y_tmno_radiologi', 'tmp_cartbayar.IDTMNORAD = y_tmno_radiologi.ID_TMNO_RADIOLOGI', 'left');
        $this->db->where('tmp_cartbayar.IDTMNORAD is NOT NULL', NULL, FALSE);
        return $this->db->get_where('tmp_cartbayar', ['tmp_cartbayar.IP' => getRealIpAddr()])->result_array();
    }


    public function getListTindakanKeperawatanPasien($idxDaftar)
    {

        //$this->db->select('y_tmno_keperawatan.ID_TINDAKAN_KEPERAWATAN');
        $this->db->select('y_tmno_keperawatan.TINDAKAN');
        $this->db->select('y_tmno_keperawatan.ID_TMNO_KEPERAWATAN');
        // $this->db->select('y_tmno_keperawatan.TARIF');
        $this->db->select('y_tindakan_keperawatan.IDXDAFTAR');
        $this->db->select('y_tindakan_keperawatan.ID_TINDAKAN_KEPERAWATAN');
        //$this->db->select('y_tmno_keperawatan.BHP');
        //$this->db->select('y_tmno_keperawatan.ID_TMNO');
        $this->db->select('y_tindakan_keperawatan.QTY');
        $this->db->select('y_tindakan_keperawatan.TARIF');
        $this->db->select('y_tindakan_keperawatan.BHP');
        $this->db->join('y_tmno_keperawatan', 'y_tindakan_keperawatan.ID_TMNO_KEPERAWATAN = y_tmno_keperawatan.ID_TMNO_KEPERAWATAN', 'left');
        return $this->db->get_where('y_tindakan_keperawatan', ['y_tindakan_keperawatan.IDXDAFTAR' => $idxDaftar])->result_array();
    }


    public function getListLayananLaboratoriumPasien($idxDaftar)
    {

        $this->db->select('y_tmno_laboratorium.NAMA_TMNO_LABORATORIUM');
        $this->db->select('y_tindakan_laboratorium.ID_TMNO');

        $this->db->select('y_tindakan_laboratorium.IDXDAFTAR');
        $this->db->select('y_tindakan_laboratorium.ID_TINDAKAN_LABORATORIUM');



        $this->db->select('y_tindakan_laboratorium.TARIF_TMNO');
        $this->db->select('y_tindakan_laboratorium.BHP');
        $this->db->select('y_tindakan_laboratorium.JASA_SARANA');
        $this->db->join('y_tmno_laboratorium', 'y_tindakan_laboratorium.ID_TMNO = y_tmno_laboratorium.ID_TMNO_LABORATORIUM', 'left');
        return $this->db->get_where('y_tindakan_laboratorium', ['y_tindakan_laboratorium.IDXDAFTAR' => $idxDaftar])->result_array();
    }


    // public function simpanCartToBillTagihan()
    // {
    //     $inNOMR         = $this->input->post('nomr');
    //     $inSHIFT        = $this->input->post('shift');
    //     $inNIP          = $this->input->post('nip');
    //     $inIDXDAFTAR    = $this->input->post('idxdaftar');
    //     $inTANGGAL      = $this->input->post('tanggal');
    //     $inLUNAS        = $this->input->post('lunas');
    //     $inJMBAYAR      = $this->input->post('jambayar');
    //     $inIPnya        = $this->input->post('ip');
    //     $inCARABAYAR    = $this->input->post('kdcarabayar');
    //     $inPoly         = $this->input->post('poli');
    //     $inAPS          = $this->input->post('aps');
    //     $inUNIT         = $this->input->post('unit');

    //     $this->simpanKe_y_tindakan_diagnosa_tindakan();

    //     $query = "call simrs2012.pr_savebill_tindakanrajal_tmpdokter('" . $inNOMR . "',
    //                                                                 '" . $inSHIFT . "',
    //                                                                 '" . $inNIP . "',
    //                                                                 '" . $inIDXDAFTAR . "',
    //                                                                 '" . $inTANGGAL . "',
    //                                                                 '" . $inLUNAS . "',
    //                                                                 '" . $inJMBAYAR . "',
    //                                                                 '" . $inIPnya . "',
    //                                                                 '" . $inCARABAYAR . "',
    //                                                                 '" . $inPoly . "',
    //                                                                 '" .  $inAPS . "',
    //                                                                 '" . $inUNIT . "');";
    //     return $this->db->query($query)->result_array();
    // }
}
