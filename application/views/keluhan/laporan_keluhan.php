<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title><?= $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


    <style>
        table {

        }
    </style>
</head>

<body>

  <p align="center">LAPORAN KELUHAN BULAN JULI 2020</p>

      </table>
      <table border="1">
        <tr>
          <td align="center" width="5%">N0</td>
          <td align="center" width="15%">TANGGAL</td>
          <td align="center" width="15%">RUANG</td>
          <td align="center" width="25%">KETERANGAN</td>
          <td align="center" width="25%">PENYEBAB</td>
          <td align="center" width="25%">SOLUSI</td>
        </tr>
        <?php $no = 1;
        foreach ($data as $d) :
        ?>

        <tr>
          <td><?= $no++; ?></td>
          <td><?= substr($d['tanggal'], 0, 10);?></td>
          <td><?= getPoli($d["ruangan"], "userlevelname"); ?></td>
          <td><?= $d['keterangan'];?></td>
          <td><?= $d['penyebab'];?></td>
          <td><?= $d['solusi'];?></td>
        </tr>
      <?php endforeach;?>
    </table>
</body>

</html>