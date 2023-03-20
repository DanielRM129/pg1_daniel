    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:login.php");
}

?>
<?php
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conecta.php');

$usuarios = identificarUsuario($conexao);
if(empty($usuarios)){
            ?>
                <section>
                    <p>Não há usuários cadastrados.</p>
                </section>
            <?php
        }
        foreach($usuarios as $usuario){
?>
<script src="camposVazios.js"> </script>

<form id="formulario" action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<input type ="hidden" name = "codusuario" value="<?php echo $usuario['codusuario']?>">
<p>Nome : <input type="text" name="nome"></p>
<p>Foto: <input type="file" name="arquivo" id="arquivo"></p>

<p><input type="reset" name="categoria" value="Limpar">
<input type="submit" name="categoria" value="Enviar"></p>
</form>
<?php
}
?>
<a href='listagem_categoria.php'>Editar categorias</a>
<a href='index.php'>Voltar</a>