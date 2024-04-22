<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluhan_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getData($limit, $start,$dtanggalcari = NULL,$stanggalcari =NULL)
	{

		if ($dtanggalcari) {
			if ($stanggalcari) {
				$where = 'substring(tanggal, 1, 10) BETWEEN "'. date('Y-m-d', strtotime($dtanggalcari)). '" and "'. date('Y-m-d', strtotime($stanggalcari)).'"';
				$this->db->where($where,NULL,FALSE);
			} else {
				$where = "substring(t_working_record.tanggal,1,10) = '".$dtanggalcari."'";
				$this->db->where($where,NULL,FALSE);	
			}

		} if ($stanggalcari) {
			if ($dtanggalcari) {
				$where = 'substring(tanggal, 1, 10) BETWEEN "'. date('Y-m-d', strtotime($dtanggalcari)). '" and "'. date('Y-m-d', strtotime($stanggalcari)).'"';
				$this->db->where($where,NULL,FALSE);
			} else {
				$where = "substring(t_working_record.tanggal,1,10) = '".$stanggalcari."'";
				$this->db->where($where,NULL,FALSE);	
			}
		}

        $this->db->limit($limit, $start);
		$this->db->order_by('tanggal', 'DESC');
		// $this->db->order_by('ruangan', 'ASC');
		
		return $this->db->get('t_working_record')->result_array();
	}

	public function insert_Data($input)
	{
		$data["tanggal"] 		= $input['tanggal'];
		$data["keterangan"] 	= $input['keterangan'];
		$data["ruangan"]		= $input['ruangan'];
		$data["jam_mulai"] 		= $input['jammulai'];
		$data["jam_selesai"] 	= $input['jamselesai'];

		$data["penyebab"] 		= $input['penyebab'];
		$data["solusi"] 		= $input['solusi'];

		$waktu_awal				= strtotime("" . $input['jammulai'] . ":00");
		$waktu_akhir			= strtotime("" . $input['jamselesai'] . ":00");
		$diff					= $waktu_akhir - $waktu_awal;
		$jam 					= floor($diff / 60);

		$data["durasi"]			= $jam;

		if ($jam < 0) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger" role="alert">Gagal Menyimpan !!! Waktu tidak boleh -</div>'
			);
			redirect('keluhan');
		} else {
			$this->db->insert('t_working_record', $data);
		}
	}

	public function delete_Data($table, $where)
	{
		return $this->db->delete($table, $where);
	}

	public function edit_Data($table, $where)
	{
		return $this->db->get_where($table, $where);
	}

	public function update_Data($input)
	{
		$id = $input['txid'];

		$data = array(
			'tanggal' 		=> $input['txtanggal'],
			'keterangan' 	=> $input['txketerangan'],
			'ruangan'		=> $input['txruangan'],
			'penyebab'		=> $input['txpenyebab'],
			'solusi'		=> $input['txsolusi'],
			'jam_mulai' 	=> $input['txjammulai'],
			'jam_selesai' 	=> $input['txjamselesai'],
			'durasi' 		=> (strtotime($input['txjamselesai']) - strtotime($input['txjammulai'])) / floor(60)
		);

		$this->db->where('id', $id);
		$this->db->update('t_working_record', $data);
	}

	public function getKeluhanById($id)

    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('t_working_record.*');
    
        return $this->db->get_where('t_working_record', ['id' => $id])->result_array();
    }

    public function getDataonly()
    {
    	# code...
    	$this->db->order_by('userlevelname','ASC');
    	$query = $this->db->get('simrs.userlevels')->result_array();

    	return $query;
    }

    public function getDataWhereDate($tglawal,$tglakhir)
    {
    	# code...
		$where = 'tanggal BETWEEN "'. date('Y-m-d', strtotime($tglawal)). '" and "'. date('Y-m-d', strtotime($tglakhir)).'"';
    	$this->db->where($where);
        $this->db->order_by('tanggal', 'ASC');

    	return $this->db->get('t_working_record')->result_array();
    	// $this->db->where('t_working_record.tanggal');
    	
    }


}
