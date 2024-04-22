<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?= $title; ?></title>
</head>

<body>

    <table width="100%" border="0">
        <tr>
            <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 3px 0px;
  font-size: 18px;
  line-height: 13px;
  letter-spacing: 0px;
  font-weight: bold;
    ">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 18px;
  line-height: 10px;
  letter-spacing: 2px;
  font-weight: bold;
    "> NOMR : <?= $pasien["NOMR"]; ?> | TGLLAHIR : <?= $pasien["TGLLAHIR"]; ?>
        </tr>
        <tr>
            <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 18px;
  line-height: 10px;
  letter-spacing: 2px;
  font-weight: bold;
    "> NAMA : <?= $pasien["NAMA"]; ?>
        </tr>

    </table>

</body>

</html>