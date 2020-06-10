<?php
 include 'cabecalho.php';
?>
     <form>
  <div class="form-group">
    <label for="exampleInputAluno">Nome do Evento</label>
    <input type="evento" class="form-control" id="exampleInputEvento" aria-describedby="emailHelp" placeholder="Digite o Nome do Evento">
  </div>
  <div class="form-group">
    <label for="exampleInputCurso">Nome do Palestrante</label>
    <input type="palestrante" class="form-control" id="exampleInputPalestrante" placeholder="Digite o nome do Palestrante">
  </div>
  <div class="form-group">
    <label for="exampleInputHoras">Hora da Palestra</label>
    <input type="horas" class="form-control" id="exampleInputHoras" placeholder="Informe a Horas">
  </div>
  <div class="form-group">
    <label for="exampleInputData">Data do Palestra</label>
    <input type="data" class="form-control" id="exampleInputData" placeholder="Informe a Data">
  </div>
  <div class="form-group">
    <label for="exampleInputHoraInicio">Hora Inicio da Palestra</label>
    <input type="horainicio" class="form-control" id="exampleInputHoraInicio" placeholder="Informe a hora inicio da palestra">
  </div>
  <div class="form-group">
    <label for="exampleInputHoraFinal">Hora Final da Palestra</label>
    <input type="horafinal" class="form-control" id="exampleInputHoraFinal" placeholder="Informe a hora final da palestra">
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
