    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">

<h1> Título do Site </h1>
<form action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<p>Email : <input type="text" name="email"></p>
<p><input type="reset" name="botao" value="Limpar">
<input type="submit" name="botao" value="Recuperar"></p>
</form>
<?php
echo "<div id='msg'>";

if(isset($_SESSION['msg']))
{ 
    echo "<br><br>".$_SESSION['msg']."<br><br>";
    unset($_SESSION['msg']);
}
?>