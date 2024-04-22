<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    body {
        font-size: 10px;
        font-family: Arial, Helvetica, sans-serif;
    }

    @page {
        size: 21cm 15cm;
        margin: 20px;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td colspan="4" style="text-align:center;font-weight: bold;">
                <p style="font-size: 10px;">KABUPATEN BANYUMAS</p>
                <p style="font-size: 10px;">RUMAH SAKIT UMUM DAERAH AJIBARANG</p>
                <p>Jl. Raya Pancasan - Ajibarang Kode Pos 53163 Telp. 0281-6570004 Fax. 0281-6570005</p>
                <p>E-mail : rsudajibarang@banyumaskab.go.id</p>
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center;font-weight: bold;">
                <p>FORMULIR PENDAFTARAN PASIEN BARU RSUD AJIBARANG</p>
            </td>
        </tr>
        <tr>
            <td width="100">Cara Pembayaran </td>
            <td width="200">
                <div>:&nbsp;<strong><?= getNamaCaraBayar($pendaftaran["KDCARABAYAR"]); ?></strong></div>
            </td>
            <td width="100">
                <div>No. Rekam Medis</div>
            </td>
            <td width="100">
                <div>:&nbsp;<strong><?= $pendaftaran["NOMR"]; ?></strong></div>
            </td>
        </tr>

        <tr>
            <td>Nama Pasien (sesuai KTP) </td>
            <td>
                <div>:&nbsp;<strong><?= getDetailPasien($pendaftaran["NOMR"], "NAMA"); ?></strong></div>
            </td>
            <td>
                <div>Jenis Kelamin</div>
            </td>
            <td>
                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "JENISKELAMIN"); ?></div>
            </td>
        </tr>
        <tr>
            <td>Nama Ibu Kandung</td>
            <td>
                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "IBUKANDUNG"); ?></div>
            </td>
            <td>
                <div>Nama Ayah </div>
            </td>
            <td>
                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "nama_ayah"); ?></div>
            </td>
        </tr>
        <tr>
            <td>No. BPJS</td>
            <td>
                <div>:&nbsp;

                    <?= $nomer_kartu; ?>
                </div>

            </td>
            <td>
                <div>Umur</div>
            </td>
            <td>
                <div>:&nbsp;<?= hitungumur(getDetailPasien($pendaftaran["NOMR"], "TGLLAHIR")); ?></div>
            </td>
        </tr>

        <tr>
            <td>Tempat/tanggal lahir</td>
            <td>
                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "TEMPAT"); ?>, <?= getDetailPasien($pendaftaran["NOMR"], "TGLLAHIR"); ?></div>
            </td>
            <td>
                <div>Etnis</div>
            </td>


            <td>
                <div>:&nbsp;<?= getNamaEtnis(getDetailPasien($pendaftaran["NOMR"], "KD_ETNIS")); ?></div>
            </td>
        </tr>
        <tr>

            <td>Alamat Sekarang </td>
            <td>
                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "ALAMAT"); ?></div>
            </td>
            <td>
                <div>Bahasa Sehari-Hari </div>
            </td>
            <td>

                <div>:&nbsp;<?= getNamaBahasa(getDetailPasien($pendaftaran["NOMR"], "KD_BHS_HARIAN")) ?></div>
            </td>
        </tr>
        <tr>


            <td>Pendidikan Terakhir </td>
            <td>
                <div>:&nbsp; <?= getNamaPendidikan(getDetailPasien($pendaftaran["NOMR"], "PENDIDIKAN")) ?></div>
            </td>
            <td>
                <div>Asal Faskes </div>
            </td>
            <td>
                <div>:&nbsp;<?= $asal_faskes; ?></div>
            </td>
        </tr>
        <tr>
            <td>Status Perkawinan </td>
            <td>

                <div>:&nbsp;<?= getStatusPerkawinan(getDetailPasien($pendaftaran["NOMR"], "STATUS")) ?></div>
            </td>
            <td>
                <div>NIK </div>
            </td>
            <td>

                <div>:&nbsp; <?= getDetailPasien($pendaftaran["NOMR"], "NOKTP") ?></div>
            </td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>

                <div>:&nbsp;
                    <?= getAgama(getDetailPasien($pendaftaran["NOMR"], "AGAMA")) ?>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>No Telepon/HP</td>
            <td>

                <div>:&nbsp;<?= getDetailPasien($pendaftaran["NOMR"], "NOTELP"); ?></div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nama Suami </td>
            <td>

                <div>: &nbsp; <?= getDetailPasien($pendaftaran["NOMR"], "nama_suami") ?></div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nama Istri </td>
            <td>

                <div>:&nbsp; <?= getDetailPasien($pendaftaran["NOMR"], "nama_istri") ?></div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nama Penanggungjawab </td>
            <td>

                <div>:&nbsp;<?= $pendaftaran["PENANGGUNGJAWAB_NAMA"]; ?></div>
            </td>
            <td>
                <div>No Telp/HP Penanggung Jawab</div>
            </td>
            <td>
                <div>:&nbsp;<?= $pendaftaran["PENANGGUNGJAWAB_PHONE"]; ?></div>
            </td>
        </tr>
        <tr>
            <td>Hubungan Dengan Pasien </td>
            <td>
                <div>:&nbsp;<?= $pendaftaran["PENANGGUNGJAWAB_HUBUNGAN"] ?></div>
            </td>
            <td>
                <div>Alamat Penanggung Jawab</div>
            </td>
            <td>
                <div>:&nbsp;<?= $pendaftaran["PENANGGUNGJAWAB_ALAMAT"]; ?></div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>TTD dan Nama Pasien / Penanggungjawab<br>
                    <br><br><br>

                    (<?= $pendaftaran["PENANGGUNGJAWAB_NAMA"] ?>)<br>
                </div>
            </td>
            <td colspan="2">
                <div>TTD dan Nama Petugas TPPRJ/TPPGD/TPPRI <br>
                    <br><br><br>

                    (<?= $pendaftaran["NIP"]; ?>) <?= $pendaftaran["TGLREG"]; ?> : <?= date('Y-m-d H:i:s'); ?></div>
            </td>
        </tr>



    </table>
</body>

</html>