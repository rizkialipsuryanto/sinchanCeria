<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sep_model  extends CI_Model
{

    function getDetailSepByIDXandType($jenis_layanan, $idx)
    {
        $this->db->limit(1);
        $this->db->where('jenis_layanan', $jenis_layanan);
        $this->db->where('idx', $idx);
        return $this->db->get('t_sep')->row_array();
    }


    public function getListPengajuanSEP($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->where('nomr', $keyword);
        }
        $this->db->order_by('id', "DESC");
        $this->db->limit($limit, $start);
        return $this->db->get('t_persetujuansep')->result_array();
    }

    public function getListPersetujuanSEP()
    {
        $this->db->order_by('id', "DESC");
        return $this->db->get('t_persetujuansep')->result_array();
    }

    public function getDetailSEPbyIDX($jenisrawat, $idx)
    {
        $queryMenu = "SELECT * from t_sep where idx = '" . $idx . "'  and jenis_layanan = '" . $jenisrawat . "'";
        return $this->db->query($queryMenu)->row_array();
    }

    public function simpanSEPLocal($data)
    {
        $sep["nomer_sep"] = $data["sep"]["noSep"];
        $sep["nomr"] = $data["data"]["nomr"];
        $sep["no_kartubpjs"] = $data["data"]["no_kartubpjs"];
        $sep["jenis_layanan"] = $data["data"]["jenis_layanan"];
        $sep["tgl_sep"] = $data["data"]["tgl_sep"];
        $sep["tgl_rujukan"] = $data["data"]["tgl_rujukan"];
        $sep["kelas_rawat"] = $data["data"]["kelas_rawat"];
        $sep["no_rujukan"] = $data["data"]["no_rujukan"];
        $sep["ppk_asal"] = $data["data"]["ppk_asal"];
        $sep["nama_ppk"] = $data["data"]["nama_ppk"];
        $sep["ppk_pelayanan"] = $data["data"]["ppk_pelayanan"];
        $sep["catatan"] = $data["data"]["catatan"];
        $sep["kode_diagnosaawal"] = $data["data"]["kode_diagnosaawal"];
        $sep["nama_diagnosaawal"] = $data["data"]["nama_diagnosaawal"];
        $sep["laka_lantas"] = $data["data"]["laka_lantas"];
        $sep["user"] = $data["data"]["user"];
        $sep["kode_politujuan"] = $data["data"]["kode_politujuan"];
        $sep["nama_politujuan"] = $data["data"]["nama_politujuan"];

        $sep["kddpjpvclaim"] = $data["data"]["kddpjpvclaim"];
        $sep["nmkddpjpvclaim"] = $data["data"]["nmkddpjpvclaim"];
        $sep["nosuratkontrol"] = $data["data"]["nosuratkontrol"];

        $sep["faskes_id"] = $data["data"]["faskes_id"];
        $sep["last_update"] = date('Y-m-d H:m:s');
        $sep["no_telp"] = $data["data"]["no_telp"];
        $sep["idx"] = $data["data"]["idx"];
        $sep["dpjp"] = $data["data"]["dpjp"];
        $sep["pasien_baru"] = $data["data"]["pasien_baru"];
        $sep["cara_bayar"] = $data["data"]["cara_bayar"];

        $sep["poli_eksekutif"] = $data["data"]["poli_eksekutif"];
        $sep["cob"] = $data["data"]["cob"];
        $sep["katarak"] = $data["data"]["katarak"];
        $sep["user_id"] = $data["data"]["user_id"];

        $this->db->insert('t_sep', $sep);
        return $this->db->affected_rows();
    }

    public function getPengajuanSEPById($jenislayanan, $idx)
    {
        $this->db->limit(1);
        $this->db->where("jenispelayanan", $jenislayanan);
        $this->db->where("idxdaftar", $idx);
        return $this->db->get('t_persetujuansep')->row_array();
    }

    public function simpanPembaharuanRujukanBPJS($id, $data)
    {
        $this->db->set('tglKunjungan', $data["rujukan"]["tglKunjungan"]);
        $this->db->set('provPerujuk_kode', $data["rujukan"]["provPerujuk"]["kode"]);
        $this->db->set('provPerujuk_nama', $data["rujukan"]["provPerujuk"]["nama"]);

        $this->db->set('ppk_asal', $data["rujukan"]["peserta"]["provUmum"]["kdProvider"]);
        $this->db->set('nama_ppk', $data["rujukan"]["peserta"]["provUmum"]["nmProvider"]);
        $this->db->set('kode_ppk_asal', $data["rujukan"]["peserta"]["provUmum"]["kdProvider"]);
        $this->db->set('nama_ppk_asal', $data["rujukan"]["peserta"]["provUmum"]["nmProvider"]);

        $this->db->set('ppk_pelayanan', "1111R010");

        $this->db->set('kode_diagnosaawal', $data["rujukan"]["diagnosa"]["kode"]);
        $this->db->set('nama_diagnosaawal', $data["rujukan"]["diagnosa"]["nama"]);
        $this->db->set('table_source', "t_pendaftaran");
        $this->db->where('id', $id);
        $this->db->update('t_sep');
        return $this->db->affected_rows();
    }

    public function savePengajuanSEP($input)
    {

        $user           =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data["idxdaftar"]          = $input["idx"];
        $data["nomr"]               = $input["nomr"];
        $data["jenispelayanan"]     = $input["jenislayanan"];
        $data["tglsep"]             = date('Y-m-d', strtotime(str_replace('/', '-', $input["tx_tglsep"])));
        $data["nokartu"]            = $input["tx_nopesertabpjs"];
        $data["keterangan"]         = $input["txt_keterangan"];
        $data["user"]               = $user["firstname"] . " " . $user["lastname"];
        $data["status"]             = "Pengajuan";
        $this->db->insert('t_persetujuansep', $data);
        return $this->db->affected_rows();
    }

    public function simpanApproval($input)
    {
        $user   =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->set('tglaproval', date('Y-m-d H:i:s'));
        $this->db->set('useraprov', $user["firstname"] . " " . $user["lastname"]);

        $this->db->where('idxdaftar', $input["idx"]);
        $this->db->where('jenispelayanan', $input["jenislayanan"]);
        $this->db->update('t_persetujuansep');
    }

    public function manualSAVE($input)
    {
        $this->db->trans_begin();
        $data["idx"]                = $input["idx"];
        $data["faskes_id"]          = $input["cb_asalrujukan"];
        $data["nomer_sep"]          = $input["nomer_sep"];
        $data["no_kartubpjs"]       = $input["no_kartubpjs"];
        $data["nomr"]               = $input["nomr"];
        $data["jenis_layanan"]      = $input["jenis_layanan"];
        $this->db->insert('t_sep', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $alert = "danger";
            $message = "Proses Posting SEP Manual Gagal";
        } else {
            $this->db->trans_commit();
            $alert = "success";
            $message = "Proses Posting SEP Manual Berhasil";
        }

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-' . $alert . '" role="alert">' . $message . '</div>'
        );
    }
}
