<?php
 include 'cabecalho.php';
?>
     <form>
  <div class="form-group">
    <label for="exampleInputPalestra">Palestra</label>
    <input type="palestra" class="form-control" id="exampleInputPalestra" aria-describedby="email" placeholder="Informe a Palestra">
  </div>
  <div class="form-group">
    <label for="exampleInputMiniCurso">Mini Curso</label>
    <input type="minicurso" class="form-control" id="exampleInputMiniCurso" placeholder="Informe o Mini Curso">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Aceito</label>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
 </form>

<?php
 include 'rodape.php';
?>

