<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:../index.php");
}

include_once('../includes/logica/funcoes.php');
include_once('../includes/logica/conecta.php');

$areas = listarAreas($conexao);
if(empty($areas)){
            ?>
                <section>
                    <p>Não há areas cadastrados.</p>
                </section>
            <?php
        }
        foreach($areas as $area){

?>
<script src="../camposVazios.js"> </script>

<section>
<form id="formulario" action="../includes/logica/logica.php" method="post" enctype="multipart/form-data">
<input type ="hidden" name = "codarea" value="<?php echo $area['codarea']?>">
<p>Nome da area: <input type="text" name="nome" value="<?php echo $area['nome']?>"></p>
<p>Descrição da area: <input type ="text" name = "area_desc" value="<?php echo $area['area_desc']?>"></p> 
<p>Foto: <img src="imagens/<?php echo $area['imagem'];?>" width='100px' height='100px'/></p>
<p>Editar foto: <input type="file" name="arquivo" id="arquivo"></p>
<button type="submit" name="acaoarea" value="editar"> Editar </button>
<button type="submit" name="acaoarea" value="excluir" onclick = "return confirma_excluir()"> Deletar </button> 
</form>                                                         
</section>
<?php
}
?>


<a href='listagem_area.php'>Cadastro de areas</a><br>
<a href='../index.php'>Voltar </a>
