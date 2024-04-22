<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cssd_model extends CI_Model
{

    function countKonfirmasi()
    {
        date_default_timezone_set('Asia/Jakarta');

        // if ($tanggal) {
        //     $date_selected = $tanggal;
        // } else {
        //     $date_selected = date("Y-m-d");
        // }

        $queryMenu = "SELECT count(id) as konfirmasi from t_cssd where flag = '1'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countProses()
    {
        date_default_timezone_set('Asia/Jakarta');

        // if ($tanggal) {
        //     $date_selected = $tanggal;
        // } else {
        //     $date_selected = date("Y-m-d");
        // }

        $queryMenu = "SELECT count(id) as proses from t_cssd where flag = '2'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countPengambilan()
    {
        date_default_timezone_set('Asia/Jakarta');

        // if ($tanggal) {
        //     $date_selected = $tanggal;
        // } else {
        //     $date_selected = date("Y-m-d");
        // }

        $queryMenu = "SELECT count(id) as pengambilan from t_cssd where flag = '3'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countSudahDiambil()
    {
        date_default_timezone_set('Asia/Jakarta');

        // if ($tanggal) {
        //     $date_selected = $tanggal;
        // } else {
        //     $date_selected = date("Y-m-d");
        // }

        $queryMenu = "SELECT count(id) as sudahdiambil from t_cssd where flag = '4'";

        return $this->db->query($queryMenu)->row_array();
    }

    function countSudahDiProses()
    {
        date_default_timezone_set('Asia/Jakarta');

        // if ($tanggal) {
        //     $date_selected = $tanggal;
        // } else {
        //     $date_selected = date("Y-m-d");
        // }

        $queryMenu = "SELECT count(id) as sudahdiproses from t_cssd where flag > '2'";

        return $this->db->query($queryMenu)->row_array();
    }

    public function fetchAlatByJAandRuang($jenisalat)
    {
        // $this->db->order_by('userlevels.userlevelname', 'ASC');
        // if ($ruang == null) {
        //     return $this->db->get('m_alat_cssd')->result_array();
        // } 
        return $this->db->get_where('m_alat_cssd', ['jenis_alat' => $jenisalat])->result_array();
    }

    public function fetchJenis()
    {
        return $this->db->get('l_jenisalat')->result_array();
    }

    public function get_alat($id,$poli){
        $hasil=$this->db->query("SELECT * FROM m_alat_cssd WHERE jenis_alat='$id' and ruang = '$poli' ORDER BY nama_alat ASC");
        return $hasil->result();
    }

    public function get_isnon_steril($alat){
        // $hasil=$this->db->query("SELECT * FROM m_alat_cssd WHERE alat_id='$alat'");
        // return $hasil->result_array()

        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_alat_cssd.alat_id,m_alat_cssd.jenis_alat, m_alat_cssd.ruang, m_alat_cssd.ruang,m_alat_cssd.nama_alat,m_alat_cssd.non_steril');
    
        return $this->db->get_where('m_alat_cssd', ['alat_id' => $alat])->result_array();
    }

    public function getCssdList($limit, $start, $keyword = null, $poli = null, $jenis = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_alat_cssd.alat_id,m_alat_cssd.nama_alat,m_alat_cssd.no_asset,m_alat_cssd.non_steril');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('simrs.userlevels.userlevelname as ruang');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($poli) {
            $this->db->where("m_alat_cssd.ruang", $poli);
        }
        if ($jenis) {
            $this->db->where("m_alat_cssd.jenis_alat", $jenis);
        }
        $this->db->order_by('m_alat_cssd.jenis_alat', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->join('simrs.userlevels', 'userlevels.userlevelid = m_alat_cssd.ruang', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = m_alat_cssd.jenis_alat', 'left outer');
        return $this->db->get('m_alat_cssd')->result_array();
    }

    public function getCssdListByRuang($limit, $start, $keyword = null, $ruang = null, $jenis = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_alat_cssd.alat_id,m_alat_cssd.nama_alat,m_alat_cssd.no_asset');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('simrs.userlevels.userlevelname as ruang');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' or m_alat_cssd.no_asset LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($jenis) {
            $this->db->where("m_alat_cssd.jenis_alat", $jenis);
        }
        
        $this->db->where("m_alat_cssd.ruang", $ruang);
        $this->db->order_by('m_alat_cssd.jenis_alat', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->join('simrs.userlevels', 'userlevels.userlevelid = m_alat_cssd.ruang', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = m_alat_cssd.jenis_alat', 'left outer');
        return $this->db->get('m_alat_cssd')->result_array();
    }

    public function getCssdListById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_alat_cssd.alat_id,m_alat_cssd.jenis_alat,m_alat_cssd.ruang,m_alat_cssd.nama_alat, m_alat_cssd.no_asset');
    
        return $this->db->get_where('m_alat_cssd', ['alat_id' => $id])->result_array();
    }

    public function getCssdAcceptList($limit, $start, $keyword = null, $poli = null, $jenis = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->select('l_kondisi.kondisi as kondisi');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->limit($limit, $start);
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        $this->db->join('l_kondisi', 'l_kondisi.id = t_cssd.kondisi_alat', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdAcceptById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk,t_cssd.created_pengambilan_at');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }

    public function getCssdTransactionById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,petugas_setpacking,petugas_dekontaminasi,petugas_pengering,status_sterilisasi, status_keberhasilan_sterilisasi, jam_masuk_steril, jam_selesai_steril, lama_proses_steril, petugas_sterilisasi, mesin_autoclave, mesin_load, jam_masuk_mesin, jam_selesai_mesin, exp_date');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }
    // 
    public function getCssdAcceptListByRuang($limit, $start, $keyword = null, $poli = null, $jenis = null, $ruang = null, $tanggalcari = null, $flag = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.keterangan, t_cssd.penanggungjawab_instrumen, t_cssd.created_pengambilan_at,t_cssd.user_input,t_cssd.dtt,t_cssd.created_konfirmasi_at,t_cssd.mesin_autoclave, substring(t_cssd.created_konfirmasi_at, 1, 16) as konfirmasi_cssd_at, t_cssd.flag, t_cssd.status_keberhasilan_sterilisasi, t_cssd.jam_masuk_mesin, t_cssd.mesin_load,SUBSTRING(t_cssd.jam_masuk_mesin, 1, 10) AS tm_mesin,SUBSTRING(t_cssd.jam_masuk_mesin, 12, 16) AS jm_mesin, SUBSTRING(t_cssd.jam_selesai_mesin, 1, 10) AS ts_mesin,SUBSTRING(t_cssd.jam_selesai_mesin, 12, 16) AS js_mesin, SUBSTRING(t_cssd.jam_selesai_steril, 1, 10) AS ts_steril,SUBSTRING(t_cssd.jam_selesai_steril, 12, 16) AS js_steril,
            (CASE
                WHEN flag = "1" OR flag IS NULL THEN "Belum Dikonfirmasi" 
                WHEN flag = "10" and flag_terima = "TIDAK" THEN "Tidak Disetujui"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi is null THEN "Proses"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi = "TIDAK" THEN "Gagal Di Sterilisasi"
              WHEN flag = "3" and flag_terima = "YA" THEN "Selesai - Siap Diambil"
              WHEN flag = "4" and flag_terima = "YA" THEN "Sudah Diambil"
       END) AS tracking, t_cssd.set_id');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->select('l_kondisi.kondisi as kondisi');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            // $this->db->where("substring(t_cssd.created_konfirmasi_at, 1, 10)", $tanggalcari);
            $where = "substring(t_cssd.created_konfirmasi_at, 1, 10) = '". $tanggalcari ."'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($flag) {
            $this->db->where("t_cssd.flag", $flag);
            // $where = "t_cssd.tgl_masuk = '". $tanggalcari ."' AND t_cssd.ruang= '".$ruang."'";
            // $this->db->where($where, NULL, FALSE);
        }
        $this->db->where("t_cssd.ruang", $ruang);
        $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        $this->db->join('l_kondisi', 'l_kondisi.id = t_cssd.kondisi_alat', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    function getTransactionDetailbyID($id)
    {
        $this->db->cache_on();
        $this->db->limit(1);
        $data =  $this->db->get_where('t_cssd', ['id' => $id])->row_array();
        $this->db->cache_off();
        return $data;
    }



    public function insertacceptTool($input, $nonsteril)
    {
        // print_r($input);
        // print_r($nonsteril);
        // die();
        if ($nonsteril==1) {
            $data["jenis"]           = $input['cbjenisalat'];
            $data["instrumen"]           = $input['alat'];
            $data["ruang"]           = $input['cbpoli'];
            $data["jumlah"]           = $input['jumlah'];
            $data["pengantar"]           = $input['pengantar'];
            $data["perawatjaga"]           = $input['perawatjaga'];
            // $data["petugascssd"]           = $input['petugascssd'];
            $data["tgl_masuk"]           = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_daftar'])));
            // $data["exp_date"]           = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_exp'])));
            $data["jam_masuk"]           = $input['jam_masuk'];
            $data["perawatjaga"]           = $input['perawatjaga'];
            $data["created_at"]         = date("Y-m-d H:i:s");
            $data["kondisi_alat"]           = $input['kondisi'];
            $data["user_input"]           = $input['user_input'];
            $data["flag_terima"]           = 'YA';
            $data["flag"]           = '3';
            $data["satuan"]           = $input['satuan'];
            $data["keterangan"]           = $input['keterangan'];
            $data["penanggungjawab_instrumen"]           = $input['penanggungjawabinstrumen'];

            $this->db->insert('t_cssd',$data);
        }
        else{
            $data["jenis"]           = $input['cbjenisalat'];
            $data["instrumen"]           = $input['alat'];
            $data["ruang"]           = $input['cbpoli'];
            $data["jumlah"]           = $input['jumlah'];
            $data["pengantar"]           = $input['pengantar'];
            $data["perawatjaga"]           = $input['perawatjaga'];
            // $data["petugascssd"]           = $input['petugascssd'];
            $data["tgl_masuk"]           = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_daftar'])));
            // $data["exp_date"]           = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_exp'])));
            $data["jam_masuk"]           = $input['jam_masuk'];
            $data["perawatjaga"]           = $input['perawatjaga'];
            $data["created_at"]         = date("Y-m-d H:i:s");
            $data["kondisi_alat"]           = $input['kondisi'];
            $data["user_input"]           = $input['user_input'];
            $data["flag"]           = '1';
            $data["satuan"]           = $input['satuan'];
            $data["keterangan"]           = $input['keterangan'];
            $data["penanggungjawab_instrumen"]           = $input['penanggungjawabinstrumen'];

            $this->db->insert('t_cssd',$data);
        }

        
    }

    public function insertacceptToolRuang($input)
    {

        $data["jenis"]           = $input['cbjenisalat'];
        $data["instrumen"]           = $input['alat'];
        $data["ruang"]           = $input['cbpoli'];
        $data["jumlah"]           = $input['jumlah'];
        $data["pengantar"]           = $input['pengantar'];
        $data["perawatjaga"]           = $input['perawatjaga'];
        $data["tgl_masuk"]           = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_daftar'])));
        $data["jam_masuk"]           = $input['jam_masuk'];
        $data["perawatjaga"]           = $input['perawatjaga'];
        $data["created_at"]         = date("Y-m-d H:i:s");
        $data["kondisi_alat"]           = $input['kondisi'];
        $data["user_input"]           = $input['user_input'];
        $data["flag"]           = '1';
        $data["satuan"]           = $input['satuan'];
        $data["keterangan"]           = $input['keterangan'];
        $data["set_id"]           = $input['cbset'];
        $data["penanggungjawab_instrumen"]           = $input['penanggungjawabinstrumen'];

        $this->db->insert('t_cssd',$data);

        if ($_POST["alattambahan"] == "") {
            
        }
        else{
            $ruang = $input['cbpoli'];
            $pengantar = $input['pengantar'];
            $perawatjaga = $input['perawatjaga'];
            $tgl_masuk = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_daftar'])));
            $jam_masuk = $input['jam_masuk'];
            $created_at = date("Y-m-d H:i:s");
            $kondisi_alat = $input['kondisi'];
            $user_input = $input['user_input'];
            $flag = '1';
            $penanggungjawab_instrumen = $input['penanggungjawabinstrumen'];

            $jenisnya = $_POST["cbjenisalattambahan"];

            $hoby=$_POST["alattambahan"];
            reset($hoby);
            while (list($key, $value) = each($hoby)) 
                {
                    // $jenisnya = $_POST["cbjenisalattambahan"][$key];
                    $alattambahan   =$_POST["alattambahan"][$key];
                    $jumlahtambahan   =$_POST["jumlahtambahan"][$key];
                    $satuantambahan   =$_POST["satuantambahan"][$key];
                    $keterangantambahan   =$_POST["keterangantambahan"][$key];

                    $sql_hoby   ="INSERT INTO simrs2012.t_cssd(jenis,instrumen,ruang,jumlah,pengantar,perawatjaga, tgl_masuk, jam_masuk, created_at, kondisi_alat, user_input, flag,satuan,keterangan, penanggungjawab_instrumen)
                                   VALUES('$jenisnya','$alattambahan','$ruang','$jumlahtambahan','$pengantar', '$perawatjaga', '$tgl_masuk','$jam_masuk', '$created_at', '$kondisi_alat', '$user_input', '$flag','$satuantambahan','$keterangantambahan','$penanggungjawab_instrumen')";  
                    $this->db->query($sql_hoby);   
                }
        }

        
    }

    public function updatesetPacking($input)
    {
        $id           = $input['idt'];

        $data = array(
            'petugas_setpacking' => $input['petugaspacking'],
            'petugas_dekontaminasi' => $input['petugasdekontaminasi'],
            'petugas_pengering' => $input['petugaspengering'],
            'status_sterilisasi' => $input['statussterilisasi'],
            'created_packing_at' => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);

        // $this->db->update('t_cssd',$data);
    }

    public function updateinSterilisasi($input)
    {
        $id           = $input['idt'];

        $data = array(
            'jam_masuk_steril' => $input['jam_masuk_steril'],
            'jam_selesai_steril' => $input['jam_selesai_steril'],
            'lama_proses_steril' => $input['lama_steril'],
            'petugas_sterilisasi' => $input['petugassterilisasi'],
            'created_sterilisasi_at' => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);

        // $this->db->update('t_cssd',$data);
    }

    public function updateoutTool($input)
    {
        $id           = $input['idt'];
        $data = array(
            'petugas_pengambil' => $input['pengambil'],
            'petugas_yg_menyerahkan' => $input['petugas_yg_menyerahkan'],
            'created_pengambilan_at' => date("Y-m-d H:i:s"),
            'flag' => '4'
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);
    }

    public function updatekonfirmasi($input)
    {
        $id           = $input['modal_idkonfirmasi'];
        $user           = $input['modal_userkonfirmasi'];
        $petugascssd           = $input['modal_petugascssd'];
        $dtt           = $input['dtt'];
        $statussterilisasi           = $input['statussterilisasi'];
        $edruang           = $input['edruang'];

        $data = array(
            'petugascssd' => $petugascssd,
            'created_konfirmasi_by' => $user,
            'flag_terima' => 'YA',
            'flag' => '2',
            'created_konfirmasi_at' => date("Y-m-d H:i:s"),
            'dtt' => $dtt,
            'status_sterilisasi' => $statussterilisasi,
            'status_ed_ruang' => $edruang,
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);
    }

    public function updatekonfirmasitolak($input)
    {
        $id           = $input['modal_idkonfirmasi'];
        $user           = $input['modal_userkonfirmasi'];
        $petugascssd           = $input['modal_petugascssd'];

        $data = array(
            'petugascssd' => $petugascssd,
            'created_konfirmasi_by' => $user,
            'flag_terima' => 'TIDAK',
            'flag' => '10',
            'created_konfirmasi_at' => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);
    }

    public function updateinTransaction($input)
    {
        $id   = $input['modal_id'];
        $dtt = $input['modal_dtt'];
        $status   = $input['statuskeberhasilansterilisasi'];
        $jam_masuk_mesin = "".$input['tm_mesin']." ".$input['jm_mesin']."";
        $jam_selesai_mesin = "".$input['ts_mesin']." ".$input['js_mesin']."";
        $jam_selesai_steril = "".$input['ts_steril']." ".$input['js_steril']."";


        $waktu_awal        =strtotime("".$input['tkonfirmasi']." ".$input['jkonfirmasi'].":00");
        $waktu_akhir    =strtotime("".$input['ts_steril']." ".$input['js_steril'].":00"); // bisa juga waktu sekarang now()
            
            //menghitung selisih dengan hasil detik
        $diff    =$waktu_akhir - $waktu_awal;
            
            //membagi detik menjadi jam
        $jam    =floor($diff / (60 * 60));
            
            //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit    =$diff - $jam * (60 * 60);

            //menampilkan / print hasil
        echo 'Hasilnya adalah '.number_format($diff,0,",",".").' detik<br /><br />';
        $detik = number_format($diff,0,",",".");

        if($dtt == "T"){
            $lama = "".$jam. " Jam " . floor( $menit / 60 ) . " Menit";
        }
        else{
            $lama = "";
        }
        // print_r($input['tkonfirmasi']);
        // print_r($input['jkonfirmasi']);
        // print_r($lama);
        // die();

        if ($detik > "21.600") {
            $k6jam = "TIDAK";
                # code...
        }
        else{
            $k6jam = "YA";
        }


        if($status == "BERHASIL"){
            

            $data = array(
                'exp_date' => $input['dtp_tanggal_exp'],
                'petugas_setpacking' => $input['petugaspacking'],
                'petugas_dekontaminasi' => $input['petugasdekontaminasi'],
                'petugas_pengering' => $input['petugaspengering'],
                'status_sterilisasi' => $input['statussterilisasi'],
                'status_keberhasilan_sterilisasi' => $input['statuskeberhasilansterilisasi'],
                'created_packing_at' => date("Y-m-d H:i:s"),
                'jam_masuk_steril' => $jam_masuk_mesin,
                'jam_selesai_steril' => $jam_selesai_steril,
                'lama_proses_steril' => $lama,
                'petugas_sterilisasi' => $input['petugassterilisasi'],
                'created_sterilisasi_at' => date("Y-m-d H:i:s"),
                'mesin_autoclave' => $input['mesin'],
                'mesin_load' => $input['mesinload'],
                'jam_masuk_mesin' => $jam_masuk_mesin,
                'jam_selesai_mesin' => $jam_selesai_mesin,
                'ks6jam' => $k6jam,
                'flag' => '3'
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd', $data);

                $idnya =$input['modal_id'];
                $exp_date = $input['dtp_tanggal_exp'];
                $petugas_setpacking = $input['petugaspacking'];
                $petugas_dekontaminasi = $input['petugasdekontaminasi'];
                $petugas_pengering              = $input['petugaspengering'];
                $status_sterilisasi             = $input['statussterilisasi'];
                $status_keberhasilan_sterilisasi= $input['statuskeberhasilansterilisasi'];
                $created_packing_at             = date("Y-m-d H:i:s");
                $jam_masuk_steril               = $jam_masuk_mesin;
                $jam_selesai_steril             = $jam_selesai_steril;
                $lama_proses_steril             = $lama;
                $petugas_sterilisasi            = $input['petugassterilisasi'];
                $created_sterilisasi_at         = date("Y-m-d H:i:s");
                $mesin_autoclave                = $input['mesin'];
                $mesin_load                     = $input['mesinload'];
                $jam_masuk_mesin                = $jam_masuk_mesin;
                $jam_selesai_mesin              = $jam_selesai_mesin;
                $ks6jam              = $k6jam;

            $datainsert = array(
                'idt_cssd' =>$idnya,
                'petugas_setpacking' => $petugas_setpacking,
                'petugas_dekontaminasi' => $petugas_dekontaminasi,
                'petugas_pengering' => $petugas_pengering,
                'status_keberhasilan_sterilisasi' => $status_keberhasilan_sterilisasi,
                'created_packing_at' => $created_packing_at,
                'jam_masuk_steril' => $jam_masuk_mesin,
                'jam_selesai_steril' => $jam_selesai_steril,
                'lama_proses_steril' => $lama,
                'petugas_sterilisasi' => $petugas_sterilisasi,
                'created_sterilisasi_at' => $created_sterilisasi_at,
                'mesin_autoclave' => $mesin_autoclave,
                'mesin_load' => $mesin_load,
                'jam_masuk_mesin' => $jam_masuk_mesin,
                'jam_selesai_mesin' => $jam_selesai_mesin,
                'ks6jam' => $ks6jam,
                'exp_date' => $exp_date
            );
            $this->db->insert('t_cssd_history',$datainsert);
        }
        else if($status == "TIDAK"){
            $data = array(
                'exp_date' => $input['dtp_tanggal_exp'],
                'petugas_setpacking' => $input['petugaspacking'],
                'petugas_dekontaminasi' => $input['petugasdekontaminasi'],
                'petugas_pengering' => $input['petugaspengering'],
                'status_sterilisasi' => $input['statussterilisasi'],
                'status_keberhasilan_sterilisasi' => $input['statuskeberhasilansterilisasi'],
                'created_packing_at' => date("Y-m-d H:i:s"),
                'jam_masuk_steril' => $jam_masuk_mesin,
                'jam_selesai_steril' => $jam_selesai_steril,
                'lama_proses_steril' => $lama,
                'petugas_sterilisasi' => $input['petugassterilisasi'],
                'created_sterilisasi_at' => date("Y-m-d H:i:s"),
                'mesin_autoclave' => $input['mesin'],
                'mesin_load' => $input['mesinload'],
                'jam_masuk_mesin' => $jam_masuk_mesin,
                'jam_selesai_mesin' => $jam_selesai_mesin,
                'ks6jam' => $k6jam,
                'flag' => '2'
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd', $data);

                $idnya =$input['modal_id'];
                $exp_date = $input['dtp_tanggal_exp'];
                $petugas_setpacking = $input['petugaspacking'];
                $petugas_dekontaminasi = $input['petugasdekontaminasi'];
                $petugas_pengering              = $input['petugaspengering'];
                $status_sterilisasi             = $input['statussterilisasi'];
                $status_keberhasilan_sterilisasi= $input['statuskeberhasilansterilisasi'];
                $created_packing_at             = date("Y-m-d H:i:s");
                $jam_masuk_steril               = $jam_masuk_mesin;
                $jam_selesai_steril             = $jam_selesai_steril;
                $lama_proses_steril             = $lama;
                $petugas_sterilisasi            = $input['petugassterilisasi'];
                $created_sterilisasi_at         = date("Y-m-d H:i:s");
                $mesin_autoclave                = $input['mesin'];
                $mesin_load                     = $input['mesinload'];
                $jam_masuk_mesin                = $jam_masuk_mesin;
                $jam_selesai_mesin              = $jam_selesai_mesin;
                $ks6jam                         = $k6jam;


            $datainsert = array(
                'idt_cssd' =>$idnya,
                'petugas_setpacking' => $petugas_setpacking,
                'petugas_dekontaminasi' => $petugas_dekontaminasi,
                'petugas_pengering' => $petugas_pengering,
                'status_keberhasilan_sterilisasi' => $status_keberhasilan_sterilisasi,
                'created_packing_at' => $created_packing_at,
                'jam_masuk_steril' => $jam_masuk_steril,
                'jam_selesai_steril' => $jam_selesai_steril,
                'lama_proses_steril' => $lama,
                'petugas_sterilisasi' => $petugas_sterilisasi,
                'created_sterilisasi_at' => $created_sterilisasi_at,
                'mesin_autoclave' => $mesin_autoclave,
                'mesin_load' => $mesin_load,
                'jam_masuk_mesin' => $jam_masuk_mesin,
                'jam_selesai_mesin' => $jam_selesai_mesin,
                'ks6jam' => $ks6jam,
                'exp_date' => $exp_date
            );

            $this->db->insert('t_cssd_history', $datainsert);


        }
        else{
            $data = array(
                'exp_date' => $input['dtp_tanggal_exp'],
                'petugas_setpacking' => $input['petugaspacking'],
                'petugas_dekontaminasi' => $input['petugasdekontaminasi'],
                'petugas_pengering' => $input['petugaspengering'],
                'status_sterilisasi' => $input['statussterilisasi'],
                'created_packing_at' => date("Y-m-d H:i:s"),
                'jam_masuk_steril' => $input['jam_masuk_steril'],
                'jam_selesai_steril' => $jam_selesai_steril,
                // 'lama_proses_steril' => $input['lama_steril'],
                'lama_proses_steril' => $lama,
                'petugas_sterilisasi' => $input['petugassterilisasi'],
                'created_sterilisasi_at' => date("Y-m-d H:i:s"),
                'mesin_autoclave' => $input['mesin'],
                'mesin_load' => $input['mesinload'],
                'jam_masuk_mesin' => $jam_masuk_mesin,
                'jam_selesai_mesin' => $jam_selesai_mesin
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd', $data);
        }
        
    }

    public function insertbowieDick($input)
    {

        $data["tgl_uji"]           = $input['t_uji'];
        $data["jam_uji"]           = $input['j_uji'];
        $data["mesin_autoclave"]           = $input['cbmesin'];
        $data["mesin_load"]           = $input['mesin_load'];
        // $data["petugas_uji"]           = $input['petugas_uji'];
        // $data["status_keberhasilan"]           = $input['statuskeberhasilan'];
        $data["created_at"]         = date("Y-m-d H:i:s");
        $data["created_by"]           = $input['user_input'];

        $this->db->insert('t_cssd_bowiedick',$data);
    }

    public function updatebowieDick($input)
    {
        $id   = $input['modal_id'];
        $dtt = $input['modal_dtt'];
        $status   = $input['statuskeberhasilan'];

        if($status == "BERHASIL"){
            

            $data = array(
                'status_keberhasilan' => $input['statuskeberhasilan'],
                'petugas_uji' => $input['petugasuji']
                
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd_bowiedick', $data);

            $idnya =$input['modal_id'];    
            $statuskeberhasilan= $input['statuskeberhasilan'];
            $created_at             = date("Y-m-d H:i:s");
            $created_by             = $input['user'];
            $petugas_uji = $input['petugasuji'];

            $datainsert = array(
                'id_bowiedick' =>$idnya,
                'petugas_uji' => $petugas_uji,
                'status_keberhasilan' => $statuskeberhasilan,
                'created_at' => $created_at,
                'created_by' => $created_by
            );
            $this->db->insert('t_cssd_bowiedick_history',$datainsert);
        }
        else if($status == "TIDAK"){
            $data = array(
                'status_keberhasilan' => $input['statuskeberhasilan'],
                'petugas_uji' => $input['petugasuji']
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd_bowiedick', $data);

            $idnya =$input['modal_id'];    
            $statuskeberhasilan= $input['statuskeberhasilan'];
            $created_at             = date("Y-m-d H:i:s");
            $created_by             = $input['user'];
            $petugas_uji = $input['petugasuji'];

            $datainsert = array(
                'id_bowiedick' =>$idnya,
                'petugas_uji' => $petugas_uji,
                'status_keberhasilan' => $statuskeberhasilan,
                'created_at' => $created_at,
                'created_by' => $created_by
            );
            $this->db->insert('t_cssd_bowiedick_history',$datainsert);

        }
        else{
            $data = array(
                'status_keberhasilan' => $input['statuskeberhasilan'],
                'petugas_uji' => $input['petugasuji']
            );
            $this->db->where('id', $id);
            $this->db->update('t_cssd_bowiedick', $data);
        }
        
    }

    public function getCssdPackingList($limit, $start, $keyword = null, $poli = null, $jenis = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        $where = "created_sterilisasi_at is NULL and created_pengambilan_at is NULL";
        $this->db->where($where, NULL, FALSE);
        $this->db->limit($limit, $start);
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdPackingById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi,t_cssd.created_packing_at,t_cssd.created_pengambilan_at');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }

    public function getCssdSterilisasiList($limit, $start, $keyword = null, $poli = null, $jenis = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        $where = "created_packing_at is not NULL and created_pengambilan_at is NULL";
        $this->db->where($where, NULL, FALSE);
        $this->db->limit($limit, $start);
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdSterilisasiById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }

    public function getCssdOutList($limit, $start, $keyword = null, $ruang = null, $jenis = null, $tanggalcari = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at,t_cssd.user_input,t_cssd.dtt,t_cssd.created_konfirmasi_at,t_cssd.mesin_autoclave,t_cssd.flag, t_cssd.status_keberhasilan_sterilisasi, t_cssd.jam_masuk_mesin, t_cssd.mesin_load, t_cssd.keterangan, t_cssd.dtt, substring(t_cssd.created_konfirmasi_at, 1, 16) as konfirmasi_cssd_at ,SUBSTRING(t_cssd.jam_masuk_mesin, 1, 10) AS tm_mesin,SUBSTRING(t_cssd.jam_masuk_mesin, 12, 16) AS jm_mesin, SUBSTRING(t_cssd.jam_selesai_mesin, 1, 10) AS ts_mesin,SUBSTRING(t_cssd.jam_selesai_mesin, 12, 16) AS js_mesin, SUBSTRING(t_cssd.jam_selesai_steril, 1, 10) AS ts_steril,SUBSTRING(t_cssd.jam_selesai_steril, 12, 16) AS js_steril, t_cssd.penanggungjawab_instrumen,
            (CASE
                WHEN flag = "1" OR flag IS NULL THEN "Belum Dikonfirmasi" 
                WHEN flag = "10" and flag_terima = "TIDAK" THEN "Tidak Disetujui"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi is null THEN "Proses"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi = "TIDAK" THEN "Gagal Di Sterilisasi"
              WHEN flag = "3" and flag_terima = "YA" THEN "Selesai - Siap Diambil"
              WHEN flag = "4" and flag_terima = "YA" THEN "Sudah Diambil"
       END) AS tracking');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%') and flag = '3'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            $where = "substring(t_cssd.created_konfirmasi_at, 1, 10) = '". $tanggalcari ."' and flag = '3'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($ruang) {
            $where = "t_cssd.ruang = '".$ruang."' and flag = '3'";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = "flag = '3'";
            $this->db->where($where, NULL, FALSE);
        }
        // $this->db->where($where, NULL, FALSE);
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdOutById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at, t_cssd.created_konfirmasi_at, t_cssd.jam_masuk_mesin, t_cssd.jam_selesai_mesin, t_cssd.satuan,t_cssd.dtt');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }

    public function getTrackingList($limit, $start, $keyword = null, $poli = null, $flag = null, $tanggalcari = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at,t_cssd.user_input,t_cssd.dtt,t_cssd.created_konfirmasi_at,t_cssd.mesin_autoclave,t_cssd.flag, t_cssd.status_keberhasilan_sterilisasi, t_cssd.jam_masuk_mesin, t_cssd.mesin_load, t_cssd.keterangan, t_cssd.dtt, substring(t_cssd.created_konfirmasi_at, 1, 16) as konfirmasi_cssd_at ,SUBSTRING(t_cssd.jam_masuk_mesin, 1, 10) AS tm_mesin,SUBSTRING(t_cssd.jam_masuk_mesin, 12, 16) AS jm_mesin, SUBSTRING(t_cssd.jam_selesai_mesin, 1, 10) AS ts_mesin,SUBSTRING(t_cssd.jam_selesai_mesin, 12, 16) AS js_mesin, SUBSTRING(t_cssd.jam_selesai_steril, 1, 10) AS ts_steril,SUBSTRING(t_cssd.jam_selesai_steril, 12, 16) AS js_steril, t_cssd.penanggungjawab_instrumen, t_cssd.mesin_load,
            (CASE
                WHEN flag = "1" OR flag IS NULL THEN "Belum Dikonfirmasi" 
                WHEN flag = "10" and flag_terima = "TIDAK" THEN "Tidak Disetujui"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi is null THEN "Proses"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi = "TIDAK" THEN "Gagal Di Sterilisasi"
              WHEN flag = "3" and flag_terima = "YA" THEN "Selesai - Siap Diambil"
              WHEN flag = "4" and flag_terima = "YA" THEN "Sudah Diambil"
       END) AS tracking, t_cssd.set_id');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            $where = "substring(t_cssd.created_konfirmasi_at, 1, 10) = '". $tanggalcari ."'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($poli) {
            $where = "t_cssd.ruang = '".$poli."'";
            $this->db->where($where, NULL, FALSE);
            // print_r($flag);

            // $this->db->where("t_cssd.flag", $flag);
        }
        if ($flag) {
            $where = "t_cssd.flag = '".$flag."'";
            $this->db->where($where, NULL, FALSE);
            // print_r($flag);

            // $this->db->where("t_cssd.flag", $flag);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getTrackingById($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at');
    
        return $this->db->get_where('t_cssd', ['id' => $id])->result_array();
    }

    public function getTransactionList($limit, $start, $keyword = null, $ruang = null, $jenis = null, $tanggalcari = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.status_keberhasilan_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at,t_cssd.user_input,t_cssd.created_konfirmasi_at,t_cssd.mesin_autoclave, t_cssd.jam_masuk_mesin, t_cssd.mesin_load, t_cssd.keterangan, t_cssd.dtt, t_cssd.penanggungjawab_instrumen,SUBSTRING(t_cssd.jam_masuk_mesin, 1, 10) AS tm_mesin,SUBSTRING(t_cssd.jam_masuk_mesin, 12, 16) AS jm_mesin, SUBSTRING(t_cssd.jam_selesai_mesin, 1, 10) AS ts_mesin,SUBSTRING(t_cssd.jam_selesai_mesin, 12, 16) AS js_mesin, SUBSTRING(t_cssd.jam_selesai_steril, 1, 10) AS ts_steril,SUBSTRING(t_cssd.jam_selesai_steril, 12, 16) AS js_steril,
            (CASE
                WHEN flag = "1" OR flag IS NULL THEN "Belum Dikonfirmasi" 
                WHEN flag = "10" and flag_terima = "TIDAK" THEN "Tidak Disetujui"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi is null THEN "Proses"
                WHEN flag = "2"  and flag_terima = "YA" AND status_keberhasilan_sterilisasi = "TIDAK" THEN "Gagal Di Sterilisasi"
              WHEN flag = "3" and flag_terima = "YA" THEN "Selesai - Siap Diambil"
              WHEN flag = "4" and flag_terima = "YA" THEN "Sudah Diambil"
       END) AS tracking, t_cssd.set_id');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->select('l_kondisi.kondisi as kondisi');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%' AND (status_keberhasilan_sterilisasi is NULL OR status_keberhasilan_sterilisasi = 'TIDAK') and flag_terima = 'YA' and flag = '2')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            $where = "SUBSTRING(t_cssd.created_konfirmasi_at, 1, 10) = '". $tanggalcari ."' AND (status_keberhasilan_sterilisasi is NULL OR status_keberhasilan_sterilisasi = 'TIDAK') and flag_terima = 'YA' and flag = '2'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($ruang) {
            $where = "t_cssd.ruang = '". $ruang ."' AND (status_keberhasilan_sterilisasi is NULL OR status_keberhasilan_sterilisasi = 'TIDAK') and flag_terima = 'YA' and flag = '2'";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = "(status_keberhasilan_sterilisasi is NULL OR status_keberhasilan_sterilisasi = 'TIDAK') and flag_terima = 'YA' and flag = '2'";
        $this->db->where($where, NULL, FALSE);
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        $this->db->join('l_kondisi', 'l_kondisi.id = t_cssd.kondisi_alat', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getKonfirmasiList($limit, $start, $keyword = null, $poli = null, $jenis = null, $tanggalcari = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at,t_cssd.user_input,t_cssd.keterangan,t_cssd.penanggungjawab_instrumen,
            t_cssd.set_id');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->select('l_kondisi.kondisi as kondisi');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%' AND flag_terima is NULL)";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            // $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
            $this->db->where("t_cssd.tgl_masuk", $tanggalcari);
            $where = "t_cssd.tgl_masuk = '". $tanggalcari ."' AND flag_terima is NULL";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = "flag_terima is NULL";
            $this->db->where($where, NULL, FALSE);
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        $this->db->join('l_kondisi', 'l_kondisi.id = t_cssd.kondisi_alat', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getKonfirmasiTolakList($limit, $start, $keyword = null, $poli = null, $jenis = null, $tanggalcari = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd.tgl_masuk, ' ', t_cssd.jam_masuk) as tgljammasuk", FALSE);
        $this->db->select('t_cssd.id,t_cssd.jenis,t_cssd.instrumen,t_cssd.ruang,t_cssd.jumlah,t_cssd.tgl_masuk, t_cssd.kondisi_alat,t_cssd.pengantar,t_cssd.petugascssd,t_cssd.perawatjaga,t_cssd.exp_date,t_cssd.jam_masuk, t_cssd.petugas_setpacking, t_cssd.petugas_dekontaminasi, t_cssd.petugas_pengering, t_cssd.status_sterilisasi, t_cssd.created_packing_at , t_cssd.jam_masuk_steril, t_cssd.jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.petugas_sterilisasi, t_cssd.created_sterilisasi_at, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.created_pengambilan_at,t_cssd.user_input');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->select('l_kondisi.kondisi as kondisi');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' OR l_jenisalat.jenis_alat LIKE '%" . $keyword . "%' AND flag_terima ='TIDAK')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            // $this->db->where("bill_detail_tarif.tglreg", $tanggalcari);
            $this->db->where("t_cssd.tgl_masuk", $tanggalcari);
            $where = "t_cssd.tgl_masuk = '". $tanggalcari ."' AND flag_terima ='TIDAK'";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = "flag_terima ='TIDAK'";
            $this->db->where($where, NULL, FALSE);
        }
        
        $this->db->limit($limit, $start);
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');
        $this->db->join('l_kondisi', 'l_kondisi.id = t_cssd.kondisi_alat', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function insertTool($input)
    {
        if ($input['cbjenisalat'] == 3) {
            # code...
            $data["jenis_alat"]      = $input['cbjenisalat'];
            $data["ruang"]           = $input['cbruang'];
            $data["nama_alat"]       = $input['instrumen'];
            $data["no_asset"]       = $input['no_asset'];
            $data["non_steril"]       = $input['nonsteril'];
        }else{
            $data["jenis_alat"]      = $input['cbjenisalat'];
            $data["ruang"]           = $input['cbruang'];
            $data["nama_alat"]       = $input['instrumen'];
            $data["no_asset"]       = $input['no_asset'];
        }
        

        $this->db->insert('m_alat_cssd',$data);
    }

    public function editTool($input)
    {
        $id = $input['id'];
        // print_r($input);
        // die();
        $data = array(
                'jenis_alat' => $input['cbjenisalat'],
                'ruang' => $input['cbruang'],
                'nama_alat' => $input['instrumen'],
                'no_asset' => $input['no_asset']
            );
        $this->db->where('alat_id', $id);
        $this->db->update('m_alat_cssd', $data);
    }

    public function insertDistribusi($input)
    {
        $data["jenis_id"]      = $input['modal_jenis'];
        $data["instrumen_id"]      = $input['modal_instrumen'];
        $data["ruang"]           = $input['cbruang'];
        $data["jumlah"]       = $input['jumlah'];
        $data["created_at"]         = date("Y-m-d H:i:s");
        $data["created_by"]       = $input['modal_user'];
        $data["keterangan"]       = $input['keterangan'];
        $data["tgl_distribusi"]       = date('Y-m-d', strtotime(str_replace('/', '-', $input['dtp_tanggal_daftar'])));
        $data["petugas_pengambil"]           = $input['petugaspengambil'];
        $data["petugas_yg_menyerahkan"]           = $input['petugasygmenyerahkan'];

        $this->db->insert('t_cssd_distribusi',$data);
    }

    public function getCssdFlag()
    {
        return $this->db->get_where('l_cssd_flag')->result_array();
    }

    public function backkonfirmasi($id,$dtt)
    {
        $idnya           = $id;
        $dttnya           = $dtt;

            $data = array(
                'flag' => "1",
				'flag_terima' => NULL,
            );
        $this->db->where('id', $idnya);
        $this->db->update('t_cssd', $data);
    }
	
	public function updatedtt($id,$dtt)
    {
        $idnya           = $id;
        $dttnya           = $dtt;

        if ($dttnya == "Y") {
            $data = array(
                'dtt' => "T",
            );
        }
        else{
            $data = array(
                'dtt' => "Y",
            );
        }
        $this->db->where('id', $idnya);
        $this->db->update('t_cssd', $data);
    }

    public function getDistribusiList()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd_distribusi.*');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->order_by('t_cssd_distribusi.id', 'DESC');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd_distribusi.instrumen_id', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd_distribusi.jenis_id', 'left outer');
        return $this->db->get('t_cssd_distribusi')->result_array();
    }

    public function getDistribusiStokList($limit, $start, $keyword = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.id, t_cssd.jenis, t_cssd.instrumen, sum(t_cssd.jumlah) as stok, (select IFNULL(sum(jumlah),0) as diambil from t_cssd_distribusi where t_cssd.jenis = t_cssd_distribusi.jenis_id and t_cssd.instrumen = t_cssd_distribusi.instrumen_id), IFNULL(sum(t_cssd.jumlah),0)-(select IFNULL(sum(jumlah),0) from t_cssd_distribusi where t_cssd.jenis = t_cssd_distribusi.jenis_id and t_cssd.instrumen = t_cssd_distribusi.instrumen_id) as sisa');
        $this->db->select('l_jenisalat.jenis_alat');
        $this->db->select('m_alat_cssd.nama_alat as instrumen_name');
        $this->db->where('t_cssd.jenis = "3" AND t_cssd.flag = "4"');
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd.id', 'ASC');
        $this->db->group_by('t_cssd.jenis,t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('l_jenisalat', 'l_jenisalat.jenis_id = t_cssd.jenis', 'left outer');

        if ($keyword) {
            $where = "(m_alat_cssd.nama_alat LIKE '%" . $keyword . "%' AND t_cssd.jenis = '3' AND t_cssd.flag = '4')";
            $this->db->where($where, NULL, FALSE);
        }
        else{
            $where = 't_cssd.jenis = "3" AND t_cssd.flag = "4"';
            $this->db->where($where, NULL, FALSE);
        }

        return $this->db->get('t_cssd')->result_array();
    }


    // laporan
    public function getCssdSterilisasiPerBulan($tahun, $bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '". $tahun ."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '". $bulan ."' AND status_sterilisasi = '2'");
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdRegisterPerTahun($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4')  AND status_sterilisasi = '2'");
        // $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCounterRuang($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('count(t_cssd.ruang) as jumlah, t_cssd.ruang');
        $this->db->where('t_cssd.flag = "3" or t_cssd.flag = "4"');
        $this->db->group_by('t_cssd.ruang');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdKonfirmasi($tahun,$bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.created_konfirmasi_at, t_cssd.ruang, t_cssd.instrumen, userlevels.userlevelname AS ruangnya, m_alat_cssd.nama_alat as instrumennya, t_cssd.jumlah, t_cssd.pengantar, t_cssd.perawatjaga, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.keterangan');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '". $tahun ."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '". $bulan ."'");
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        $this->db->limit(400);
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdRegister($tahun,$bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.created_konfirmasi_at as tanggal, t_cssd.ruang, t_cssd.instrumen, t_cssd.jumlah, t_cssd.created_konfirmasi_at as jam_pengantaran, t_cssd.jam_masuk_steril as jam_steril, t_cssd.jam_selesai_steril as jam_selesai_steril, t_cssd.lama_proses_steril, t_cssd.ks6jam as kurang, t_cssd.exp_date_ruang as ED, t_cssd.petugas_dekontaminasi, t_cssd.petugas_sterilisasi, t_cssd.dtt, t_cssd.petugas_setpacking, t_cssd.keterangan, (CASE WHEN t_cssd.petugas_dekontaminasi IS NULL THEN "Tidak"
             WHEN t_cssd.petugas_dekontaminasi = "" THEN "Tidak"
             WHEN t_cssd.petugas_dekontaminasi != "" THEN "Ya"
            END) AS dekontaminasi, 
            (CASE WHEN t_cssd.petugas_sterilisasi IS NULL THEN "Tidak"
             WHEN t_cssd.petugas_sterilisasi = "" THEN "Tidak"
             WHEN t_cssd.petugas_sterilisasi != "" THEN "Ya"
            END) AS sterilisasi');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '". $tahun ."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '". $bulan ."'");
        // $this->db->limit(10, 20);
        return $this->db->get('t_cssd')->result_array();
    }
    
    public function getCssdDekontaminasiPerBulan($tahun, $bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '". $tahun ."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '". $bulan ."' AND status_sterilisasi != '2'");
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdDekontaminasiPerTahun($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("t_cssd.flag = '3' or t_cssd.flag = '4' AND status_sterilisasi != '2'");
        // $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdSUlangPerBulan($tahun, $bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("(t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '". $tahun ."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '". $bulan ."' AND status_sterilisasi != '2'");
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getCssdSUlangPerTahun($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_cssd.instrumen, t_cssd.ruang, SUBSTRING(t_cssd.created_sterilisasi_at, 1, 4) as tahun, SUBSTRING(t_cssd.created_sterilisasi_at, 6, 2) as bulan');
        $this->db->select('simrs.userlevels.userlevelname as ruangnya');
        $this->db->select('m_alat_cssd.nama_alat');
        $this->db->where("t_cssd.flag = '3' or t_cssd.flag = '4' AND status_sterilisasi != '2'");
        // $this->db->order_by('t_cssd.id', 'DESC');
        $this->db->group_by('t_cssd.ruang, t_cssd.instrumen');
        $this->db->join('m_alat_cssd', 'm_alat_cssd.alat_id = t_cssd.instrumen', 'left outer');
        $this->db->join('simrs.userlevels', 'simrs.userlevels.userlevelid = t_cssd.ruang', 'left outer');
        return $this->db->get('t_cssd')->result_array();
    }

    public function getBowiedickList($limit, $start, $keyword = null, $tanggalcari = null, $cbmesin = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select("CONCAT(t_cssd_bowiedick.tgl_uji, ' ', t_cssd_bowiedick.jam_uji) as tgluji", FALSE);
        $this->db->select('t_cssd_bowiedick.id,t_cssd_bowiedick.mesin_autoclave,t_cssd_bowiedick.mesin_load,t_cssd_bowiedick.petugas_uji, t_cssd_bowiedick.status_keberhasilan');

        if ($keyword) {
            $where = "(t_cssd_bowiedick.status_keberhasilan LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($tanggalcari) {
            $where = "substring(t_cssd_bowiedick.tgl_uji, 1, 10) = '". $tanggalcari ."'";
            $this->db->where($where, NULL, FALSE);
        }
        if ($cbmesin) {
            $where = "t_cssd_bowiedick.mesin_autoclave = '".$cbmesin."'";
            $this->db->where($where, NULL, FALSE);
        }
        // if ($flag) {
        //     $where = "t_cssd.flag = '".$flag."'";
        //     $this->db->where($where, NULL, FALSE);
        // }
        $this->db->limit($limit, $start);
        $this->db->order_by('t_cssd_bowiedick.id', 'DESC');
        return $this->db->get('t_cssd_bowiedick')->result_array();
    }
	
	public function updateJumlah($input)
    {
        $id           = $input['modal_id'];
        $jumlah           = $input['modal_jumlah'];

        $data = array(
            'jumlah' => $jumlah
        );

        $this->db->where('id', $id);
        $this->db->update('t_cssd', $data);
    }
}
