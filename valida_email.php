<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conecta.php');
if($_GET['h']){
	$h=$_GET['h'];
    $_SESSION["msg"]=''; //inicializa msg
	

	$array = array($h);


	$linha=pesquisarPessoaEmail($conexao,$array);

	if($linha)
	{

		$array=array($linha['codusuario']);

		$retorno=alterarStatustrue($conexao,$array);
		
		if($retorno)
		{
			
		
			   $_SESSION["msg"]= "Cadastro Validado - Entre com seu usuário e senha";

		}
		else
		{
			   $_SESSION["msg"]= 'Problema na validação';
			   
		}	
	}

	else
	{
		$_SESSION["msg"]= 'Problema na validação';
	}	

header("Location:login.php");
	
}
