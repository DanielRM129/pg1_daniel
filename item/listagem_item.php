<?php

session_start();

if((!isset($_SESSION['email'])) && (!isset($_SESSION['logado'])))
{
header("Location:../index.php");
}
		include_once('../includes/logica/funcoes.php');
        include_once('../includes/logica/conecta.php');
		$codcategoria=$_SESSION['categoria'];
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
<script src="../camposVazios.js"> </script>

<?php echo $_SESSION['categoria']?>
<form id="formulario" action="../includes/logica/logica.php" method="POST" enctype="multipart/form-data">
<input type ="hidden" name = "codusuario" value="<?php echo $usuario['codusuario']?>">
<input type ="hidden" name = "codcategoria" value="<?php echo $codcategoria?>">

<p>Nome do item : <input type="text" name="nome"></p>
<p>Descrição do item : <input type="text" name="item_desc"></p>
<h3>Fornecedores</h3>
<p>Descrição fornecedor : <input type="text" name="descricao" id="descricao"></p>
<p>Endereço fornecedor: <input type="text" name="endereco" id="endereco"></p>
<p>Email fornecedor : <input type="text" name="email_contato" id="email_contato"></p>
<p>CNPJ : <input type="text" name="cnpj" id="cnpj"></p>
<p>Telefone Fornecedor : <input type="text" name="num_forn" id="num_forn"></p>

<h3>Destino e Vendas</h3>
<p>Destino : <input type="text" name="destino" id="destino"></p>
<p>Venda: <input type="text" name="venda" id="venda"></p>
<p>Data saída : <input type="text" name="dt_saida" id="dt_saida"></p>
<p>Telefone Destino : <input type="text" name="num_telefone" id="num_telefone"></p>

<p>Foto : <input type="file" name="arquivo" id="arquivo"></p>
<p><input type="reset" name="item" value="Limpar">
<input type="submit" name="item" value="Enviar"></p>
</form>
<?php
}
?>
<a href='index.php?categoria=<?php echo $_SESSION['categoria']?>'>Voltar </a>


