<?php if ($rujukan["error"] == 1 or  $kepesertaan["error"] == 1 || $kepesertaan["error"] == 1) : ?>

    <h1>Server BPJS Sedang Bermasalah, Silakan coba beberapa saat lagi</h1>
<?php else : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title; ?></title>
        <style>
            body {

                font-size: 16px;
                font-family: Arial, Helvetica, sans-serif;
            }

            @page {
                size: 21cm 29cm;
                margin: 20px;
            }

            .fontNoSEP {
                font-size: 20px;
                font-weight: bold;
            }

            .fontSEP {
                font-size: 12px;
            }

            .header {
                font-size: 13px;
                font-weight: bold;
            }

            .style13 {
                font-size: 8px;
            }
        </style>
    </head>

    <body>
        <table width="100%" cellpadding="0">
            <tbody>
                <tr>
                    <!-- <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="<?= IMAGE_BASE_URL; ?>logobpjs.png" width="200" height="50" alt="" /></td> -->
                    <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="http://localhost/simrs2022/assets/img/logobpjs.png" width="200" height="50" alt="" /></td>
                    <td width="3%" height="20">&nbsp;</td>
                    <td width="70%"><span class="header"><strong> <?= $statussimpan;?>  SURAT ELEGIBILITAS PESERTA, FASKES <?=$sep["faskes_id"];?>  <br>RSUD AJIBARANG  <?= $rujukan["metaData"]["code"]?$rujukan["metaData"]["code"]:$flag; ?></strong></span></td>
                    <td width="13%" style="text-align:left;" vtext-align="top"><img src="http://localhost/simrs2022/assets/img/logorsud.png" width="50" height="50" alt="" /></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="top" rowspan="2"></td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" cellspacing="8px" cellpadding="0" class="fontSEP">
            <tbody>
                <tr>
                    <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                    <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                    <td style="text-align:left;" vtext-align="bottom">
                        <span class="fontNoSEP">&nbsp;<?= $sep["nomer_sep"]; ?></span> </td>
                    
                        <?php if ($sep["katarak"] == 1) {?>
                        <td style="text-align:left;" vtext-align="bottom"><b>*PASIEN OPERASI KATARAK</b></td>
                        <?php }else{ ?>
                        <td style="text-align:left;" vtext-align="bottom"></td><?php } ?>
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
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["no_kartubpjs"]; ?> (MR. <?= $sep["nomr"]; ?>) </td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["nama"]; ?> (<?= $kepesertaan["response"]["peserta"]["sex"]; ?>)</td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["nama_peserta"]; ?> </td>
                    <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?php if ($sep["jenis_layanan"] == 1) : ?> R.Inap <?php else : ?> R.Jalan<?php endif; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["tglLahir"]; ?></td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["tglLahir"]; ?> Kelamin : <?= $sep["kelamin"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Jns.Kunjungan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["no_telp"]; ?></td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">-</td>
                    <!-- <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= getCaraBayar($pasiendaftar["KDCARABAYAR"], "NAMA"); ?></td> -->
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp; <?= $detailsep["response"]["poli"]; ?>, <?= $detailsep["response"]["poliEksekutif"]; ?></td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["nama_politujuan"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Poli Perujuk</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">-</td>
                </tr>

                <tr>
                    <td style="text-align:left;" vtext-align="top">Dokter</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?php if ($sep["kddpjpvclaim"] == "") : ?> - <?php else : ?> <?= getDokterMapping($sep["kddpjpvclaim"], "pd_nickname"); ?> <?php endif; ?> </td>
                    <td style="text-align:left;" vtext-align="top">Kls.Hak</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top"><?= $sep["nama_kelas"]; ?></td>
                </tr>

                <tr>
                    <td style="text-align:left;" vtext-align="top">Faskes Perujuk</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["provPerujuk_kode"]; ?>, <?= $sep["provPerujuk_nama"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["kelas_rawat"]; ?>
                    </td>
                </tr>




                <tr>
                    <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["kode_diagnosaawal"]; ?>, &nbsp;<?= $sep["nama_diagnosaawal"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= getCaraBayar($pasiendaftar["KDCARABAYAR"], "NAMA"); ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Catatan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["catatan"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Tgl.Berlaku</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;
                        <?php if ($sep["tglKunjungan"]) : ?>
                            <?= $sep["tglKunjungan"]; ?> - s/d <?= date('Y-m-d', strtotime($sep["tglKunjungan"] . ' + 88 days')) ?>
                        <?php endif; ?>
                    </td>
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
                            <br>*SEP bukan sebagai bukti penjamin peserta
                            Cetakan Ke 1 Dibuat Pertama Oleh:
                        </p>
                    </td>

                    <td width="1%">&nbsp; </td>
                    <td width="27%"><span class="style13">Pasien/Keluarga Pasien</span></td>
                </tr>
                <tr>
                    <td>

                        <img id="salinan" width="170" height="90" src="<?= getDetailUser($sep["user_id"], "signature"); ?>" class="resize" alt="tanda tangan petugas">
                        <img src="http://localhost/simrs2022/assets/img/cap_rs.png" width="110" height="110" alt="fixed position " title="fixed position" />
                    </td>
                    <td>



                    </td>
                    <td>
                        <b><img id="salinan" width="170" height="90" src="<?= $sep["signature"]; ?>" class="resize" alt="tanda tangan pasien"></b>

                    </td>
                </tr>
                <tr>
                    <td><span class="style13"><?= getDetailUser($sep["user_id"], "firstname"); ?> <?= getDetailUser($sep["user_id"], "lastname"); ?> (<?= date('Y-m-d',strtotime($sep["tgl_sep"]))?>)</span></td>
                    <td>&nbsp;</td>
                    <td><span class="style13"><span class="style11"><?= $penanggungjawab; ?></span></span></td>
                </tr>
            </tbody>
        </table>

        <br>
        <hr>
        <br>
        <table width="100%" cellpadding="0">
            <tbody>
                <tr>
                    <!-- <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="<?= IMAGE_BASE_URL; ?>logobpjs.png" width="200" height="50" alt="" /></td> -->
                    <td width="14%" rowspan="2" style="text-align:left;" vtext-align="top"><img src="http://localhost/simrs2022/assets/img/logobpjs.png" width="200" height="50" alt="" /></td>
                    <td width="3%" height="20">&nbsp;</td>
                    <td width="70%"><span class="header"><strong> <?= $statussimpan;?>  SURAT ELEGIBILITAS PESERTA, FASKES <?=$sep["faskes_id"];?>  <br>RSUD AJIBARANG  <?= $rujukan["metaData"]["code"]?$rujukan["metaData"]["code"]:$flag; ?></strong></span></td>
                    <td width="13%" style="text-align:left;" vtext-align="top"><img src="http://localhost/simrs2022/assets/img/logorsud.png" width="50" height="50" alt="" /></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="top" rowspan="2"></td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" cellspacing="8px" cellpadding="0" class="fontSEP">
            <tbody>
                <tr>
                    <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                    <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                    <td style="text-align:left;" vtext-align="bottom">
                        <span class="fontNoSEP">&nbsp;<?= $sep["nomer_sep"]; ?></span> </td>
                    
                        <?php if ($sep["katarak"] == 1) {?>
                        <td style="text-align:left;" vtext-align="bottom"><b>*PASIEN OPERASI KATARAK</b></td>
                        <?php }else{ ?>
                        <td style="text-align:left;" vtext-align="bottom"></td><?php } ?>
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
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["no_kartubpjs"]; ?> (MR. <?= $sep["nomr"]; ?>) </td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Nama Peserta</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["nama"]; ?> (<?= $kepesertaan["response"]["peserta"]["sex"]; ?>)</td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["nama_peserta"]; ?> </td>
                    <td style="text-align:left;" vtext-align="top">Jns.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?php if ($sep["jenis_layanan"] == 1) : ?> R.Inap <?php else : ?> R.Jalan<?php endif; ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Tgl.Lahir</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp;<?= $kepesertaan["response"]["peserta"]["tglLahir"]; ?></td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["tglLahir"]; ?> Kelamin : <?= $sep["kelamin"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Jns.Kunjungan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">No.Telepon</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["no_telp"]; ?></td>
                    <td style="text-align:left;" vtext-align="top"></td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">-</td>
                    <!-- <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= getCaraBayar($pasiendaftar["KDCARABAYAR"], "NAMA"); ?></td> -->
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Sub/Spesialis</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <!-- <td style="text-align:left;" vtext-align="top">&nbsp; <?= $detailsep["response"]["poli"]; ?>, <?= $detailsep["response"]["poliEksekutif"]; ?></td> -->
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["nama_politujuan"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Poli Perujuk</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">-</td>
                </tr>

                <tr>
                    <td style="text-align:left;" vtext-align="top">Dokter</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?php if ($sep["kddpjpvclaim"] == "") : ?> - <?php else : ?> <?= getDokterMapping($sep["kddpjpvclaim"], "pd_nickname"); ?> <?php endif; ?> </td>
                    <td style="text-align:left;" vtext-align="top">Kls.Hak</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top"><?= $sep["nama_kelas"]; ?></td>
                </tr>

                <tr>
                    <td style="text-align:left;" vtext-align="top">Faskes Perujuk</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["provPerujuk_kode"]; ?>, <?= $sep["provPerujuk_nama"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Kls.Rawat</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= $sep["kelas_rawat"]; ?>
                    </td>
                </tr>




                <tr>
                    <td style="text-align:left;" vtext-align="top">Diagnosa Awal</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["kode_diagnosaawal"]; ?>, &nbsp;<?= $sep["nama_diagnosaawal"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Penjamin</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;<?= getCaraBayar($pasiendaftar["KDCARABAYAR"], "NAMA"); ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" vtext-align="top">Catatan</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp; <?= $sep["catatan"]; ?></td>
                    <td style="text-align:left;" vtext-align="top">Tgl.Berlaku</td>
                    <td style="text-align:left;" vtext-align="top">:</td>
                    <td style="text-align:left;" vtext-align="top">&nbsp;
                        <?php if ($sep["tglKunjungan"]) : ?>
                            <?= $sep["tglKunjungan"]; ?> - s/d <?= date('Y-m-d', strtotime($sep["tglKunjungan"] . ' + 88 days')) ?>
                        <?php endif; ?>
                    </td>
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
                            <br>*SEP bukan sebagai bukti penjamin peserta
                            Cetakan Ke 1 Dibuat Pertama Oleh:
                        </p>
                    </td>

                    <td width="1%">&nbsp; </td>
                    <td width="27%"><span class="style13">Pasien/Keluarga Pasien</span></td>
                </tr>
                <tr>
                    <td>

                        <img id="salinan" width="170" height="90" src="<?= getDetailUser($sep["user_id"], "signature"); ?>" class="resize" alt="tanda tangan petugas">
                        <img src="http://localhost/simrs2022/assets/img/cap_rs.png" width="110" height="110" alt="fixed position " title="fixed position" />
                    </td>
                    <td>



                    </td>
                    <td>
                        <b><img id="salinan" width="170" height="90" src="<?= $sep["signature"]; ?>" class="resize" alt="tanda tangan pasien"></b>

                    </td>
                </tr>
                <tr>
                    <td><span class="style13"><?= getDetailUser($sep["user_id"], "firstname"); ?> <?= getDetailUser($sep["user_id"], "lastname"); ?> (<?= date('Y-m-d',strtotime($sep["tgl_sep"]))?>)</span></td>
                    <td>&nbsp;</td>
                    <td><span class="style13"><span class="style11"><?= $penanggungjawab; ?></span></span></td>
                </tr>
            </tbody>
        </table>

    </body>

    </html>

<?php endif; ?>