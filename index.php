<?php
session_start();

if((!isset($_SESSION['nome'])) && (!isset($_SESSION['logado'])))
{
header("Location:login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="javascript/scripts.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
    <title></title>
</head>
<body class="grid">
    <div id="carrega" class="item1">
        <h1><?php echo "Bem Vindo(a) ".$_SESSION['nome'];?></h1>

        <a href='form_cad_usuario.php'>Usuários</a><br>
        <div>Suas Categorias</div>
        <a href='adicionarcategoria.php'><img src="imagens/Add.png"></a><br>

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

        <section>
        <p><a href="item/index.php?categoria=<?php echo $categoria['codcategoria']?>"><?php echo $categoria['nome']?></p>
        <p><img src="imagens/<?php echo $categoria['imagem'];?>" width='100px' height='100px'/></p></a>                                         
        </section>

        <?php
        }
        ?>
        
    </div>

    <nav class="item6">
    <ul>
        <li><a href="home.php" onclick="carregaPagina(this)"><img src="imagens/Home.png"></a></li>
        <li><a href='item/pesquisaritem.php' onclick="carregaPagina(this)"><img src="imagens/Search.png"></a></li>
        <li><a href='config.php' onclick="carregaPagina(this)"><img src="imagens/Settings.png"></a></li>
    </ul>
    </nav>
</body>
</html>




