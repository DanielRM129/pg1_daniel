<?php

session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:index.php");
}

$sql = "select * from usuarios order by codusuario";
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conecta.php');

$usuarios = listarUsuario($conexao);
if(empty($usuarios)){
            ?>
                <section>
                    <p>Não há usuários cadastradas.</p>
                </section>
            <?php
        }
        foreach($usuarios as $usuario){
?>
<script src="camposVazios.js"> </script>

<section>
<form id="formulario" action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<p>ID: <?php echo $usuario['codusuario']; ?></p>
<input type ="hidden" name = "codusuario" value="<?php echo $usuario['codusuario']?>">
<p>Nome:  <input type="text" name="nome" value="<?php echo $usuario['nome']?>"></p>
<p>Senha: <input type ="password" name = "senha" value="<?php echo $usuario['senha']?>" ?></p>
<p>Foto: <img src="imagens/<?php echo $usuario['imagem'];?>" width='100px' height='100px'/></p>
<p>Editar foto: <input type="file" name="arquivo" id="arquivo"></p>

<button type="submit" name="acaousuario" value="editar"> Editar </button>
<button type="submit" name="acaousuario" value="excluir" onclick = "return confirma_excluir()"> Deletar </button> 
</form>                                                         
</section>
<?php
}
?>
<a href='form_cad_usuario.php'>Voltar </a>


