<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokterjaga_model  extends CI_Model
{

    public function getListDokterjaga($kodePoli)
    {
        if ($kodePoli == null) {
            $query = "  SELECT              a.*, b.NAMADOKTER FROM simrs2012.m_dokter_jaga a
                        LEFT OUTER JOIN     m_dokter b ON (a.kddokter= b.KDDOKTER)
                        WHERE               length(b.NAMADOKTER)>1
                        AND                 a.kdpoly = 9
                        ORDER BY            b.NAMADOKTER ASC";
        } else {
            $query = "  SELECT              a.*, b.NAMADOKTER FROM simrs2012.m_dokter_jaga a
                        LEFT OUTER JOIN     m_dokter b ON (a.kddokter= b.KDDOKTER)
                        WHERE               length(b.NAMADOKTER)>1
                        AND                 a.kdpoly = $kodePoli
                        ORDER BY            b.NAMADOKTER ASC";
        }
        return $this->db->query($query)->result_array();
    }

    public function getDokterjaga($limit, $start, $keyword = null, $poli = null, $tanggal = null, $tanggalcari = null, $carabayar = null, $batal = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('m_dokter_jaga.id,m_dokter_jaga.kdpoly,m_dokter_jaga.kddokter');
        $this->db->select('m_dokter.NAMADOKTER');
        $this->db->select('m_poly.nama as poly');
        if ($keyword) {
            $where = "(m_dokter.NAMADOKTER LIKE '%" . $keyword . "%')";
            $this->db->where($where, NULL, FALSE);
        }
        if ($poli) {
            $this->db->where("m_dokter_jaga.kdpoly", $poli);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->join('m_dokter', 'm_dokter_jaga.kddokter = m_dokter.KDDOKTER', 'left outer');
        $this->db->join('m_poly', 'm_dokter_jaga.kdpoly = m_poly.kode', 'left outer');
        return $this->db->get('m_dokter_jaga')->result_array();
    }

    public function getDokterjagadetail($limit, $start, $keyword = null, $kddokter, $bulan = null, $tahun = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('dokter_detail_hari.id_dokter_detail_hari,
            dokter_detail_hari.tanggal');
        if ($bulan) {
            if ($tahun) {
                $this->db->where("SUBSTRING(dokter_detail_hari.tanggal,6,2)", $bulan);
                $this->db->where("SUBSTRING(dokter_detail_hari.tanggal,1,4)", $tahun);
            }
        }
        $this->db->order_by('dokter_detail_hari.id_dokter_detail_hari', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('simrs.dokter_detail_hari')->result_array();
    }

    public function getHari($limit, $start, $bulan = null, $tahun = null, $batal = null)
    {
        if ($tahun == "") {
            $thn = date('Y'); //Mengambil tahun saat ini
            $bln = date('m'); //Mengambil bulan saat ini
        } else {
            $thn = $tahun;
            $bln = $bulan;
        }
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        $hari = array();

        for ($i = 1; $i < $tanggal + 1; $i++) {
            $hari[] = $i . " ";
        }
        return $hari;
    }

    public function getDokterJagaPoliKlinik($poliklinik = 2, $tanggal, $bulan, $tahun)
    {
        $queryMenu = "SELECT * FROM t_dokterjaga where month(tanggal) = " . $bulan . " and year(tanggal) = " . $tahun . " and kd_poli = " . $poliklinik . "";
        return $this->db->query($queryMenu)->result_array();
    }

    public function getTotalDayInmonth($bulan, $tahun)
    {
        if ($bulan) {
            $bln = $bulan;
        } else {
            $bln = date('m');
        }

        if ($tahun) {
            $thn = $tahun;
        } else {
            $thn = date('Y');
        }

        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        $hari = array();

        for ($i = 1; $i <= $tanggal; $i++) {
            $hari[] = $i . " ";
        }
        return $hari;
    }

    public function getDetailsDokterJaga($id)
    {
        if ($id) {
            $this->db->where("t_dokterjaga._id", $id);
            return $this->db->get('t_dokterjaga')->row_array();
        }
    }


    public function updateKuota($id, $data)
    {
        if ($id) {
            $payload = array(
                'kuota' => $data["kuota"]
            );

            $this->db->where('_id', $id);
            $this->db->update('t_dokterjaga', $payload);
            return $this->db->affected_rows();
        }
    }

    public function getDokterBpjs($dokter,$namahari)
    {
        $queryMenu = "SELECT 
                        z.id, z.jadwal, z.jam_praktek, z.kuota_jkn, z.kuota_nonjkn, y.mapping_dokter_bpjs
                    FROM
                        simrs2012.m_dokter_praktek z
                            LEFT JOIN
                        simrs.master_login y ON z.kddokter = y.kddokter
                    WHERE
                        z.kddokter = '$dokter' AND z.jadwal = '$namahari'
                            AND y.userlevelid = 121
                            AND y.mapping_dokter_bpjs IS NOT NULL
                            AND y.kode_spesialis IS NOT NULL";
        return $this->db->query($queryMenu)->result_array();
    }

    public function getSisaJKN($tanggal,$dokter)
    {
        $queryMenu = "SELECT 
                        COUNT(*) AS jml
                        FROM
                        simrs2012.t_pendaftaran a
                            LEFT JOIN
                        simrs.master_login b ON a.kddokter = b.kddokter
                            AND b.kddokter IS NOT NULL
                            AND b.userlevelid = 121
                            AND b.kode_spesialis IS NOT NULL
                            LEFT JOIN
                        simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
                        WHERE a.tglreg=$tanggal and b.mapping_dokter_bpjs=$dokter and c.jenispasien='JKN'";
        return $this->db->query($queryMenu)->result_array();
    }

    public function getSisaNonJKN($tanggal,$dokter)
    {
        $queryMenu = "SELECT 
                        COUNT(*) AS jml
                        FROM
                        simrs2012.t_pendaftaran a
                            LEFT JOIN
                        simrs.master_login b ON a.kddokter = b.kddokter
                            AND b.kddokter IS NOT NULL
                            AND b.userlevelid = 121
                            AND b.kode_spesialis IS NOT NULL
                            LEFT JOIN
                        simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
                        WHERE a.tglreg=$tanggal and b.mapping_dokter_bpjs=$dokter and c.jenispasien='NON JKN'";
        return $this->db->query($queryMenu)->result_array();
    }
}
