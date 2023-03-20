<h1> Título do Site </h1>
<form action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">


<input type="hidden" name="user" value="<?php echo $_GET['user']?>">
<p>Nova Senha: <input type="password" name="novasenha"></p>

<p><input type="reset" name="botao" value="Limpar">
<input type="submit" name="botao" value="Recuperar Senha"></p>
</form>
<?php
echo "<div id='msg'>";

if(isset($_SESSION['msg']))
{ 
    echo "<br><br>".$_SESSION['msg']."<br><br>";
    unset($_SESSION['msg']);
}
?>
<h3> Este é o Rodapé da página </h3>