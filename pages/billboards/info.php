<?php 
$moduleName = 'Billboard';
$dir = '';
$PUBLIC_URL = '/public';
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="<?=$PUBLIC_URL?>/favicon.ico" />
        <meta 
            name="viewport" 
            content="width=device-width, initial-scale=1" 
        />
        <meta 
            name="theme-color" 
            content="#000000" 
        />
        <meta
            name="description"
            content="GNog Media y Tecnología - CRM"
        />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta
            name="csrf-token"
            content=""
        />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
        <link rel="stylesheet" href="<?=$dir?>/assets/css/<?=$moduleName?>.css">
        <link rel="stylesheet" href="<?=$dir?>/assets/css/Inputs.css">
        <link rel="stylesheet" href="<?=$dir?>/assets/css/Button.css">
        <script nonce="">
            /* Firefox needs this to prevent FOUT */
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="<?=$dir?>/assets/js/build/charles.js" type="text/javascript"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script src="<?=$dir?>/assets/js/<?=strtolower($moduleName)?>_viewer.js" type="text/javascript"></script>
<?php if(array_key_exists('bid',$_REQUEST)){ ?>
        <script>
            handleViewOnLoad("<?=$_REQUEST['bid']?>")
        </script>
<?php } ?>
        <title>GNog Media y Tecnología - CRM</title>
    </head>
    <body>
        <div class="screen-652x510" id="<?=strtolower($moduleName)?>-screen">
            <img src="/assets/img/logo_gnog_media_y_tecnologia.svg" class="logo"/>
            <img id="field-image-photo" src="/assets/img/logo_gnog_media_y_tecnologia.svg" class="<?=strtolower($moduleName)?>-view-photo"/>
            <div class="billboard-fields" id="field-key"><span class="material-icons billboard-icon" id="key-icon">key</span><div class="billboard-text" ><span id="field-key-text"></span></div></div>
            <div class="billboard-fields" id="field-address"><span class="material-icons billboard-icon" id="address-icon">map</span><div class="billboard-text" ><span id="field-address-text"></span></div></div>
            <div class="billboard-fields" id="field-salemodel"><span class="material-icons billboard-icon" id="salemodel-icon">waterfall_chart</span><div class="billboard-text" ><span id="field-salemodel-text"></span></div></div>
            <div class="billboard-fields" id="field-viewpoint"><span class="material-icons billboard-icon" id="viewpoint-icon">visibility</span><div class="billboard-text" ><span id="field-viewpoint-text"></span></div></div>
            <div class="billboard-fields" id="field-coordenates"><span class="material-icons billboard-icon" id="coordenates-icon">radar</span><div class="billboard-text" ><span id="field-coordenates-text"></span></div></div>
            <div class="billboard-fields" id="field-dimension"><span class="material-icons billboard-icon" id="dimension-icon">aspect_ratio</span><div class="billboard-text" ><span id="field-dimension-text"></span></div></div>
        </div>
    </body>
</html>