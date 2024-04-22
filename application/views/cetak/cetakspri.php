<?php
  
  function tanggal_indo($tanggal){
  $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  }
// print_r($noSuratKontrol);
// die();
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>SURAT RENCANA INAP</title>

  <style type="text/css">
    @page {
      margin: 20px;
      font-size: 12px;
      font-family: Gotham, Helvetica Neue, Helvetica, Arial, " sans-serif";
    }
  </style>


</head>

<body>
  <table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="34%" align="left"><img src="http://localhost/simrs2022/assets/img/logobpjs.png" width="222" height="34" alt="" /></td>
      <td width="35%" align="left" style="font-size: 15px"><b>SURAT RENCANA INAP<br>RSUD AJIBARANG</b></td>
      <td width="31%" valign="top" align="left" style="font-size: 15px">No. <?= $noSuratKontrol; ?></td>
    </tr>
  </table><br><br>
  
  <table width="100%" border="0" style="font-size: 15px">
    <tbody>
      <tr>
        <td colspan="3">Mohon Pemeriksaan dan Penanganan Lebih Lanjut</td>
      </tr>
      <tr>
        <td width="19%">No.Kartu</td>
        <td width="1%">:</td>
        <td width="80%"><?= $noKartu; ?></td>
      </tr>
      <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?= $pasien['NAMA']; ?> (<?= ($pasien['JENISKELAMIN']); ?>)</td>
      </tr>
      <tr>
        <td>Nomer RM</td>
        <td>:</td>
        <td><?= $pasien['NOMR']; ?></td>
      </tr>
      <tr>
        <td>Tgl.Lahir</td>
        <td>:</td>
        <td><?= $pasien['TGLLAHIR']; ?></td>
      </tr>
      <tr>
        <td>Diagnosa</td>
        <td>:</td>
        <td></td>
      </tr>
      <tr>
        <td>Rencana Inap</td>
        <td>:</td>
        <td><?= tanggal_indo($tglRencanaKontrol); ?></td>
      </tr>
      <tr>
        <td colspan="3">Demikian atas bantuannya, diucapkan terima kasih.</td>
      </tr>
    </tbody>
  </table>
  
  <table width="100%" border="0">
  <tbody>
    <tr>
      <td width="33%">&nbsp;</td>
      <td width="34%">&nbsp;</td>
      <td width="33%" align="center">Mengetahui DPJP,</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><?= getDokterMapping($kodeDokter, "pd_nickname"); ?></td>
    </tr>
    <tr>
      <td align="left" style="font-size: 7px">Tgl.Entri <?= tanggal_indo($tglTerbitKontrol); ?></td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
  </tbody>
</table>


</body>

</html>
