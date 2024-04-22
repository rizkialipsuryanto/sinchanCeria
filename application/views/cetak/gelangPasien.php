<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
</head>

<style>

body {
            
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }
 @page {
                size: 15cm 2cm;
                margin: 0px;
            }
</style>
<body>
    
<table width="100%"  cellspacing="7px" >
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2" style="
            font-family: calibri;
            color: #000;
            margin: 0;
            padding: 0px 0px 6px 0px;
            font-size: 18px;
            line-height: 10px;
            letter-spacing: 2px;font-weight: bold;"  > NOMR : <?= $pasien["NOMR"];?>  | TGLLAHIR :   <?= $pasien["TGLLAHIR"];?> </td>
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
            font-weight: bold;"> NAMA : <?= $pasien["NAMA"];?> </td>
        </tr>
        
        </table>
</body>
</html>