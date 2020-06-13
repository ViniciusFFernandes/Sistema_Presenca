<?php
 include 'cabecalho.php';
 include 'includes.php';
?>
     <form>
  <div class="form-group">
    <label for="exampleInputAluno">Cadastro de Alunos</label>
    <input type="aluno" class="form-control" id="exampleInputAluno" aria-describedby="emailHelp" placeholder="Digite o Nome">
  </div>
  <div class="form-group">
    <label for="exampleInputCurso">Nome do Curso</label>
    <input type="curso" class="form-control" id="exampleInputCurso" placeholder="Digite o nome do Curso">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Aceito</label>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
 </form>

