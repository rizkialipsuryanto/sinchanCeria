<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .fixed {
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: left;
            padding: 3px;
            font-size: 9px;
        }

        .pagebreak {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <?php foreach ($poliklinik as $poli) : ?>
        <h4>Kunjungan Pasien Poli <?= getNamaPoliKlinik($poli["KDPOLY"]); ?></h4>
        <?php $datapendaftaran = getPendaftaranRawatJalanByDateAndPoliklinik($tanggal, $poli["KDPOLY"]); ?>
        <table>
            <tr>
                <td style="width:3%;">&nbsp;No&nbsp;</td>
                <td style="width:15%;">&nbsp;NO SEP </td>
                <td style="width:5%;">&nbsp;NOMR</td>
                <td style="width:25%;" width="22%">&nbsp;&nbsp;&nbsp;NAMA&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;CARA BAYAR </td>
                <td style="width:3%;">&nbsp;B/L</td>
                <td style="width:25%;">&nbsp;DOKTER</td>
                <td>&nbsp;RANAP</td>
                <td>&nbsp;PULANG</td>
            </tr>
            <!-- paste nanti disini -->
            <?php $no = 0;
            foreach ($datapendaftaran as $daftar) : ?>
                <tr>
                    <td><?= ++$no; ?></td>
                    <td>
                        <?php echo getDetailSepByIDXandType(2, $daftar["IDXDAFTAR"], "nomer_sep"); ?>
                    </td>
                    <td><?= $daftar["NOMR"]; ?></td>
                    <td>
                        <?= getDetailPasien($daftar["NOMR"], "NAMA"); ?>
                    </td>
                    <td>
                        <?= getNamaCaraBayar($daftar["KDCARABAYAR"]); ?>
                    </td>
                    <td>
                        <?php if ($daftar["PASIENBARU"] == 1) : ?>
                            B
                        <?php else : ?>
                            L
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= getNamaDokter($daftar["KDDOKTER"]); ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>


        </table>

        <h6>- Ringkasan --</h6>
        <table>
            <tr>
                <td colspan="2">&nbsp;Poli: <?= getNamaPoliKlinik($poli["KDPOLY"]); ?></td>
                <td>Total</td>
                <td>Pasien Baru</td>
                <td>Pasien Lama</td>
            </tr>
            <tr>
                <td width="31%">&nbsp;Jumlah Pasien</td>
                <td width="3%">:</td>
                <td width="20%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal, null, null) ?>&nbsp;&nbsp;</td>
                <td width="24%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal, null, 1) ?>&nbsp;&nbsp;</td>
                <td width="22%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal, null, 0) ?>&nbsp;&nbsp;</td>
            </tr>

            <?php foreach ($carabayar as $cb) : ?>
                <tr>
                    <td width="31%">&nbsp;<?= $cb["NAMA"]; ?></td>
                    <td width="3%">:</td>
                    <td width="20%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal,  $cb["KODE"], null) ?>&nbsp;&nbsp;</td>
                    <td width="24%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal,  $cb["KODE"], 1) ?>&nbsp;&nbsp;</td>
                    <td width="22%">&nbsp;&nbsp;<?= getJumlahTotalPasien($poli["KDPOLY"], $tanggal,  $cb["KODE"], 0) ?>&nbsp;&nbsp;</td>
                </tr>
            <?php endforeach; ?>



        </table>


        <div class="pagebreak"> </div>
    <?php endforeach; ?>

</body>

</html>