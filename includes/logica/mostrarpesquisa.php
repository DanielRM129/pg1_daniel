<?php include "config_upload.php";?>

<!DOCTYPE html>
<html>

   <title>Listar Itens</title>
</head>
<body>  
<body>

<main>
         <h3> Pesquisa de itens </h3>
    <?php

        if(empty($itens)){
            ?>
                <section>
                    <p>Não há usuários cadastrados.</p>
                </section>
            <?php
        }
        else
        {
        foreach($itens as $item){
                 
            ?>
                <section>
                    <p>Nome: <?php echo $item['nome']; ?></p>
                    <p>Descrição do item: <?php echo $item['item_desc']; ?></p>
                    <p>Imagem: <img src="item/imagens/<?php echo $item['imagem'];?>" width='100px' height='100px'/></p>
                    
                    <br><br>                                                          
                </section>
            <?php
        }
    }
    ?>
</main>
</body>
</html>