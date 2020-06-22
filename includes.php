<?php
    //
    //Define se deve voltar uma pasta no diretorio de arquivos
    $diretorioBase = "";
    if(basename($_SERVER['PHP_SELF']) != 'index.php'){
        $diretorioBase = "../";
    }
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= $diretorioBase ?>js/jquery.min.js"></script>
<script src="<?= $diretorioBase ?>js/popper.min.js"></script>
<script src="<?= $diretorioBase ?>js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?= $diretorioBase ?>css/bootstrap.min.css">