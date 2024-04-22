<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?></title>

    <style type="text/css">
        @page {
            /* size: 21cm 14cm;
            margin: 20px; */
        }

        body {
            /* margin: 10px; */
            font-family: 'Courier';
            font-size: 16px;
        }

        .style11 {
            font-size: 10px;
        }

        .fontNoSEP {
            font-size: 23px;
            font-weight: bold;
        }

        .header {
            font-size: 20px;
            font-weight: bold;
        }
    </style>

</head>

<body onload="window.print()">
    <table width="100%" style="border:0;" cellpadding="0">
        <tbody>
            <tr>
                <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="logobpjs.png" width="200" height="50" alt="" /></td>
                <td width="3%" height="20">&nbsp;</td>
                <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA

                            <br>RSUD AJIBARANG
                        </strong></span></td>
                <td width="4%">&nbsp;</td>
            </tr>
            <tr>
                <td height="20">&nbsp;</td>
                <td style="text-align:left;" vtext-align="top"></td>
                <td>&nbsp;</td>
            </tr>
        </tbody>

    </table>

    <?php if ($sep["metaData"]["code"] == 200) : ?>

        <table width="100%" style="border:0;" cellspacing="4px" cellpadding="0">
            <tbody>
                <tr>
                    <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                    <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                    <td style="text-align:left;" vtext-align="bottom">
                        <span class="fontNoSEP">&nbsp;<?= $sep["response"]["noSep"]; ?></span> </td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong><?= $peserta["response"]["peserta"]["informasi"]["prolanisPRB"]; ?></strong></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.SEP</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td width="40%" style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["tglSep"]; ?></td>
                    <td width="15%" style="text-align:left;" vtext-align="top">Peserta</td>
                    <td width="1%" style="text-align:left;" vtext-align="top">:</td>
                    <td width="35%" style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["jnsPeserta"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Kartu</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["noKartu"]; ?> (<?= $sep["response"]["peserta"]["noMr"]; ?>)</td>
                    <td style="text-align:left;" vtext-align="top">COB</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["asuransi"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["nama"]; ?>, (<?= $sep["response"]["peserta"]["kelamin"]; ?>)</td>
                    <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["jnsPelayanan"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["tglLahir"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["peserta"]["hakKelas"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $peserta["response"]["peserta"]["mr"]["noTelepon"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["penjamin"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["poli"]; ?>, <?= $sep["response"]["poliEksekutif"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">No.Rujukan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["noRujukan"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">FaskesPerujuk</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $peserta["response"]["peserta"]["provUmum"]["kdProvider"]; ?>/<?= $peserta["response"]["peserta"]["provUmum"]["nmProvider"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["diagnosa"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Catatan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["response"]["catatan"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" style="border:0;" cellspacing="5px" cellpadding="0">
            <tbody>
                <tr>
                    <td width="72%">
                        <p class="style11">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan
                            <br>*SEP bukan sebagai bukti penjamin peserta .

                            <?php if ($rujukan["response"] != null) : ?>
                                <br>tgl berlaku rujukan <?= $rujukan["response"]["rujukan"]["tglKunjungan"]; ?> - s/d -
                                <?= date('Y-m-d', strtotime($rujukan["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')); ?>
                            <?php endif; ?>

                            <br>Cetakan Ke 1
                            <br>Dibuat Pertama Oleh:


                        </p>
                    </td>
                    <td width="1%">&nbsp;</td>
                    <td width="27%"><span class="style11">Pasien/Keluarga Pasien</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><span class="style11"><?= $seplokal["user"]; ?></span></td>
                    <td>&nbsp;</td>
                    <td><span class="style12"><span class="style11"><?= $pendaftaran["PENANGGUNGJAWAB_NAMA"]; ?></span></span></td>
                </tr>
            </tbody>
        </table>
    <?php else : ?>
        <?= $sep["metaData"]["message"]; ?>
    <?php endif; ?>



</body>

</html>