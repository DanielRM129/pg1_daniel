    <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">
<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:../index.php");
}

include_once('../includes/logica/funcoes.php');
include_once('../includes/logica/conecta.php');

$itens = listarItens($conexao);
if(empty($itens)){
            ?>
                <section>
                    <p>Não há itens cadastrados.</p>
                </section>
            <?php
        }
        foreach($itens as $item){
           
            $_SESSION['codfornecedor']=$item['codfornecedor'];
            $Fornecedores = listarFornecedores($conexao);
            $FonesFornecedores = listarFonesFornecedores($conexao);
            $_SESSION['codvenda']=$item['codvenda'];
            $Destinos = listarDestino($conexao);
            $FonesDestinos = listarFonesDestino($conexao);
            

?>
<script src="../camposVazios.js"> </script>

<section>
<form id="formulario" action="../includes/logica/logica.php" method="post" enctype="multipart/form-data">
<p><a href="areas.php?item=<?php echo $item['coditem']?>"><?php echo $item['nome']?></a></p>
<input type ="hidden" name = "coditem" value="<?php echo $item['coditem']?>">


<p>Nome do item: <input type="text" name="nome" value="<?php echo $item['nome']?>"></p>
<p>Descrição do item: <input type ="text" name = "item_desc" value="<?php echo $item['item_desc']?>"></p> 
<?php foreach($Fornecedores as $Fornecedor){ ?>
    <input type ="hidden" name = "codfornecedor" value="<?php echo $Fornecedor['codfornecedor']?>">
<p>Descrição fornecedor: <input type ="text" name = "descricao" value="<?php echo $Fornecedor['descricao']?>"></p>
<p>Endereço fornecedor: <input type="text" name="endereco" id="endereco" value="<?php echo $Fornecedor['endereco']?>"></p>
<p>Email fornecedor : <input type="text" name="email_contato" id="email_contato" value="<?php echo $Fornecedor['email_contato']?>"></p>
<p>CNPJ : <input type="text" name="cnpj" id="cnpj" value="<?php echo $Fornecedor['cnpj']?>"></p>
<?php foreach($FonesFornecedores as $FonesFornecedor){ ?>
<p>Telefone Fornecedor : <input type="text" name="num_forn" id="num_forn" value="<?php echo $FonesFornecedor['num_telefone']?>"></p>
<?php
}
?> 
<?php
}
?> 
<?php foreach($Destinos as $Destino){ ?>
    <input type ="hidden" name = "codvenda" value="<?php echo $Destino['codvenda']?>">
<p>Destino : <input type="text" name="destino" id="destino" value="<?php echo $Destino['destino']?>"></p>
<p>Venda: <input type="text" name="venda" id="venda" value="<?php echo $Destino['venda']?>"></p>
<p>Data saída : <input type="text" name="dt_saida" id="dt_saida" value="<?php echo $Destino['dt_saida']?>"></p>
<?php foreach($FonesDestinos as $FonesDestino){ ?>
<p>Telefone Destino : <input type="text" name="num_telefone" id="num_telefone" value="<?php echo $FonesDestino['num_telefone']?>"></p>
<?php
}
?> 
<?php
}
?> 
<p>Foto: <img src="imagens/<?php echo $item['imagem'];?>" width='100px' height='100px'/></p>
<p>Editar foto: <input type="file" name="arquivo" id="arquivo"></p>
<button type="submit" name="acaoitem" value="editar"> Editar </button>
<button type="submit" name="acaoitem" value="excluir" onclick = "return confirma_excluir()"> Deletar </button> 
</form>                                                         
</section>
<?php
}
?>


<a href='listagem_item.php'>Cadastro de Itens</a><br>
<a href='../index.php'>Voltar </a>