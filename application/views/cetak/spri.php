<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?></title>

    <style type="text/css">
        /* @page {
          
            margin-top: 1 cm;
            margin-left: 1 cm;
            margin-right: 1 cm;
            margin-bottom: 1 cm;
        } */

        /* @page {
            size: 21cm 27cm;
            margin-top: 4 cm;
            margin-left: 4 cm;
            margin-right: 4 cm;
            margin-bottom: 4 cm;
        }

        .kopPemda {
            font-size: 11 px;
            font-weight: bold;
        }

        .noSPRI {
            font-size: 20 px;
            font-weight: bold;
        }

        .anakKopPemda {
            font-size: 9 px;

        }

        .KopAdmisionNote {
            font-size: 14 px;
            font-weight: bold;

        }



        .dataSpri {
            font-size: 13 px;
            font-weight: normal;


        }




        .footerTTD {
            font-size: 12 px;


        } */
    </style>

</head>

<body>
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tbody>
            <tr>
                <td width="35%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td width="28%" align="center" valign="middle"><img src="<?= base_url('assets/images/') ?>logobanyumas.png" width="70" height="70" alt="logoBanyumas" /></td>
                                <td width="72%">
                                    <div class="kopPemda">PEMERINTAH KABUPATEN BANYUMAS</br>
                                        RUMAH SAKIT UMUM DAERAH AJIBARANG</br></div>
                                    <div class="anakKopPemda">Jl. Raya Pancasan - Ajibarang Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005</br>
                                        Email: rsudajibarang@banyumaskab.go.id</br></div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="49%" align="center" valign="middle">
                    <div class="KopAdmisionNote">
                        FORMULIR<br>
                        PENGANTAR DIRAWAT<br>
                        (ADMISSION NOTE)
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <?php
    // print_r($spri);
    ?>
    <table width="100%" class="dataSpri" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tbody>


            <tr>
                <td align="left" valign="top">&nbsp;NO SPRI</td>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="2" align="left" valign="top">&nbsp;<strong><?= $spri["no_spri"]; ?></strong></td>
            </tr>
            <tr>
                <td width="42%" align="left" valign="top">&nbsp;NO Rekam Medis</td>
                <td width="3%" align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?= $spri["nomr"]; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Nama Pasien</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td width="40%" align="left" valign="top">&nbsp;<?= $pasien["NAMA"]; ?></td>
                <td width="15%">&nbsp;<?= $pasien["JENISKELAMIN"]; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Tanggal Lahir</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?= $pasien["TGLLAHIR"]; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Alamat</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?= $pasien["ALAMAT"]; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Dengan Diagnosa tetap/Sementara</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">
                    &nbsp;<?= $spri["diagnosa"]; ?></br>
                    &nbsp;DPJP&nbsp;:<?= getNamaDokter($spri["dpjp"]); ?>&nbsp;
                </td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Dimasukan ke ruangan /bangsal</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">
                    &nbsp;<?php

                            if ($spri["jenisbangsal"] == 0) {
                                echo "Non-Infeksius";
                            } else if ($spri["jenisbangsal"] == 1) {
                                echo "Infeksius";
                            } elseif ($spri["jenisbangsal"] == 2) {
                                echo "ICU";
                            }


                            ?> / </br>
                    &nbsp;Kelas Rawat&nbsp;:<?= $spri["kelasrawat"]; ?>&nbsp;
                </td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;dikirim dari</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?php
                                                                if ($spri["kdpoly"] == 9) {
                                                                    echo "IGD";
                                                                } else {
                                                                    echo "Poliklinik";
                                                                }
                                                                ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Tingkat Prioritas</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?= $spri["kdprioritas"]; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top">&nbsp;Sudah diberikan informasi dan edukasi</td>
                <td align="center" valign="top">&nbsp;:</td>
                <td colspan="2" align="left" valign="top">&nbsp;<?php
                                                                if ($spri["info_edu"] == 0) {
                                                                    echo "Belum";
                                                                } else if ($spri["info_edu"] == 1) {
                                                                    echo "Sudah";
                                                                }
                                                                ?></td>
            </tr>

        </tbody>
    </table>

    <table class="footerTTD" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tbody>
            <tr>
                <td width="44%">&nbsp;</td>
                <td width="8%">&nbsp;</td>
                <td width="48%" align="center" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">&nbsp;Ajibarang, <?php print date("d/m/Y"); ?> Jam : <?php print date("H:i:s"); ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">Nama dan Tanda Tangan</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">Dokter yang memasukan</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">(<?= getNamaDokter($spri["dpjp"]); ?>)</td>
            </tr>
        </tbody>
    </table>

</body>

</html>