<?php


/**
 * Create a new PDF document
 *
 * @param string $mode
 * @param string $format
 * @param int $font_size
 * @param string $font
 * @param int $margin_left
 * @param int $margin_right
 * @param int $margin_top (Margin between content and header, not to be mixed with margin_header - which is document margin)
 * @param int $margin_bottom (Margin between content and footer, not to be mixed with margin_footer - which is document margin)
 * @param int $margin_header
 * @param int $margin_footer
 * @param string $orientation (P, L)
 * new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
*/

$hhtml = '
<htmlpageheader name="myHTMLHeaderOdd" style="display:none">
<div style="background-color:#BBEEFF; font-size:0.6em; line-height:1.2em" align="center"><font face="sans-serif">
	<b>RS BANYUMANIK</b><br>
	Jl. Bina Remaja No. 61 Semarang - (024) 7471519
</div>
</htmlpageheader>
<sethtmlpageheader name="myHTMLHeaderOdd" page="O" value="on" show-this-page="1" />
';

include("../mpdf.php");

$mpdf=new mPDF("utf-8", array(75,50),"","",1,1,7,1,1,1,"P"); 

$mpdf->WriteHTML($hhtml);


$mpdf->WriteHTML('
<style> 
td{ line-height: 0.8em; font-size:0.7em; }
tbody (border-bottom: 1px solid #000; )
@page {
        margin-top: 50mm; 
}
.tebal {font-weight:bold;}
div.obate {
        font-face: "sans-serif";
        font-size: 0.7em;
		text-align: center;
		line-height: 1.2em;
}
</style>');

$mpdf->WriteHTML('<font face="sans-serif"><table width="100%"  style="border-bottom:0.5px solid black;"><tbody>');

$mpdf->WriteHTML('
		<tr>
			<td width="17%">Tanggal</td>
			<td width="3%">:</td>
			<td colspan="3" width="57%">11/03/2019</td>
		</tr>
		<tr>
			<td>Dokter</td>
			<td>:</td>
			<td colspan="3">dr. Rahmawati Sp.A</td>
		</tr>
		<tr>
			<td width="17%">No.cm</td>
			<td width="3%">:</td>
			<td width="45%">101010</td>
			<td width="35%">t.lahir : 10/10/2010</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td colspan="3" class="tebal">Anggito Jalmowono Numpak Boto limo</td>
		</tr>');

$mpdf->WriteHTML('</tbody></table></font>');

$mpdf->WriteHTML('<div class="obate tebal">METHYL PREDNISOLON 4 MG (10)</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Setelah Makan</div>');
$mpdf->WriteHTML('<div class="obate">harus dihabiskan</div>');
$mpdf->WriteHTML('<table width="100%"><tbody><tr>
	<td width="10%" class="tebal">ED : </td>
	<td width="15%">11/2021</td>
	<td width="50%"></td>
	<td width="10%" class="tebal">BUD</td>
	<td width="15%">11/11/2021</td>
	</tr></tbody></table>');
$mpdf->WriteHTML('<pagebreak/>');
$mpdf->WriteHTML('<font face="sans-serif"><table width="100%"  style="border-bottom:0.5px solid black;"><tbody>');

$mpdf->WriteHTML('
		<tr>
			<td width="17%">Tanggal</td>
			<td width="3%">:</td>
			<td colspan="3" width="57%">11/03/2019</td>
		</tr>
		<tr>
			<td>Dokter</td>
			<td>:</td>
			<td colspan="3">dr. Rahmawati Sp.A</td>
		</tr>
		<tr>
			<td width="17%">No.cm</td>
			<td width="3%">:</td>
			<td width="45%">101010</td>
			<td width="35%">t.lahir : 10/10/2010</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td colspan="3" class="tebal">Anggito Jalmowono Numpak Boto limo</td>
		</tr>');

$mpdf->WriteHTML('</tbody></table></font>');

$mpdf->WriteHTML('<div class="obate tebal">METHYL PREDNISOLON 4 MG (10)</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Setelah Makan | Sebelum tidur | Sak karepmu</div>');
$mpdf->WriteHTML('<div class="obate">harus dihabiskan</div>');
$mpdf->WriteHTML('<table width="100%"><tbody><tr>
	<td width="10%" class="tebal">ED : </td>
	<td width="15%">11/2021</td>
	<td width="50%"></td>
	<td width="10%" class="tebal">BUD</td>
	<td width="15%">11/11/2021</td>
	</tr></tbody></table>');
$mpdf->WriteHTML('<pagebreak/>');	
$mpdf->WriteHTML('<font face="sans-serif"><table width="100%"  style="border-bottom:0.5px solid black;"><tbody>');

$mpdf->WriteHTML('
		<tr>
			<td width="17%">Tanggal</td>
			<td width="3%">:</td>
			<td colspan="3" width="57%">11/03/2019</td>
		</tr>
		<tr>
			<td>Dokter</td>
			<td>:</td>
			<td colspan="3">dr. Rahmawati Sp.A</td>
		</tr>
		<tr>
			<td width="17%">No.cm</td>
			<td width="3%">:</td>
			<td width="45%">101010</td>
			<td width="35%">t.lahir : 10/10/2010</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td colspan="3" class="tebal">Anggito Jalmowono Numpak Boto limo</td>
		</tr>');

$mpdf->WriteHTML('</tbody></table></font>');

$mpdf->WriteHTML('<div class="obate tebal">METHYL PREDNISOLON 4 MG (10)</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Pk. 06.00 - 07.00 = 2 tablet</div>');
$mpdf->WriteHTML('<div class="obate">Setelah Makan</div>');
$mpdf->WriteHTML('<div class="obate tebal">harus dihabiskan</div>');
$mpdf->WriteHTML('<table width="100%"><tbody><tr>
	<td width="10%" class="tebal">ED : </td>
	<td width="15%">11/2021</td>
	<td width="50%"></td>
	<td width="10%" class="tebal">BUD</td>
	<td width="15%">11/11/2021</td>
	</tr></tbody></table>');
$mpdf->Output();
exit;
//==============================================================
//==============================================================


?>