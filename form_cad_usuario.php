    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">

<script src="camposVazios.js"> </script>

<form id="formulario" action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<p>Nome : <input type="text" name="nome"></p>
<p>Email: <input type="text" name="email" id="email"></p>
<p>Senha: <input type="password" name="senha"></p>
<p>Foto: <input type="file" name="arquivo" id="arquivo"></p>

<p><input type="reset" name="usuario" value="Limpar">
<input type="submit" name="usuario" value="Enviar"></p>
</form>

<a href='listagem_usuario.php'>Edição de Usuários</a><br>
<a href='index.php'>Voltar</a>
