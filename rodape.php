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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>