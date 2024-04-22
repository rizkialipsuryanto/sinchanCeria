 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Anjungan_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
        }
    

        public function getBookingCodeDetails($bookingcode)
        {
            // $this->db->join('t_pendaftaran_android', 't_pendaftaran_android.bookingcode = t_pendaftaran.bookingcode', 'left outer');
            // return $this->db->get_where('t_pendaftaran', [
            //     'bookingcode' => $bookingcode["boardingcode"]
            // ])->result_array();

            $this->db->select('t_pendaftaran.*');
            $this->db->select('t_pendaftaran_android.*');
            $this->db->where("t_pendaftaran.bookingcode", $bookingcode["boardingcode"]);
            $this->db->where("t_pendaftaran.KDCARABAYAR !=", '1');
            $this->db->join('t_pendaftaran_android', 't_pendaftaran_android.bookingcode = t_pendaftaran.bookingcode', 'left outer');
            return $this->db->get('t_pendaftaran')->result_array();
        }


        public function getBookingDetailsByID($id)
        {
            return $this->db->get_where('t_pendaftaran_android', [
                'id' => $id
            ])->row_array();
        }


        public function cancelBooking($id)
        {
            $data = $this->getBookingDetailsByID($id);
            if ($data) {
                $this->db->set('isCancel', 1);
                $this->db->where('id', $id);
                $this->db->update('t_pendaftaran_android');
                $result = $this->db->affected_rows();
                return $result;
            }
        }


        public function listPatient()
        {

            $sql_query=$this->db->query("call simrs2012.sp_listPendaftaranMobile()");                     
            mysqli_next_result( $this->db->conn_id);
                if($sql_query->num_rows()>0){
                    return $sql_query->result_array();
                }
        }
		
		public function listPatientNew($limit, $start, $keyword = null, $poli = null, $tanggalcari = null, $batal = null)
        {
            date_default_timezone_set('Asia/Jakarta');
            $this->db->select("t_pendaftaran_android.id,
                                t_pendaftaran_android.id,
                                CASE
                                    WHEN t_pendaftaran_android.pasienbaru = 1 THEN 'PASIEN BARU'
                                    WHEN t_pendaftaran_android.pasienbaru = 2 THEN 'PASIEN LAMA'
                                    ELSE '-'
                                END as pasienbaru,

                                t_pendaftaran_android.nomr,
                                UPPER(t_pendaftaran_android.nama_title) as nama_title,
                                UPPER(t_pendaftaran_android.nama) as nama,
                                t_pendaftaran_android.tanggal,
                                t_pendaftaran_android.poliklinik as poli_id,
                                t_pendaftaran_android.dokter as dokter_id,
                                t_pendaftaran_android.hubungan,
                                t_pendaftaran_android.tgl_lahir,
                                t_pendaftaran_android.notelp,
                                t_pendaftaran_android.email,
                                from_unixtime(t_pendaftaran_android.date_created,'%Y-%m-%d %h:%i:%s') as date_created,
                                t_pendaftaran_android.bookingcode,
                                t_pendaftaran_android.bookingcode,
                                t_pendaftaran_android.nobpjs,
                                UPPER(t_pendaftaran_android.alamat_sesuai_ktp) as alamat_sesuai_ktp,
                                t_pendaftaran_android.norujukan,
                                UPPER(t_pendaftaran_android.nik) as nik,
                                UPPER(t_pendaftaran_android.jenis_kelamin) as jenis_kelamin,
                                UPPER(t_pendaftaran_android.tempat_lahir) as tempat_lahir,
                                UPPER(t_pendaftaran_android.nama_ayah) as nama_ayah,
                                UPPER(t_pendaftaran_android.nama_ibu) as nama_ibu,
                                UPPER(t_pendaftaran_android.nama_suami) as nama_suami,
                                UPPER(t_pendaftaran_android.nama_istri) as nama_istri,
                                t_pendaftaran_android.pekerjaan_id as pekerjaan,
                                CASE
                                    WHEN t_pendaftaran_android.isBoarded = 0 THEN 'BELUM'
                                    WHEN t_pendaftaran_android.isBoarded = 1 THEN 'SUDAH BOARDING'
                                    ELSE '-'
                                END as isBoarded,
                                CASE
                                    WHEN t_pendaftaran_android.isCancel = 0 THEN '-'
                                    WHEN t_pendaftaran_android.isCancel = 1 THEN 'BATAL'
                                    ELSE '-'
                                END as isCancel");
            $this->db->select("m_poly.nama as poliklinik");
            $this->db->select("UPPER(m_dokter.NAMADOKTER) as namadokter");
            $this->db->select("m_carabayar.nama as penjamin");
            $this->db->select('UPPER(CONCAT(user.firstname, " ",user.firstname)) as userid, user.email as email_user');
            $this->db->select("UPPER(m_kelurahan.namakelurahan) as namakelurahan");
            $this->db->select("UPPER(m_kecamatan.namakecamatan) as namakecamatan");
            $this->db->select("UPPER(m_kota.namakota) as namakota");
            $this->db->select("UPPER(m_provinsi.namaprovinsi) as namaprovinsi");
            $this->db->select("UPPER(l_agama.agama) as agama");
            $this->db->select("UPPER(l_pendidikanterakhir.pendidikan) as pendidikan");
            $this->db->select("UPPER(l_statusperkawin.statusperkawinan) as statusperkawinan");
            $this->db->select("UPPER(m_etnis.nama_etnis) as nama_etnis");
            $this->db->select("UPPER(m_bahasa_harian.bahasa_harian) as bahasa_harian");

            if ($keyword) {
                $where = "(t_pendaftaran_android.nama LIKE '%" . $keyword . "%')";
                $this->db->where($where, NULL, FALSE);
            }
            if ($poli) {
                $this->db->where("t_pendaftaran_android.poliklinik", $poli);
            }
            if ($tanggalcari) {
                $where = "substring(t_pendaftaran_android.tanggal, 1, 10) = '". $tanggalcari ."'";
                $this->db->where($where, NULL, FALSE);
            }
            // if ($dokter) {
            //     $this->db->where("t_pendaftaran_android.dokter", $dokter);
            // }
            $this->db->order_by('t_pendaftaran_android.id', 'DESC');
            $this->db->limit($limit, $start);
            $this->db->join('m_poly', 'm_poly.kode = t_pendaftaran_android.poliklinik', 'left outer');
            $this->db->join('m_dokter', 'm_dokter.KDDOKTER = t_pendaftaran_android.dokter', 'left outer');
            $this->db->join('m_carabayar', 'm_carabayar.kode = t_pendaftaran_android.penjamin', 'left outer');
            $this->db->join('user', 'user.id = t_pendaftaran_android.userid', 'left outer');
            $this->db->join('m_provinsi', 'm_provinsi.idprovinsi = t_pendaftaran_android.provinsi_id', 'left outer');
            $this->db->join('m_kota', 'm_kota.idkota = t_pendaftaran_android.kabupaten_id', 'left outer');

            $this->db->join('m_kecamatan', 'm_kecamatan.idkecamatan = t_pendaftaran_android.kecamatan_id', 'left outer');
            $this->db->join('m_kelurahan', 'm_kelurahan.idkelurahan = t_pendaftaran_android.kelurahan_id', 'left outer');
            $this->db->join('l_agama', 'l_agama.id = t_pendaftaran_android.agama_id', 'left outer');
            $this->db->join('l_pendidikanterakhir', 'l_pendidikanterakhir.id = t_pendaftaran_android.pendidikan_id', 'left outer');
            $this->db->join('l_statusperkawin', 'l_statusperkawin.id = t_pendaftaran_android.status_kawin_id', 'left outer');
            $this->db->join('m_etnis', 'm_etnis.id = t_pendaftaran_android.suku', 'left outer');
            $this->db->join('m_bahasa_harian', 'm_bahasa_harian.id = t_pendaftaran_android.bahasa_daerah', 'left outer');

            return $this->db->get('t_pendaftaran_android')->result_array();
        }
		
        public function listPatient2()
        {
            return $this->listPatient();
        }

        public function getData($bookingcode)
        {
            $this->db->select('t_pendaftaran_android.id as `ID`');
            $this->db->select('t_pendaftaran_android.pasienbaru as `PASIENBARU`');
            $this->db->select('t_pendaftaran_android.nomr as `NOMR`');
            $this->db->select('t_pendaftaran_android.nama_title as `TITLE`');
            $this->db->select('t_pendaftaran_android.tanggal as `TANGGAL`');
            $this->db->select('t_pendaftaran_android.poliklinik as `POLIKLINIK`');
            $this->db->select('t_pendaftaran_android.dokter as `DOKTER`');
            $this->db->select('t_pendaftaran_android.tgl_lahir as `TGLLAHIR`');
            $this->db->select('t_pendaftaran_android.notelp as `NOTELP`');
            $this->db->select('t_pendaftaran_android.email as `EMAIL`');
            $this->db->select('t_pendaftaran_android.userid as `USERID`');
            $this->db->select('t_pendaftaran_android.bookingcode as `BOOKINGCODE`');
            $this->db->select('t_pendaftaran_android.penjamin as `CARABAYAR`');
            $this->db->select('t_pendaftaran_android.nobpjs as `NOBPJS`');
            $this->db->select('t_pendaftaran_android.norujukan as `NORUJUKAN`');
            $this->db->select('t_pendaftaran_android.nama as `NAMA`');
            $this->db->select('t_pendaftaran_android.nik as `NOKTP`');
            $this->db->select('t_pendaftaran_android.jenis_kelamin as `JENISKELAMIN`');
            $this->db->select('t_pendaftaran_android.tempat_lahir as `TEMPAT`');
            $this->db->select('t_pendaftaran_android.alamat_sesuai_ktp as `ALAMATKTP`');
            $this->db->select('t_pendaftaran_android.provinsi_id as `PROVINSI`');
            $this->db->select('t_pendaftaran_android.kabupaten_id as `KABUPATEN`');
            $this->db->select('t_pendaftaran_android.kecamatan_id as `KECAMATAN`');
            $this->db->select('t_pendaftaran_android.kelurahan_id as `KELURAHAN`');
            $this->db->select('t_pendaftaran_android.nama_ayah as `NAMAAYAH`');
            $this->db->select('t_pendaftaran_android.nama_ibu as `NAMAIBU`');
            $this->db->select('t_pendaftaran_android.nama_suami as `NAMASUAMI`');
            $this->db->select('t_pendaftaran_android.nama_istri as `NAMAISTRI`');
            $this->db->select('t_pendaftaran_android.agama_id as `AGAMA`');
            $this->db->select('t_pendaftaran_android.pendidikan_id as `PENDIDIKAN`');
            $this->db->select('t_pendaftaran_android.pekerjaan_id as `PEKERJAAN`');
            $this->db->select('t_pendaftaran_android.status_kawin_id as `MARITAL`');
            $this->db->select('t_pendaftaran_android.suku as `SUKU`');
            $this->db->select('t_pendaftaran_android.bahasa_daerah as `BAHASADAERAH`');
            $this->db->select('t_pendaftaran_android.hubungan as `HUBUNGANDENGANPASIEN`');



            return $this->db->get_where('t_pendaftaran_android', ['bookingcode' => $bookingcode])->row_array();
        }

        public function getAnjunganList($limit, $start, $keyword = null, $batal = null)
        {
            date_default_timezone_set('Asia/Jakarta');
            $this->db->select('t_pendaftaran_android.id as `ID`');
            $this->db->select('t_pendaftaran_android.pasienbaru as `PASIENBARU`');
            $this->db->select('t_pendaftaran_android.nomr as `NOMR`');
            $this->db->select('t_pendaftaran_android.nama_title as `TITLE`');
            $this->db->select('t_pendaftaran_android.tanggal as `TANGGAL`');
            $this->db->select('t_pendaftaran_android.poliklinik as `POLIKLINIK`');
            $this->db->select('t_pendaftaran_android.dokter as `DOKTER`');
            $this->db->select('t_pendaftaran_android.tgl_lahir as `TGLLAHIR`');
            $this->db->select('t_pendaftaran_android.notelp as `NOTELP`');
            $this->db->select('t_pendaftaran_android.email as `EMAIL`');
            $this->db->select('t_pendaftaran_android.userid as `USERID`');
            $this->db->select('t_pendaftaran_android.bookingcode as `BOOKINGCODE`');
            $this->db->select('t_pendaftaran_android.penjamin as `CARABAYAR`');
            $this->db->select('t_pendaftaran_android.nobpjs as `NOBPJS`');
            $this->db->select('t_pendaftaran_android.norujukan as `NORUJUKAN`');
            $this->db->select('t_pendaftaran_android.nama as `NAMA`');
            $this->db->select('t_pendaftaran_android.nik as `NOKTP`');
            $this->db->select('t_pendaftaran_android.jenis_kelamin as `JENISKELAMIN`');
            $this->db->select('t_pendaftaran_android.tempat_lahir as `TEMPAT`');
            $this->db->select('t_pendaftaran_android.alamat_sesuai_ktp as `ALAMATKTP`');
            $this->db->select('t_pendaftaran_android.provinsi_id as `PROVINSI`');
            $this->db->select('t_pendaftaran_android.kabupaten_id as `KABUPATEN`');
            $this->db->select('t_pendaftaran_android.kecamatan_id as `KECAMATAN`');
            $this->db->select('t_pendaftaran_android.kelurahan_id as `KELURAHAN`');
            $this->db->select('t_pendaftaran_android.nama_ayah as `NAMAAYAH`');
            $this->db->select('t_pendaftaran_android.nama_ibu as `NAMAIBU`');
            $this->db->select('t_pendaftaran_android.nama_suami as `NAMASUAMI`');
            $this->db->select('t_pendaftaran_android.nama_istri as `NAMAISTRI`');
            $this->db->select('t_pendaftaran_android.agama_id as `AGAMA`');
            $this->db->select('t_pendaftaran_android.pendidikan_id as `PENDIDIKAN`');
            $this->db->select('t_pendaftaran_android.pekerjaan_id as `PEKERJAAN`');
            $this->db->select('t_pendaftaran_android.status_kawin_id as `MARITAL`');
            $this->db->select('t_pendaftaran_android.suku as `SUKU`');
            $this->db->select('t_pendaftaran_android.bahasa_daerah as `BAHASADAERAH`');
            $this->db->select('t_pendaftaran_android.hubungan as `HUBUNGANDENGANPASIEN`');
            $this->db->select('t_pendaftaran_android.isActive as `ACTIVE`');

            if ($keyword) {
                $where = "(t_pendaftaran_android.nik LIKE '%" . $keyword . "%' or t_pendaftaran_android.bookingcode LIKE '%" . $keyword . "%')";
                $this->db->where($where, NULL, FALSE);
            }

            $this->db->limit($limit, $start);
            return $this->db->get('t_pendaftaran_android')->result_array();
            // return $this->db->get('m_alat_cssd')->result_array();
        }

        public function getDetailPasienByFlagPasienBaru($data)
        {
            $isPasienbaru = $data["PASIENBARU"];

            if ($isPasienbaru == '0') {
                $details = $this->getDetailPasienByNorm($data["NOMR"]);
            } elseif ($isPasienbaru == '1') {
                $details = $this->getData($data["BOOKINGCODE"]);
            } else {
                $details = ['flag' => 'ded'];
            }

            return $details;
        }

        public function getPatient($limit, $start, $keyword = null, $batal = null)
        {
            $this->db->select('m_pasien.NOMR as `NOMR`');
            $this->db->select('m_pasien.TITLE as `TITLE`');
            $this->db->select('m_pasien.TEMPAT as `TEMPAT`');
            $this->db->select('m_pasien.TGLLAHIR as `TGLLAHIR`');
            $this->db->select('m_pasien.NOTELP as `NOTELP`');
            $this->db->select('m_pasien.NO_KARTU as `NOBPJS`');
            $this->db->select('m_pasien.NAMA as `NAMA`');
            $this->db->select('m_pasien.NOKTP as `NOKTP`');
            $this->db->select('m_pasien.JENISKELAMIN as `JENISKELAMIN`');
            $this->db->select('m_pasien.ALAMAT as `ALAMATKTP`');
            $this->db->select('m_pasien.JENISKELAMIN as `JENISKELAMIN`');
            $this->db->order_by('m_pasien.id', 'DESC');

            if ($keyword) {
                $where = "m_pasien.NOMR LIKE '%" . $keyword . "%'";
                $this->db->where($where, NULL, FALSE);
            }

            $this->db->limit($limit, $start);
            return $this->db->get('m_pasien')->result_array();
        }

        public function getDetailPasienByNorm($nomr)
        {

            // return $this->db->get_where('m_pasien', ['NOMR' => $nomr])->row_array();
            //  $this->db->select('t_pendaftaran_android.pasienbaru as `PASIENBARU`');
            $this->db->select('m_pasien.NOMR as `NOMR`');
            $this->db->select('m_pasien.TITLE as `TITLE`');
            // $this->db->select('m_pasien.TITLE as `NOMR`');
            // $this->db->select('m_pasien.tanggal as `TANGGAL`');
            // $this->db->select('m_pasien.poliklinik as `POLIKLINIK`');
            // $this->db->select('m_pasien.dokter as `DOKTER`');
            $this->db->select('m_pasien.TGLLAHIR as `TGLLAHIR`');
            $this->db->select('m_pasien.NOTELP as `NOTELP`');
            // $this->db->select('m_pasien.email as `EMAIL`');

            // $this->db->select('m_pasien.bookingcode as `BOOKINGCODE`');
            // $this->db->select('m_pasien.penjamin as `CARABAYAR`');
            $this->db->select('m_pasien.NO_KARTU as `NOBPJS`');
            // $this->db->select('m_pasien.norujukan as `NORUJUKAN`');
            $this->db->select('m_pasien.NAMA as `NAMA`');
            $this->db->select('m_pasien.NOKTP as `NOKTP`');
            $this->db->select('m_pasien.JENISKELAMIN as `JENISKELAMIN`');
            $this->db->select('m_pasien.ALAMAT as `ALAMATKTP`');
            $this->db->select('m_pasien.KDPROVINSI as `PROVINSI`');
            $this->db->select('m_pasien.KOTA as `KABUPATEN`');
            $this->db->select('m_pasien.KDKECAMATAN as `KECAMATAN`');
            $this->db->select('m_pasien.KELURAHAN as `KELURAHAN`');
            $this->db->select('m_pasien.nama_ayah as `NAMAAYAH`');
            $this->db->select('m_pasien.nama_ibu as `NAMAIBU`');
            $this->db->select('m_pasien.nama_suami as `NAMASUAMI`');
            $this->db->select('m_pasien.nama_istri as `NAMAISTRI`');
            $this->db->select('m_pasien.AGAMA as `AGAMA`');
            $this->db->select('m_pasien.PENDIDIKAN as `PENDIDIKAN`');
            $this->db->select('m_pasien.PEKERJAAN as `PEKERJAAN`');
            $this->db->select('m_pasien.STATUS as `MARITAL`');
            $this->db->select('m_pasien.KD_ETNIS as `SUKU`');
            $this->db->select('m_pasien.KD_BHS_HARIAN as `BAHASADAERAH`');
            // $this->db->select('m_pasien.hubungan as `HUBUNGANDENGANPASIEN`');
            return $this->db->get_where('m_pasien', ['NOMR' => $nomr])->row_array();
        }


        function simpanPasien($statuspasien)
        {
            date_default_timezone_set('Asia/Jakarta');
            // $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $lastnomr = $this->db->get_where('m_maxnomr', ['id' => 1])->row_array();

            if ($statuspasien["PASIENBARU"] == 0) {

                // print_r($statuspasien["PASIENBARU"]);
                $NOMR = $statuspasien["NOMR"];
                // $detailpasiendong = $this->getDetailPasienByNorm($NOMR);
                // $this->db->set('TITLE', $statuspasien["NOMR"]);
                // $this->db->set('NAMA', addslashes(str_replace(',', ' ', $detailpasiendong["NAMA"]) . ', ' .  $statuspasien["TITLE"]));
                // $this->db->set('IBUKANDUNG', addslashes($this->input->post('tx_namaibu')));
                // $this->db->set('TEMPAT', addslashes($this->input->post('ttl')));
                // $this->db->set('TGLLAHIR', date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('tgllahir')))));
                // $this->db->set('JENISKELAMIN', $this->input->post('rb_Jeniskelamin'));
                // $this->db->set('ALAMAT', addslashes($this->input->post('alamatktp')));
                // $this->db->set('KELURAHAN', $this->input->post('cb_kelurahan'));
                // $this->db->set('KDKECAMATAN', $this->input->post('cb_kecamatan'));
                // $this->db->set('KOTA', $this->input->post('cb_kabupaten'));
                // $this->db->set('KDPROVINSI', $this->input->post('cbProvinsi'));
                // $this->db->set('NOTELP', $this->input->post('tx_notelepon'));
                // $this->db->set('NOKTP', $this->input->post('noktp'));
                // $this->db->set('PEKERJAAN', $this->input->post('cb_pekerjaan'));
                // $this->db->set('STATUS', $this->input->post('rb_statuspernikahan'));
                // $this->db->set('AGAMA', $this->input->post('rb_Agama'));
                // $this->db->set('PENDIDIKAN', $this->input->post('rb_Pendidikanterakhir'));


                // if ($this->input->post('rbParentCarabayar') > 1) {
                //     $this->db->set('KDCARABAYAR', statuspasien[""]);
                // } else {
                //     $this->db->set('KDCARABAYAR', 1);
                // }

                // TIME DAN PETUGAS YANG MERUBAH BELUM DISET 
                // $data["NIP"]           = $user["firstname"];

                // $this->db->set('ALAMAT_KTP', addslashes($this->input->post('alamatktplama')));
                $this->db->set('ALAMAT_KTP', addslashes($statuspasien["ALAMATKTP"]));
                $this->db->set('PENANGGUNGJAWAB_NAMA', addslashes(getDetailUser($statuspasien["USERID"], "firstname") . " " . getDetailUser($statuspasien["USERID"], "lastname")));
                $this->db->set('PENANGGUNGJAWAB_HUBUNGAN', $statuspasien["HUBUNGANDENGANPASIEN"]);
                $this->db->set('PENANGGUNGJAWAB_ALAMAT', addslashes($statuspasien["ALAMATKTP"]));
                $this->db->set('PENANGGUNGJAWAB_PHONE', $statuspasien["NOTELP"]);


                $this->db->set('NO_KARTU', $statuspasien["NOBPJS"]);
                // $data['tgllahir']
                // $this->db->set('JNS_PASIEN', $this->input->post('rbjenispasienbpjs'));
                // $this->db->set('nama_ayah', addslashes($statuspasien["PASIENBARU"]));
                // $this->db->set('nama_ibu', addslashes($statuspasien["PASIENBARU"]));
                // $this->db->set('nama_suami', addslashes($statuspasien["PASIENBARU"]));
                // $this->db->set('nama_istri', addslashes($statuspasien["PASIENBARU"]));
                // $this->db->set('KD_ETNIS', $statuspasien["PASIENBARU"]);
                // $this->db->set('KD_BHS_HARIAN', $statuspasien["PASIENBARU"]);


                $this->db->where('NOMR', $NOMR);
                $this->db->update('m_pasien');
                // UPDATE DATA PASIEN


            } else if ($statuspasien["PASIENBARU"] == 1) {
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
                    $data["NOMR"]           = $NOMR;
                    $data["TITLE"]          = $statuspasien["TITLE"];
                    $data["NAMA"]           = addslashes(str_replace(',', ' ', $statuspasien["NAMA"]) . ', ' . $statuspasien["TITLE"]);
                    $data["IBUKANDUNG"]     = $statuspasien["NAMAIBU"];
                    $data["TEMPAT"]         = addslashes($statuspasien["TEMPAT"]);
                    $data["TGLLAHIR"]       = date('Y-m-d', strtotime(str_replace('/', '-', $statuspasien["NAMAIBU"])));
                    $data["JENISKELAMIN"]   = $statuspasien["JENISKELAMIN"];
                    $data["ALAMAT"]         = addslashes($statuspasien["ALAMATKTP"]);
                    $data["KELURAHAN"]      =  $statuspasien["KELURAHAN"];
                    $data["KDKECAMATAN"]    = $statuspasien["KECAMATAN"];
                    $data["KOTA"]           = $statuspasien["KABUPATEN"];
                    $data["KDPROVINSI"]     = $statuspasien["PROVINSI"];
                    $data["NOTELP"]         = $statuspasien["NOTELP"];
                    $data["NOKTP"]          = $statuspasien["NOKTP"];
                    //$data["SUAMI_ORTU"]   = $this->input->post('tx_nama');
                    $data["PEKERJAAN"]      = $statuspasien["PEKERJAAN"];
                    $data["STATUS"]         = $statuspasien["MARITAL"];
                    $data["AGAMA"]          = $statuspasien["AGAMA"];
                    $data["PENDIDIKAN"]     = $statuspasien["PENDIDIKAN"];

                    if ($this->input->post('rbParentCarabayar') > 1) {
                        $data["KDCARABAYAR"]           = $statuspasien["CARABAYAR"];
                    } else {
                        $data["KDCARABAYAR"]           = 1;
                    }

                    $data["NIP"]           = "ANJUNGAN"; //$user["firstname"];
                    $data["TGLDAFTAR"]           = date('Y-m-d', strtotime(str_replace('/', '-', $statuspasien["TANGGAL"])));
                    $data["ALAMAT_KTP"]           = addslashes($statuspasien["ALAMATKTP"]);

                    // CEK BAYI DULU 
                    if ($this->input->post('cb_alias') == 'By') {
                        $data["PARENT_NOMR"]           =  $NOMR;
                    }


                    $data["PENANGGUNGJAWAB_NAMA"]     = addslashes(getDetailUser($statuspasien["USERID"], "firstname") . " " . getDetailUser($statuspasien["USERID"], "lastname"));
                    $data["PENANGGUNGJAWAB_HUBUNGAN"] = $statuspasien["HUBUNGANDENGANPASIEN"];
                    $data["PENANGGUNGJAWAB_ALAMAT"]   = addslashes($statuspasien["ALAMATKTP"]);
                    $data["PENANGGUNGJAWAB_PHONE"]    = $statuspasien["NOTELP"];
                    $data["NOMR_LAMA"]                = $NOMR;
                    $data["NO_KARTU"]                 = $statuspasien["NOBPJS"];
                    $data["JNS_PASIEN"]               = "";
                    $data["nama_ayah"]                = addslashes($statuspasien["NAMAAYAH"]);
                    $data["nama_ibu"]                 = addslashes($statuspasien["NAMAIBU"]);
                    $data["nama_suami"]               = addslashes($statuspasien["NAMASUAMI"]);
                    $data["nama_istri"]               = addslashes($statuspasien["NAMAISTRI"]);
                    $data["KD_ETNIS"]                 = $statuspasien["SUKU"];
                    $data["KD_BHS_HARIAN"]            = $statuspasien["BAHASADAERAH"];
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

        public function updateVerifikasi($data)
        {
            $id           = $data['id'];
            $user_id      = $data['user_id'];
            $data = array(
                'isActive' => 1,
                'petugas_verif' => $user_id,
            );

            $this->db->where('id', $id);
            $this->db->update('t_pendaftaran_android', $data);
        }

        public function updateUnverifikasi($data)
        {
            $id           = $data['id'];
            $user_id      = $data['user_id'];
            $data = array(
                'isActive' => 0,
                'petugas_verif' => $user_id,
            );

            $this->db->where('id', $id);
            $this->db->update('t_pendaftaran_android', $data);
        }
    }
