<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien_model extends CI_Model
{

    //ambil data mahasiswa dari database
    function get_pasien_list($limit, $start)
    {

        $this->db->limit($limit, $start);
        $query = $this->db->get("m_pasien")->result_array();;
        return $query;


        //$query = $this->db->get('m_pasien', $limit, $start)->result_array();
        //return $query;

        // return $this->db->query($query)->result_array();
    }

    public function get_total()
    {
        return $this->db->count_all("m_pasien");
    }




    public function getLastNomr($param = 0)
    {
        $this->db->limit(1);
        $this->db->order_by('NOMR', 'DESC');
        $this->db->select('NOMR');
        $data =  $this->db->get('m_pasien');
        $row = $data->row();
        $dump =  $row->NOMR;
        $dddd = $dump + $param;

        $length = strlen($dddd);

        if ($dddd < 10) {
            $value = '00000' . $dddd;
        } else if ($dddd < 100) {
            $value = '0000' . $dddd;
        } else if ($dddd < 1000) {
            $value = '000' . $dddd;
        } else if ($dddd < 10000) {
            $value = '00' . $dddd;
        } else if ($dddd < 100000) {
            $value = '0' . $dddd;
        } else {
            $value = $dddd;
        }
        return    $value;
    }


    public function getDetailsPasien($nomr)
    {
        return $this->db->get_where('m_pasien', ['NOMR' => $nomr])->row_array();
    }

    public function getAllPasien()
    {
        return $this->db->get('m_pasien')->result_array();
    }

    public function getPasien($limit, $start, $nomr = null, $nama = null, $alamat = null, $ktp = null, $nokabpjs = null, $notelp = null, $tgllahir = null)
    {
        $this->db->cache_on();

        if ($nomr) {
            $this->db->where("NOMR", $nomr);
        }
        if ($nama) {
            $this->db->like("NAMA", $nama);
        }
        if ($alamat) {
            $this->db->like("ALAMAT", $alamat);
        }
        if ($ktp) {
            $this->db->where("NOKTP", $ktp);
        }
        if ($nokabpjs) {
            $this->db->where("NO_KARTU", $nokabpjs);
        }
        if ($notelp) {
            $this->db->where("NOTELP", $notelp);
        }
        if ($tgllahir) {
            // $dat =  "TGLLAHIR = '" . $tgllahir . "'";
            // $this->db->where($dat);

            $this->db->where("TGLLAHIR", $tgllahir);
        }


        $this->db->order_by('NOMR', 'DESC');
        return $this->db->get('m_pasien', $limit, $start)->result_array();
    }

    public function CountAllPasien()
    {
        return $this->db->get('m_pasien')->num_rows();
    }

    public function getBayiVK()
    {
        // $where = ['nama_lengkap_bayi' => NULL];
        
        return $this->db->get_where('simrs.vk_detail_kelahiran', ['nama_lengkap_bayi !=' => NULL, 'jenis_surat ' => "1"])->result_array();
        // $this->db->order_by("id_vk_detail_kelahiran", "desc");
        // return $query->result();
    }

    public function getBayiVKWhere($idbayi)
    {
        // $where = ['nama_lengkap_bayi' => NULL];
        
        // return $this->db->get_where('simrs.vk_detail_kelahiran', ['nama_lengkap_bayi !=' => NULL])->result_array();
        return $this->db->get_where('simrs.vk_detail_kelahiran', ['id_vk_detail_kelahiran' => $idbayi])->result_array();
        // $this->db->order_by("id_vk_detail_kelahiran", "desc");
        // return $query->result();
    }


    function getListPekerjaan()
    {

        $pekerjaan  = array(
            ['nama' => ' - '],
            ['nama' => 'BURUH'],
            ['nama' => 'BURUH HARIAN LEPAS'],
            ['nama' => 'DOKTER'],
            ['nama' => 'DOSEN'],
            ['nama' => 'GURU'],
            ['nama' => 'DPRD'],
            ['nama' => 'IBU RUMAH TANGGA'],
            ['nama' => 'KARYAWAN'],
            ['nama' => 'MAHASISWA'],
            ['nama' => 'NELAYAN'],
            ['nama' => 'NOTARIS/PPAT'],
            ['nama' => 'PPAT'],
            ['nama' => 'PELAJAR'],
            ['nama' => 'PENSIUNAN'],
            ['nama' => 'PERAWAT'],
            ['nama' => 'PERUMKA'],
            ['nama' => 'PETANI'],
            ['nama' => 'PNS'],
            ['nama' => 'POLRI'],
            ['nama' => 'TNI'],
            ['nama' => 'WIRASAWASTA'],
        );

        return $pekerjaan;
    }

    function getListHubungandenganPasien()
    {
        $hubungan = array(
            ['nama' => 'DIRI SENDIRI'],
            ['nama' => 'ISTRI'],
            ['nama' => 'ANAK'],
            ['nama' => 'SUAMI'],
            ['nama' => 'ORANG TUA'],
            ['nama' => 'SAUDARA LAINNYA']
        );

        return $hubungan;
    }

    function getJeniskelamin()
    {
        $jeniskelamin = $this->db->get_where('l_jeniskelamin')->result_array();

        return $jeniskelamin;
    }

    function getStatusPernikahan()
    {
        $pernikahan = $this->db->get_where('l_statusperkawin')->result_array();

        return $pernikahan;
    }

    function getPendidikan()
    {
        $pendidikan = $this->db->get_where('l_pendidikanterakhir')->result_array();

        return $pendidikan;
    }

    function getAgama()
    {
        $agama = $this->db->get_where('l_agama')->result_array();

        return $agama;
    }

    function simpanPasien($statuspasien)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $lastnomr = $this->db->get_where('m_maxnomr', ['id' => 1])->row_array();

        if ($statuspasien == 0) {

            $NOMR = $this->input->post('nomr');
            $this->db->set('TITLE', $this->input->post('cb_alias'));
            $this->db->set('NAMA', addslashes(str_replace(',', ' ', $this->input->post('tx_nama')) . ', ' . $this->input->post('cb_alias')));
            $this->db->set('IBUKANDUNG', addslashes($this->input->post('tx_namaibu')));
            $this->db->set('TEMPAT', addslashes($this->input->post('ttl')));
            $this->db->set('TGLLAHIR', date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgllahir')))));
            $this->db->set('JENISKELAMIN', $this->input->post('rb_Jeniskelamin'));
            $this->db->set('ALAMAT', addslashes($this->input->post('alamatktp')));
            $this->db->set('KELURAHAN', $this->input->post('cb_kelurahan'));
            $this->db->set('KDKECAMATAN', $this->input->post('cb_kecamatan'));
            $this->db->set('KOTA', $this->input->post('cb_kabupaten'));
            $this->db->set('KDPROVINSI', $this->input->post('cbProvinsi'));
            $this->db->set('NOTELP', $this->input->post('tx_notelepon'));
            $this->db->set('NOKTP', $this->input->post('noktp'));
            $this->db->set('PEKERJAAN', $this->input->post('cb_pekerjaan'));
            $this->db->set('STATUS', $this->input->post('rb_statuspernikahan'));
            $this->db->set('AGAMA', $this->input->post('rb_Agama'));
            $this->db->set('PENDIDIKAN', $this->input->post('rb_Pendidikanterakhir'));


            if ($this->input->post('rbParentCarabayar') > 1) {
                $this->db->set('KDCARABAYAR', $this->input->post('cb_carabayar'));
            } else {
                $this->db->set('KDCARABAYAR', 1);
            }

            // TIME DAN PETUGAS YANG MERUBAH BELUM DISET 
            // $data["NIP"]           = $user["firstname"];

            // $this->db->set('ALAMAT_KTP', addslashes($this->input->post('alamatktplama')));
            $this->db->set('ALAMAT_KTP', addslashes($this->input->post('alamatktp')));
            $this->db->set('PENANGGUNGJAWAB_NAMA', addslashes($this->input->post('tx_namapenanggungjawab')));
            $this->db->set('PENANGGUNGJAWAB_HUBUNGAN', $this->input->post('cb_hubungan'));
            $this->db->set('PENANGGUNGJAWAB_ALAMAT', addslashes($this->input->post('tx_alamatpenanggungjawab')));
            $this->db->set('PENANGGUNGJAWAB_PHONE', $this->input->post('tx_notel_penanggungjawab'));


            $this->db->set('NO_KARTU', $this->input->post('nokabpjs'));
            // $data['tgllahir']
            $this->db->set('JNS_PASIEN', $this->input->post('rbjenispasienbpjs'));
            $this->db->set('nama_ayah', addslashes($this->input->post('tx_namaayah')));
            $this->db->set('nama_ibu', addslashes($this->input->post('tx_namaibu')));
            $this->db->set('nama_suami', addslashes($this->input->post('tx_namasuami')));
            $this->db->set('nama_istri', addslashes($this->input->post('tx_namaistri')));
            $this->db->set('KD_ETNIS', $this->input->post('cb_etnis'));
            $this->db->set('KD_BHS_HARIAN', $this->input->post('cb_bahasaharian'));


            $this->db->where('NOMR', $NOMR);
            $this->db->update('m_pasien');
            // UPDATE DATA PASIEN


        } else if ($statuspasien == 1) {
            // CEK 
            $new_nomr = $this->setNewNORM();
            $existing_nomr = $this->getDetailsPasien($new_nomr);
            if ($existing_nomr) {
                // JIKA SUDA ADA NO RM TSB
                $NOMR = null; // MASI BELUM TAU MAU DI APAIN
            } else {
                // JIKA BELUM ADA NO RM
                $NOMR = $new_nomr;
            }


            if ($NOMR) {
                $data["NOMR"]          = $NOMR;
                $data["TITLE"]           = $this->input->post('cb_alias');
                $data["NAMA"]           = addslashes(str_replace(',', ' ', $this->input->post('tx_nama')) . ', ' . $this->input->post('cb_alias'));
                $data["IBUKANDUNG"]           = $this->input->post('tx_namaibu');
                $data["TEMPAT"]           = addslashes($this->input->post('ttl'));
                $data["TGLLAHIR"]           = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgllahir'))));
                $data["JENISKELAMIN"]           = $this->input->post('rb_Jeniskelamin');
                $data["ALAMAT"]           = addslashes($this->input->post('alamatktp'));
                $data["KELURAHAN"]           = $this->input->post('cb_kelurahan');
                $data["KDKECAMATAN"]           = $this->input->post('cb_kecamatan');
                $data["KOTA"]           = $this->input->post('cb_kabupaten');
                $data["KDPROVINSI"]           = $this->input->post('cbProvinsi');
                $data["NOTELP"]           = $this->input->post('tx_notelepon');
                $data["NOKTP"]           = $this->input->post('noktp');
                //$data["SUAMI_ORTU"]           = $this->input->post('tx_nama');
                $data["PEKERJAAN"]           = $this->input->post('cb_pekerjaan');
                $data["STATUS"]           = $this->input->post('rb_statuspernikahan');
                $data["AGAMA"]           = $this->input->post('rb_Agama');
                $data["PENDIDIKAN"]           = $this->input->post('rb_Pendidikanterakhir');

                if ($this->input->post('rbParentCarabayar') > 1) {
                    $data["KDCARABAYAR"]           = $this->input->post('cb_carabayar');
                } else {
                    $data["KDCARABAYAR"]           = 1;
                }

                $data["NIP"]           = $user["firstname"];
                $data["TGLDAFTAR"]           = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dtp_tanggal_daftar'))));
                $data["ALAMAT_KTP"]           = addslashes($this->input->post('alamatktplama'));

                // CEK BAYI DULU 
                if ($this->input->post('cb_alias') == 'By') {
                    $data["PARENT_NOMR"]           =  $NOMR;
                }

                $data["PENANGGUNGJAWAB_NAMA"]           = addslashes($this->input->post('tx_namapenanggungjawab'));
                $data["PENANGGUNGJAWAB_HUBUNGAN"]           = $this->input->post('cb_hubungan');
                $data["PENANGGUNGJAWAB_ALAMAT"]           = addslashes($this->input->post('tx_alamatpenanggungjawab'));
                $data["PENANGGUNGJAWAB_PHONE"]           = $this->input->post('tx_notel_penanggungjawab');
                $data["NOMR_LAMA"]           = $NOMR;
                $data["NO_KARTU"]           = $this->input->post('nokabpjs');
                $data["JNS_PASIEN"]           = $this->input->post('rbjenispasienbpjs');
                $data["nama_ayah"]           = addslashes($this->input->post('tx_namaayah'));
                $data["nama_ibu"]           = addslashes($this->input->post('tx_namaibu'));
                $data["nama_suami"]           = addslashes($this->input->post('tx_namasuami'));
                $data["nama_istri"]           = addslashes($this->input->post('tx_namaistri'));
                $data["KD_ETNIS"]           = $this->input->post('cb_etnis');
                $data["KD_BHS_HARIAN"]           = $this->input->post('cb_bahasaharian');
                //$data["NOKK"]           = $this->input->post('tx_nama');

                $this->db->insert('m_pasien', $data);
            }



            if ($lastnomr) {
                $this->UpdateMaxNomr($NOMR);
            } else {
                $this->setMaxNomr($NOMR);
            }
        }



        return $NOMR;
    }

    function ubahprofilepasien()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $NOMR = $this->input->post('nomr');

        $this->db->set('TITLE', $this->input->post('cb_alias'));
        $this->db->set('NAMA', addslashes(str_replace(',', ' ', $this->input->post('tx_nama')) . ', ' . $this->input->post('cb_alias')));
        $this->db->set('NOKTP', $this->input->post('noktp'));

        $this->db->set('TEMPAT', addslashes($this->input->post('ttl')));
        $this->db->set('TGLLAHIR', date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgllahir')))));
        $this->db->set('ALAMAT', addslashes($this->input->post('alamatktp')));
        $this->db->set('ALAMAT_KTP', addslashes($this->input->post('alamatktplama')));
        $this->db->set('JENISKELAMIN', addslashes($this->input->post('rb_Jeniskelamin')));

        $this->db->set('KDPROVINSI', addslashes($this->input->post('cbProvinsi')));
        $this->db->set('KOTA', addslashes($this->input->post('cb_kabupaten')));
        $this->db->set('KDKECAMATAN', addslashes($this->input->post('cb_kecamatan')));
        $this->db->set('KELURAHAN', addslashes($this->input->post('cb_kelurahan')));

        $this->db->set('NOTELP', addslashes($this->input->post('tx_notelepon')));

        $this->db->set('SUAMI_ORTU', addslashes($this->input->post('tx_namaayah')));
        $this->db->set('PEKERJAAN', addslashes($this->input->post('cb_pekerjaan')));
        $this->db->set('STATUS', addslashes($this->input->post('rb_statuspernikahan')));
        $this->db->set('AGAMA', addslashes($this->input->post('rb_Agama')));
        $this->db->set('PENDIDIKAN', addslashes($this->input->post('rb_Pendidikanterakhir')));

        $this->db->set('nama_ayah', addslashes($this->input->post('tx_namaayah')));
        $this->db->set('nama_ibu', addslashes($this->input->post('tx_namaibu')));
        $this->db->set('IBUKANDUNG', addslashes($this->input->post('tx_namaibu')));
        $this->db->set('nama_suami', addslashes($this->input->post('tx_namasuami')));
        $this->db->set('nama_istri', addslashes($this->input->post('tx_namaistri')));

        $this->db->set('KD_ETNIS', addslashes($this->input->post('cb_etnis')));
        $this->db->set('KD_BHS_HARIAN', addslashes($this->input->post('cb_bahasaharian')));
        $this->db->set('NO_KARTU', addslashes($this->input->post('tx_noka_bpjs')));
        $this->db->set('NOKK', addslashes($this->input->post('tx_nokk')));

        $this->db->where('NOMR', $NOMR);

        $this->db->update('m_pasien');
        return $this->db->affected_rows();
    }



    function maxnomr()
    {
        $maxnomr = $this->db->get_where('m_maxnomr', ['id' => 1])->row_array();
        return   $maxnomr["nomor"];
    }

    function UpdateMaxNomr($nomr)
    {
        $this->db->set('nomor', $nomr);
        $this->db->where('id', 1);
        $this->db->update('m_maxnomr');
    }
    function setMaxNomr($nomr)
    {

        $data_lastnomr = ['nomor' => $nomr];
        $this->db->insert('m_maxnomr', $data_lastnomr);
    }

    function lastnomr()
    {
        $this->db->limit(1);
        $this->db->order_by('NOMR', 'DESC');
        $this->db->select('NOMR');
        $data =  $this->db->get('m_pasien')->row_array();
        return $data["NOMR"];
    }

    function setNewNORM()
    {

        $last = $this->lastnomr();
        $new = ++$last;

        // $length = strlen($dddd);

        if ($new < 10) {
            $value = '00000' . $new;
        } else if ($new < 100) {
            $value = '0000' . $new;
        } else if ($new < 1000) {
            $value = '000' . $new;
        } else if ($new < 10000) {
            $value = '00' . $new;
        } else if ($new < 100000) {
            $value = '0' . $new;
        } else {
            $value = $new;
        }


        return    $value;
    }

    public function getPasienDetail($nomr)
    {
        $this->db->select('m_pasien.NOMR');
        $this->db->select('m_pasien.NAMA');
        $this->db->select('m_pasien.TITLE');
        $this->db->select('m_pasien.IBUKANDUNG');
        $this->db->select('m_pasien.TEMPAT');
        $this->db->select('m_pasien.TGLLAHIR');
        $this->db->select('m_pasien.JENISKELAMIN');
        $this->db->select('m_pasien.ALAMAT');
        $this->db->select('m_pasien.KELURAHAN');
        $this->db->select('m_pasien.KDKECAMATAN');
        $this->db->select('m_pasien.KOTA');
        $this->db->select('m_pasien.KDPROVINSI');
        $this->db->select('m_pasien.NOTELP');
        $this->db->select('m_pasien.NOKTP');
        $this->db->select('m_pasien.PEKERJAAN');
        $this->db->select('m_pasien.STATUS');
        $this->db->select('m_pasien.AGAMA');
        $this->db->select('m_pasien.PENDIDIKAN');
        $this->db->select('m_pasien.ALAMAT_KTP');
        $this->db->select('m_pasien.NO_KARTU');
        $this->db->select('m_pasien.JNS_PASIEN');
        $this->db->select('m_pasien.nama_ayah');
        $this->db->select('m_pasien.nama_ibu');
        $this->db->select('m_pasien.nama_suami');
        $this->db->select('m_pasien.nama_istri');
        $this->db->select('m_pasien.KD_ETNIS');
        $this->db->select('m_pasien.KD_BHS_HARIAN');
        $this->db->select('m_pasien.PENANGGUNGJAWAB_NAMA');
        $this->db->select('m_pasien.PENANGGUNGJAWAB_HUBUNGAN');
        $this->db->select('m_pasien.PENANGGUNGJAWAB_ALAMAT');
        $this->db->select('m_pasien.PENANGGUNGJAWAB_PHONE');

        $pasiendetail =  $this->db->get_where('m_pasien', ['m_pasien.NOMR' => $nomr])->row_array();
        if ($pasiendetail) {
            $nama    = explode(',', str_replace('.', ' ', $pasiendetail["NAMA"]));

            $result["NOMR"] = $pasiendetail["NOMR"];
            $result["NAMA"] = $nama[0];
            $result["TITLE"] = $pasiendetail["TITLE"];
            $result["IBUKANDUNG"] = $pasiendetail["IBUKANDUNG"];
            $result["TEMPAT"] = $pasiendetail["TEMPAT"];
            $result["TGLLAHIR"] = $pasiendetail["TGLLAHIR"];
            $result["JENISKELAMIN"] = $pasiendetail["JENISKELAMIN"];
            $result["ALAMAT"] = $pasiendetail["ALAMAT"];
            $result["KELURAHAN"] = $pasiendetail["KELURAHAN"];
            $result["KDKECAMATAN"] = $pasiendetail["KDKECAMATAN"];
            $result["KOTA"] = $pasiendetail["KOTA"];
            $result["KDPROVINSI"] = $pasiendetail["KDPROVINSI"];
            $result["NOTELP"] = $pasiendetail["NOTELP"];
            $result["NOKTP"] = $pasiendetail["NOKTP"];
            $result["PEKERJAAN"] = $pasiendetail["PEKERJAAN"];
            $result["STATUS"] = $pasiendetail["STATUS"];
            $result["AGAMA"] = $pasiendetail["AGAMA"];
            $result["PENDIDIKAN"] = $pasiendetail["PENDIDIKAN"];
            $result["ALAMAT_KTP"] = $pasiendetail["ALAMAT_KTP"];
            $result["NO_KARTU"] = $pasiendetail["NO_KARTU"];
            $result["JNS_PASIEN"] = $pasiendetail["JNS_PASIEN"];
            $result["nama_ayah"] = $pasiendetail["nama_ayah"];
            $result["nama_ibu"] = $pasiendetail["nama_ibu"];
            $result["nama_suami"] = $pasiendetail["nama_suami"];
            $result["nama_istri"] = $pasiendetail["nama_istri"];
            $result["KD_ETNIS"] = $pasiendetail["KD_ETNIS"];
            $result["KD_BHS_HARIAN"] = $pasiendetail["KD_BHS_HARIAN"];
            $result["PENANGGUNGJAWAB_NAMA"] = $pasiendetail["PENANGGUNGJAWAB_NAMA"];
            $result["PENANGGUNGJAWAB_HUBUNGAN"] = $pasiendetail["PENANGGUNGJAWAB_HUBUNGAN"];
            $result["PENANGGUNGJAWAB_ALAMAT"] = $pasiendetail["PENANGGUNGJAWAB_ALAMAT"];
            $result["PENANGGUNGJAWAB_PHONE"] = $pasiendetail["PENANGGUNGJAWAB_PHONE"];
        } else {
            $result = null;
        }



        return $result;
    }

    function updateBPJSMembershipNumber($nomr)
    {

        $noPeserta = $this->input->post('tx_susulannokepesertaan_bpjs');
        if ($noPeserta) {
            $this->db->set('NO_KARTU',  $noPeserta);
            $this->db->where('NOMR', $nomr);
            $this->db->update('m_pasien');
            return $this->db->affected_rows();
        }
    }

    public function saveToPasien($input){
        $this->db->set('NO_KARTU',  $input['noka']);
        $this->db->where('NOMR',  $input['nomr']);
        $this->db->update('m_pasien');
        return $this->db->affected_rows();
    }
}
