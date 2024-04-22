<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="<?= base_url('assets/css/'); ?>styles_labelpasien.css" rel="stylesheet">
    <title><?= $idx; ?></title>
</head>

<body>

    <ul class="b">
        <li>NOMR : <strong><?= $pasien["NOMR"]; ?></strong></li>
        <li>NAMA : <strong><?= $pasien["NAMA"]; ?></strong></li>
        <li>TGL.LHR : <strong><?= $pasien["TGLLAHIR"]; ?></strong></li>
    </ul>

</body>

</html>