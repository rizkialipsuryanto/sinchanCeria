<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <title><?= $title; ?></title>

    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script> -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery.signature.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery.signature.css" />

     <script src="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery.min.js" type="text/javascript" ></script>
    <script src="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery-ui.min.js" type="text/javascript" > </script>
    <script src="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery.signature.js" type="text/javascript" ></script>
    <script src="<?php echo base_url(); ?>assets/js/controllers/tandatangan/js-lib/jquery.ui.touch-punch.min.js" type="text/javascript" ></script>

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
    <style>
        .kbw-signature{
            height: 50px;
            width: 100px;
        }
    </style>
</head>
 <!-- onload="window.print()" -->
<body>
<?php echo $seplokal["signature"];?>
<div id="tandatangan"></div>
    <p>
        <button id="draw">Tampil Tanda Tangan</button>
    </p>
    <div id="salinan"></div>

    <!-- <script type="text/javascript">

        $(document).ready(function () {
            $('#salinan').signature({disabled: true, guideline: false}); 
            $('#salinan').signature('draw', <?php echo $sign;?>); 
        });

    </script> -->
    <script>
    $(function(){
        // console.log('aaaa');
        $('#salinan').signature({disabled: true, guideline: false}); 
        $('#salinan').signature('draw', <?php echo $seplokal["signature"];?>); 
    });
</script>
</body>

</html>