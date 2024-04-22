<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title;?></title>
</head>
<style>

@font-face {
  font-family: 'Quattrocento Sans';
  font-style: normal;
  font-weight: bold;
  src: local('Quattrocento Sans Bold'), local('QuattrocentoSans-Bold'), url(http://themes.googleusercontent.com/static/fonts/quattrocentosans/v5/tXSgPxDl7Lk8Zr_5qX8FIQfd-b-I5PxxcmB4_-MNcqw.ttf) format('truetype');
}

body{
	  font-family: 'Quattrocento Sans';
}
</style>
<body>
     <ul>
                    <li class="tebal">NOMR : <strong ><?= $pasien["NOMR"];?></strong></li>
                    <li>NAMA : <strong><?= $pasien["NAMA"];?></strong></li>
                    <li>TGL.LHR : <strong><?= $pasien["TGLLAHIR"];?></strong></li>
                </ul>
</body>
</html>