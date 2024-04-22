<?php if ($rujukan["error"] == 1 or  $kepesertaan["error"] == 1 || $kepesertaan["error"] == 1) : ?>

    <h1>Server BPJS Sedang Bermasalah</h1>
<?php else :


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title; ?></title>
        <style>
            body {

                font-size: 13px;
                font-family: Arial, Helvetica, sans-serif;
            }

            @page {
                size: 21cm 14cm;
                margin: 20px;
            }

            .fontNoSEP {
                font-size: 16px;
                font-weight: bold;
            }

            .header {
                font-size: 13px;
                font-weight: bold;
            }
        </style>
    </head>

    <body onload="window.print()">
        <table width="100%" cellpadding="0">
            <tbody>
                <tr>
                    <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top">
                        <img src="<?= IMAGE_BASE_URL; ?>logobpjs.png" onerror="this.onerror=null; this.src='logobpjs.png'" width="200" height="50" alt="" />
                    </td>
                    <td width="3%" height="20">&nbsp;</td>
                    <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA <br>RSUD AJIBARANG : </strong></span></td>
                    <td width="4%">&nbsp;</td>
                </tr>
                <tr>
                    <td height="20">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" cellspacing="4px" cellpadding="0">
            <tbody>
                <tr>
                    <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                    <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                    <td style="text-align:left;" vtext-align="bottom">
                        <span class="fontNoSEP">&nbsp;<?= $sep["nomer_sep"]; ?></span> </td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong><?= $sep["prolanisPRB"]; ?></strong></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.SEP</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td width="40%" style="text-align:left;" vtext-align="top">&nbsp;<?= date('Y-m-d', strtotime(str_replace('/', '-', $sep["tgl_sep"]))); ?></td>
                    <td width="15%" style="text-align:left;" vtext-align="top">Peserta</td>
                    <td width="1%" style="text-align:left;" vtext-align="top">:</td>
                    <td width="35%" style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["jenisPeserta_keterangan"] ? $sep["jenisPeserta_keterangan"] : $kepesertaan["response"]["peserta"]["jenisPeserta"]["keterangan"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Kartu</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["no_kartubpjs"]; ?> (<?= $sep["nomr"]; ?>) </td>
                    <td style="text-align:left;" vtext-align="top">COB</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["nama"]; ?> (<?= $kepesertaan["response"]["peserta"]["sex"]; ?>)</td>
                    <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?php if ($sep["jenis_layanan"] == 1) : ?> Rawat Inap <?php else : ?> Rawat Jalan<?php endif; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["tglLahir"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["hakKelas"]["keterangan"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;02816570004</td>
                    <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $detailsep["response"]["penjamin"]; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $detailsep["response"]["poli"]; ?>, <?= $detailsep["response"]["poliEksekutif"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">No.Rujukan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $detailsep["response"]["noRujukan"]; ?></td>
                </tr>




                <tr>
                    <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td colspan="5" style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["nama_diagnosaawal"]; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Catatan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td colspan="2" style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["catatan"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" style="border:0;">
            <tbody>
                <tr>


                    <td width="72%">
                        <p class="style13">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan'
                            <?php if ($sep["jenis_layanan"] == 2) : ?>
                                <?php if ($rujukan != null) : ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <br><b>*Tanggal berlaku rujukan <?= $rujukan["response"]["rujukan"]["tglKunjungan"]; ?> s/d <?= date('Y-m-d', strtotime($rujukan["response"]["rujukan"]["tglKunjungan"] . ' + 88 days')) ?> </b>
                            <br>*SEP bukan sebagai bukti penjamin peserta
                            Cetakan Ke 1 Dibuat Pertama Oleh:
                        </p>
                    </td>

                    <td width="1%">&nbsp; </td>
                    <td width="27%"><span class="style11">Pasien/Keluarga Pasien</span></td>
                </tr>
                <tr>
                    <td>

                        <img id="salinan" width="170" height="90" src="<?= getDetailUser($sep["user_id"], "signature"); ?>" class="resize" alt="tanda tangan petugas">
                        <img src="<?= IMAGE_BASE_URL; ?>cap_rs.png" width="110" height="110" alt="fixed position " title="fixed position" />
                    </td>
                    <td>



                    </td>
                    <td>
                        <img id="salinan" width="170" height="90" src="<?= $sep["signature"]; ?>" class="resize" alt="tanda tangan pasien">

                    </td>
                </tr>
                <tr>
                    <td><span class="style11"><?= getDetailUser($sep["user_id"], "firstname"); ?> ( <?= getDetailUser($sep["user_id"], "lastname"); ?> <?= date('Y-m-d H:i:s') ?> )</span></td>
                    <td>&nbsp;</td>
                    <td><span class="style12"><span class="style11"><?= $penanggungjawab; ?></span></span></td>
                </tr>
            </tbody>
        </table>



    </body>

    </html>
<?php endif; ?>