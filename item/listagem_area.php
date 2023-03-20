<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:index.php");
}

?>
<?php
include_once('../includes/logica/funcoes.php');
include_once('../includes/logica/conecta.php');

$areasitens = listarAreasItens($conexao);
if(empty($areasitens)){
            ?>
                <section>
                    <p>Não há areas cadastrados.</p>
                </section>
            <?php
        }
        foreach($areasitens as $areaitem){
?>
<script src="../camposVazios.js"> </script>

<form id="formulario" action="../includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<input type ="hidden" name = "codusuario" value="<?php echo $areaitem['codusuario']?>">
<input type ="hidden" name = "codcategoria" value="<?php echo $areaitem['codcategoria']?>">
<input type ="hidden" name = "coditem" value="<?php echo $areaitem['coditem']?>">
<p>Nome : <input type="text" name="nome"></p>
<p>Descrição da area : <input type="text" name="area_desc"></p>
<p>Foto: <input type="file" name="arquivo" id="arquivo"></p>

<p><input type="reset" name="area" value="Limpar">
<input type="submit" name="area" value="Enviar"></p>
</form>
<?php
}
?>
<a href='areas.php?item=<?php echo $_SESSION['item']?>'>Voltar</a>