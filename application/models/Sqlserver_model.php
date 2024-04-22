<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sqlserver_model  extends CI_Model
{
    protected $db_simrs;
    function __construct()
    {
        parent::__construct();
        $this->db_simrs = $this->load->database('dbsqlsrv', TRUE);
    }

    function cek()
    {
        $response =  $this->db_simrs->get('Sysmex.dbo.TLabOrder')->result_array();
        return $response;
    }
}
