<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:login.php");
}

?>

<a href="alterar_senha.php"> Alterar Senha </a>

<form action="includes/logica/logica.php" method="post">
    <input type="submit" name="sair" value="Sair">
</form>