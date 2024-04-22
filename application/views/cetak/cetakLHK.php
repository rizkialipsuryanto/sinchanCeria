<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
</head>
<?php 
  $userid = $user;
  // print_r($userid);
  // print_r($tasks);
  // $queryMenu = "SELECT m_tasks_detail.tasks_detail FROM m_tasks_detail
  //               left join m_tasks on m_tasks.id = m_tasks_detail.id_tasks
  //               where m_tasks.isActive = '1' and m_tasks_detail.user_id = '".$userid['uid']."'";

  // $kegiatanmaster = $this->db->query($queryMenu)->result_array();

  // print_r($kegiatanmaster);
?>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
    <tbody>
      <tr>
        <td width="100%" align="center"><span class="header"><strong><b>PEMERINTAH KABUPATEN BANYUMAS 
        <br>RUMAH SAKIT UMUM DAERAH AJIBARANG
        <br>LAPORAN HASIL KERJA PEGAWAI NON PNS
        </b></strong></span></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td style="text-align:left;" vtext-align="top"></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>

  <table width="100%" style="border:0;" cellpadding="0">
    <tbody>
      <tr>
        <td width="50%"><span class="header">NAMA : <?php echo $user['pd_nickname']; ?></span></td>
      </tr>
      <br>
      <tr>
        <td width="50%"><span class="header">BAGIAN : <?= getBidang($tasks[0]['bidang_id'], "bidang"); ?></span></td>
      </tr>
      <tr>
        <td width="50%"><span class="header">RUANG : <?= getRuangan($tasks[0]['ruang'], "userlevelname"); ?></span></td>
      </tr>
      <br>
      <tr>
        <td width="50%"><span class="header">BULAN, TAHUN : <?php echo getBulan($bulan, "bulan_nama"); ?>, <?php echo $tahun; ?></span></td>
      </tr>
        <!-- <td width="50%"><span class="header">BAGIAN : </span></td>
        <br>
        <td width="50%"><span class="header">RUANG : </span></td>
        <br>
        <td width="50%"><span class="header">BULAN, TAHUN : </span></td> -->
      <!-- </tr> -->
      <!-- <tr>
        <td height="20">&nbsp;</td>
        <td style="text-align:left;" vtext-align="top"></td>
        <td>&nbsp;</td>
      </tr> -->
    </tbody>
  </table>

<table width="100%" cellspacing="0" border="1"  class="penulisan">
  <tbody>
    <tr>
      <td rowspan="2"  width="3%" align="center">No</td>
      <td rowspan="2" align="center">Kegiatan</td>
      <td colspan="31" align="center">Tanggal</td>
      <td rowspan="2" width="5%" align="center">Total</td>
    </tr>
 
    <tr>
      <td width="2%" align="center">1</td>
      <td width="2%" align="center">2</td>
      <td width="2%" align="center">3</td>
      <td width="2%" align="center">4</td>
      <td width="2%" align="center">5</td>
      <td width="2%" align="center">6</td>
      <td width="2%" align="center">7</td>
      <td width="2%" align="center">8</td>
      <td width="2%" align="center">9</td>
      <td width="2%" align="center">10</td>
      <td width="2%" align="center">11</td>
      <td width="2%" align="center">12</td>
      <td width="2%" align="center">13</td>
      <td width="2%" align="center">14</td>
      <td width="2%" align="center">15</td>
      <td width="2%" align="center">16</td>
      <td width="2%" align="center">17</td>
      <td width="2%" align="center">18</td>
      <td width="2%" align="center">19</td>
      <td width="2%" align="center">20</td>
      <td width="2%" align="center">21</td>
      <td width="2%" align="center">22</td>
      <td width="2%" align="center">23</td>
      <td width="2%" align="center">24</td>
      <td width="2%" align="center">25</td>
      <td width="2%" align="center">26</td>
      <td width="2%" align="center">27</td>
      <td width="2%" align="center">28</td>
      <td width="2%" align="center">29</td>
      <td width="2%" align="center">30</td>
      <td width="2%" align="center">31</td>
    </tr>
    
    <?php 
      $no = 1;
      foreach ($kegiatan as $key) {?>
      <tr>
        <td><center><?php echo $no++ ?></center></td>
        <td><?php echo $key['tasks_detail'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
  </table>
  <br>
  <table width="100%" style="border:0;" cellpadding="0">
    <tbody>
      <tr>
        <td width="50%" align="center"><span class="header">Mengetahui 
        <br>KEPALA INSTALASI TEKNOLOGI INFORMATIKA
        <!-- <br>LAPORAN HASIL KERJA PEGAWAI NON PNS -->
        </span></td>
        <td width="50%" align="center"><span class="header">Ajibarang, 31 Desember 2021 
        <br>Pegawai Non PNS
        </span></td>
      </tr>
      <!-- <tr>
        <td height="20">&nbsp;</td>
        <td style="text-align:left;" vtext-align="top"></td>
        <td>&nbsp;</td>
      </tr> -->
    </tbody>
  </table>
</body>
</html>