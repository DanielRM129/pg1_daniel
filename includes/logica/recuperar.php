<h1>Alterar password</h1>
<?php
include("funcoes.php");

  if( empty($_GET['utilizador']) || empty($_GET['confirmacao']) )
    die('<p>Não é possível alterar a password: dados em falta</p>');
 
  
 
  $user = $_GET['utilizador'];
  $hash = $_GET['confirmacao'];
  $array = array($user,$hash);
  $q = "SELECT * FROM recuperacao WHERE utilizador = ? AND confirmacao = ?";
 $linha=ConsultaSelect($q,$array);
  if($linha){     
 $query="DELETE FROM recuperacao WHERE utilizador = ? AND confirmacao = ?";
  $resultado=fazConsulta($query,$array);
  
  if($resultado)
  {
     $_SESSION["msg"]= "Sucesso! (Mostrar formulário de alteração de password aqui)";
     header("Location:../../recuperar_senha.php?user=$user");
  }  
 
  } else
  {
     $_SESSION["msg"]= 'Erro ao excluir <br>';
  }
 
?>