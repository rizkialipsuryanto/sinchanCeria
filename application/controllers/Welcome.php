<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$this->load->library('table');
		$this->load->library('form_validation');
		// $this->load->helper('url');
		// $this->load->library(array('table', 'form_validation'));
		$this->load->helper('form');
		$this->load->helper('url');
		// $this->load->helper(array('form', 'url'));
		// $this->load->model('Blog_model', '', TRUE);
		$this->load->model('Blog_model', 'pasien');
		// $this->load->model('Blog_model', '', TRUE);
		// $this->load->library('pagination');
		$this->load->library('pagination');
		$this->load->helper('util');
		$this->load->model('Pendaftaran_model', 'pendaftaran');
	}

	function index()
	{
		$data["title"] = "SIMRS";
		$data["subtitle"] = "Dashboard Rawat Jalan Hari Ini";
		$data['user']       =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$data['countOutpatientRegister']   =   $this->pendaftaran->countOutpatientRegister();
		$data['countOutpatientSEP']   =   $this->pendaftaran->countOutpatientSEP();
		$data['countNewOutPatient']   =   $this->pendaftaran->countNewOutPatient();
		$data['graphOfNowWeeks']   =   $this->pendaftaran->graphCounterPatentsOfWeeks(0);
		$data['graphOfLastWeeks']   =   $this->pendaftaran->graphCounterPatentsOfWeeks(7);
		$data['YearlyGraphPatientStatusMark_New']   =   $this->pendaftaran->YearlyGraphPatientStatusMark(1);
		$data['YearlyGraphPatientStatusMark_Old']   =   $this->pendaftaran->YearlyGraphPatientStatusMark(0);
		$data["countOutPatientRegisterGroupByDoctor"]  =   $this->pendaftaran->countOutPatientRegisterGroupByDoctor();
		$data["countOutPatientGroupByPoliklinik"]  =   $this->pendaftaran->countOutPatientGroupByPoliklinik();

		$this->template->show('blog_template', $data);
	}



	function chart()
	{
		$data["title"] = "SIMRS";
		$data["subtitle"] = "Dashboard Rawat Jalan Hari Ini";
		$data['user']       =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$this->template->show('crud_view', $data);
	}
	function next()
	{
		$data['user']       =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$options = array(
			'cluster' => 'ap1',
			'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
			'7f5cdf6976d8673b4e56',
			'2a3b97afbd8471fd5525',
			'1044575',
			$options
		);
		$data['message'] = 'hello world';
		$pusher->trigger('my-channel', 'my-event', $data);
		echo json_encode($data);
		die();
		$this->template->show('layouts/next', array('title' => 'wrewqrqwrqewr'));
	}

	function pasien($offset = 0, $order_column = 'id', $order_type = 'asc')
	{
		$data['title'] = 'SIMRS';
		$data['subtitle'] = 'RSUDAJIBARANG';
		$data['user']       =   $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'id';
		if (empty($order_type)) $order_type = 'asc';
		//TODO: check for valid column

		// load data siswa

		// // generate pagination

		$config['base_url'] = site_url('welcome/pasien/');
		$config['total_rows'] = $this->pasien->count_all();
		$config['per_page'] = 10; //$this->limit;
		$config['uri_segment'] = 3;
		// $config['anchor_class'] = 'class="ajax" ';
		// $config['attributes'] = array('class' => 'ajax');

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$siswas = $this->pasien->get_paged_list(10, $offset, $order_column, $order_type)->result();


		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
			'No',
			anchor('welcome/pasien/' . $offset . '/NOMR/' . $new_order, 'NOMR', array('class' => 'ajax')),
			anchor('welcome/pasien/' . $offset . '/NAMA/' . $new_order, 'NAMA', array('class' => 'ajax')),
			anchor('welcome/pasien/' . $offset . '/JENISKELAMIN/' . $new_order, 'Jenis Kelamin', array('class' => 'ajax')),
			anchor('welcome/pasien/' . $offset . '/TGLLAHIR/' . $new_order, 'Tanggal Lahir (dd-mm-yyyy)', array('class' => 'ajax')),
			'Actions'
		);

		$i = 0 + $offset;
		foreach ($siswas as $siswa) {
			$this->table->add_row(
				++$i,
				$siswa->NOMR,
				$siswa->NAMA,
				strtoupper($siswa->JENISKELAMIN) == 'L' ?
					'Laki-Laki' : 'Perempuan',
				date('d-m-Y', strtotime(
					$siswa->TGLLAHIR
				)),
				anchor(
					'siswa/view/' . $siswa->id,
					'view',
					array('class' => 'view')
				) . ' ' .
					anchor(
						'siswa/update/' . $siswa->id,
						'update',
						array('class' => 'update')
					) . ' ' .
					anchor(
						'siswa/delete/' . $siswa->id,
						'delete',
						array(
							'class' => 'delete',
							'onclick' => "return confirm('Apakah Anda yakin ingin menghapus data siswa?')"
						)
					)
			);
		}


		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'thead_open'            => '<thead>',
			'thead_close'           => '</thead>',

			'heading_row_start'     => '<tr>',
			'heading_row_end'       => '</tr>',
			'heading_cell_start'    => '<th>',
			'heading_cell_end'      => '</th>',

			'tbody_open'            => '<tbody>',
			'tbody_close'           => '</tbody>',

			'row_start'             => '<tr>',
			'row_end'               => '</tr>',
			'cell_start'            => '<td>',
			'cell_end'              => '</td>',

			'row_alt_start'         => '<tr>',
			'row_alt_end'           => '</tr>',
			'cell_alt_start'        => '<td>',
			'cell_alt_end'          => '</td>',

			'table_close'           => '</table>'
		);

		$this->table->set_template($template);
		$data['table'] = $this->table->generate();

		// if ($this->uri->segment(3) == 'delete_success')
		// 	$data['message'] = 'Data berhasil dihapus';
		// else if ($this->uri->segment(3) == 'add_success')
		// 	$data['message'] = 'Data berhasil ditambah';
		// else
		// 	$data['message'] = '';
		// // load view
		// // $this->load->view('siswaList', $data);
		$this->template->show('layouts/cek', $data);
	}
}
