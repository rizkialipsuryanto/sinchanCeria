<?php
use Prophecy\Exception\Doubler\ReturnByReferenceException;

defined('BASEPATH') or exit('No direct script access allowed');

class Kota_model  extends CI_Model
{
    public function fetchKotaByProvinsi($idprovinsi)
    {
        /* $list_kota =  $this->db->get_where('m_kota', ['idprovinsi' => $idprovinsi])->result_array();
        $output = '<select class="form-control form-control-sm" id="kabupaten" name="kabupaten"><option value=""> Pilih Kabupaten/Kota</option>';
        if ($list_kota) :
            foreach ($list_kota as $kota) :
                $output .=  "<option value=" . $kota['idkota'] . ">" . $kota['namakota'] . "</option>";
            endforeach;
        endif;

        $output .= " </select>";

        return $output;*/

        return $this->db->get_where('m_kota', ['idprovinsi' => $idprovinsi])->result_array();
    }
}
