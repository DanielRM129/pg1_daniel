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

$categorias = listarCategoria($conexao);
if(empty($categorias)){
            ?>
                <section>
                    <p>Não há categorias cadastradas.</p>
                </section>
            <?php
        }
        foreach($categorias as $categoria){

?>

<script src="camposVazios.js"> </script>

<section>
<form id="formulario" action="includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<p>ID: <?php echo $categoria['codcategoria']; ?></p>
<input type ="hidden" name = "codcategoria" value="<?php echo $categoria['codcategoria']?>">
<input type ="hidden" name = "codusuario" value="<?php echo $categoria['codusuario']?>">
<p>Nome:  <input type="text" name="nome" value="<?php echo $categoria['nome']?>"></p>
<p>Foto: <img src="imagens/<?php echo $categoria['imagem'];?>" width='100px' height='100px'/></p>
<p>Editar foto: <input type="file" name="arquivo" id="arquivo"></p>

<button type="submit" name="acaocategoria" value="editar"> Editar </button>
<button type="submit" name="acaocategoria" value="excluir" onclick = "return confirma_excluir()"> Deletar </button> 
</form>                                                         
</section>
<?php
}
?>
<a href='adicionarcategoria.php'>Voltar</a>