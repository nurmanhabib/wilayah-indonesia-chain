<?php
require_once 'connection.php';
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <?php echo $wilayah->generateSelectProvinsi() ?>
                </div>
                <div class="form-group">
                    <label for="kota">Kota</label>
                    <?php echo $wilayah->generateSelectKota() ?>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <?php echo $wilayah->generateSelectKecamatan() ?>
                </div>
                <div class="form-group">
                    <label for="desa">Desa</label>
                    <?php echo $wilayah->generateSelectDesa() ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script src="assets/bower_components/chained/jquery.chained.remote.min.js"></script>

    <?php echo $wilayah->script() ?>

</body>
</html>