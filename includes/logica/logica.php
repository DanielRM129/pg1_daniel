<?php
    require_once('conecta.php');
    require_once('funcoes.php');
    require_once('../../email/envia_email.php');
session_start();

#SAIR
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }
#ALTERAR SENHA
if(isset($_POST['botao'])){    
if($_POST['botao']=='AlterarSenha')
{
    $email=$_SESSION["email"];
    $senha=$_POST["senha"];
    $novasenha=password_hash($_POST['novasenha'], PASSWORD_DEFAULT);

    if(!(empty($email) OR empty($senha) OR empty($novasenha)))
    {
        $array = array($email);
        $query= "select * from usuarios where email=? and status=true";

        $resultado=ConsultaSelect($query,$array);
        if ($resultado) 
        {
            if (password_verify($senha,$resultado['senha']))
            {
                $query1= "update usuarios set senha= ? where email = ?";
    
                $array1 = array($novasenha, $email);

                $resultado1=fazConsulta($query1,$array1);
    
                if($resultado1)
                {
                $_SESSION["msg"]="Alteração Efetuada com sucesso";
                header("Location:../../login.php");
                }
                else
                {
                $_SESSION["msg"]="Erro ao alterar";
                header("Location:../../login.php");
                }

            }
            else{
                $_SESSION["msg"]="Senha incorreta";
                header("Location:../../login.php");
            }
        }
    }
}
}
if(isset($_POST['botao'])){
if($_POST['botao']=='Recuperar'){
    $user = $_POST['email'];
    $array = array($user);
    $q ="select * from usuarios where email = ?";
    $linha=ConsultaSelect($q,$array);
    if($linha){
      $chave = sha1(uniqid( mt_rand(), true));
      
        $array1 = array($user, $chave);

        $query ="insert into recuperacao (utilizador, confirmacao) values (?, ?)";

        $retorno=fazConsulta($query,$array1);
        if($retorno)
    {
           $hash=md5($user);
           $link="<a href='localhost/CRUD_AtividadeFinal/includes/logica/recuperar.php?utilizador=$user&confirmacao=$chave'> Clique aqui para confirmar seu cadastro </a>";
          $mensagem="<tr><td style='padding: 10px 0 10px 0;' align='center' bgcolor='#669999'>";
          $mensagem.="<img src='cid:logo_ref' style='display: inline; padding: 0 10px 0 10px;' width='10%' />";

           $mensagem.="Email de Confirmação <br>".$link."</td></tr>";
           $assunto="Confirme seu cadastro";
           $nome = "Prezado usuário";


           $retorno= enviaEmail($user,$nome,$mensagem,$assunto);
    
           $_SESSION["msg"]= "Valide o Cadastro no email";

    }
    else
    {
           $_SESSION["msg"]= 'Erro ao inserir <br>';
    }

}}
}
if(isset($_POST['botao'])){
#RECUPERAR SENHA
if($_POST['botao']=='Recuperar Senha')
{
    $email=$_POST["user"];
    $novasenha=password_hash($_POST['novasenha'], PASSWORD_DEFAULT);

    if(!(empty($email) OR empty($novasenha)))
    {
        $array = array($email);
        $query= "select * from usuarios where email=? and status=true";

        $resultado=ConsultaSelect($query,$array);
        if ($resultado) 
        {
            $query1= "update usuarios set senha= ? where email = ?";
    
                $array1 = array($novasenha, $email);

                $resultado1=fazConsulta($query1,$array1);
    
                if($resultado1)
                {
                $_SESSION["msg"]="Alteração Efetuada com sucesso";
                header("Location:../../login.php");
                }
                else
                {
                $_SESSION["msg"]="Erro ao alterar";
                header("Location:../../login.php");
                }
        }
    }
}
}
#ENTRAR
    if(isset($_POST['entrar'])){
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];
        //$array = array($nome, $senha);
        //$usuario = acessarusuario($conexao,$array);
        echo $nome;
        echo $senha;

    if (!(empty($nome) OR empty($senha))) 
    {
         
        $array = array($nome);

        $query= "select * from usuarios where nome=? and status=true";// Alterar nome BD para UNIQUE

        $resultado=ConsultaSelect($query,$array);
        if ($resultado) // testa se retornou uma linha de resultado da tabela pessoa com email e senha válidos
        {
        if (password_verify($senha,$resultado['senha']))
        {
        session_start();

        $_SESSION["logado"]=true; // armazena TRUE na variável de sessão logado
        $_SESSION["nome"]=$nome; // armazena na variável de sessão email o conteúdo do campo email do formulário
        $_SESSION["codusuario"]=$resultado['codusuario']; 

        $_SESSION["email"]=$resultado['email'];
        $email=$resultado['email'];
        $data=date("d/m/Y h:i:s");

         $mensagem="<tr><td style='padding: 10px 0 10px 0;' align='center' bgcolor='#669999'>";
          $mensagem.="<img src='cid:logo_ref' style='display: inline; padding: 0 10px 0 10px;' width='10%' />";

           $mensagem.="Bem Vindo ".$_SESSION["nome"]." Seu login foi realizado em ".$data."</td></tr>";

        $assunto="checkin Sistema";

        $retorno= enviaEmail($email,$nome,$mensagem,$assunto); 
        header('location:../../index.php'); // direciona para o index
         }
         else
         {
            $_SESSION["msg"]="Usuário ou senha inválidos"; // caso não exista uma linha na tabela pessoa com o email e a senha válidos uma mensagem é armazenada na variável de sessão msg
            header('location:../../login.php'); // o fluxo da aplicação é direcionado novamente parvo formulário de login - onde a variável de sessão contendo a mensagem será exibida
         }
        }
        else
        {
            $_SESSION["msg"]="Usuário ou senha inválidos"; // caso não exista uma linha na tabela pessoa com o email e a senha válidos uma mensagem é armazenada na variável de sessão msg
            header('location:../../login.php'); // o fluxo da aplicação é direcionado novamente parvo formulário de login - onde a variável de sessão contendo a mensagem será exibida
        }
    }
    else // else correspondente ao resultado da função !empty 
    {
        $_SESSION["msg"]="Preencha campos email e senha"; // caso contrário, ou seja, os campos do formulário email e senha estejam vazios, a mensagem é armazenada na variável msg
        header('location:../../login.php'); // o fluxo da aplicação é direcionado novamente para o formulário de login - onde a variável de sessão contendo a mensagem será exibida
    }
    }



####CATEGORIAS####   

#CADASTRO CATEGORIA
    if(isset($_POST['categoria'])){
        include "config_upload.php";
        $codusuario=$_POST['codusuario'];
        echo $codusuario;
        $nome=$_POST['nome'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];

        if (!empty($nome_arquivo))
        {
          if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo"))
                die("Arquivo já existe");

          if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
                die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

            $ext = strrchr($nome_arquivo,'.');
            if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
                die("Extensão de arquivo inválida para upload");
        
            if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
        {
            echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
            $nome_arquivo='foto.png';
        }
        }
        else
        { 
            $nome_arquivo='foto.png';
        }
        $array = array($codusuario, $nome, $nome_arquivo);
        inserirCategoria($conexao, $array);
        header('location:../../index.php'); 

    }

#ALTERAR CATEGORIA
    if(isset($_POST['acaocategoria'])){    
        include "config_upload.php";

        if($_POST['acaocategoria']=='editar')
        {

        $codcategoria= $_POST['codcategoria'];
        $nome= $_POST['nome'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];

        if (!empty($nome_arquivo))
        {
        if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo"))
            die("Arquivo já existe");

        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
            die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
            die("Extensão de arquivo inválida para upload");

        $array1 = array($codcategoria);
        $resultado1 = ImagemCategoria($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminho"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        
        if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
        {
        echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
        }
        }else
        { 
        $array1 = array($codcategoria);
        $resultado1 = ImagemCategoria($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminho"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        $nome_arquivo='foto.png';
        }

        $array = array($nome, $nome_arquivo, $codcategoria);
        alterarCategoria($conexao, $array);
        header('location:../../index.php');  

        }
        else
        {   

        if($_POST['acaocategoria']=='excluir')
        {

            $codcategoria= $_POST['codcategoria'];
            $array1 = array($codcategoria);
            $resultado1 = ImagemCategoria($conexao,$array1);

            if("foto.png"!=$resultado1){
                $mascara="$caminho"."/".$resultado1;
                array_map( "unlink", glob( $mascara) );
            }
        $array=array($codcategoria);
        deletarCategoria($conexao, $array);
        header('Location:../../index.php');

        }
        }
    }



####USUARIO####

#CADASTRO USUARIO
    if(isset($_POST['usuario'])){
        include "config_upload.php";

        $nome=$_POST['nome'];
        $senha=password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];

        if (!empty($nome_arquivo))
        {
            if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo"))
                die("Arquivo já existe");

            if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
                die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

            $ext = strrchr($nome_arquivo,'.');
            if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
                die("Extensão de arquivo inválida para upload");
        
            if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
        {
            echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
            $nome_arquivo='foto.png';
        }
        }
        else
        { 
            $nome_arquivo='foto.png';
        }
        $array = array($nome, $email, $senha, $nome_arquivo);
        $retorno=inserirUsuario($conexao, $array);

        if($retorno)
            {
            $hash=md5($email);
            $link="<a href='localhost/CRUD_AtividadeFinal/valida_email.php?h=".$hash."'> Clique aqui para confirmar seu cadastro </a>";
            $mensagem="<tr><td style='padding: 10px 0 10px 0;' align='center' bgcolor='#669999'>";
            $mensagem.="<img src='cid:logo_ref' style='display: inline; padding: 0 10px 0 10px;' width='10%' />";

            $mensagem.="Email de Confirmação <br>".$link."</td></tr>";
            $assunto="Confirme seu cadastro";

            $retorno= enviaEmail($email,$nome,$mensagem,$assunto);
            $_SESSION["msg"]= "Valide o Cadastro no email";

            }
            else
            {
            $_SESSION["msg"].= 'Erro ao inserir <br>';
            }
        header('location:../../index.php'); 
    
}

#ALTERAR USUARIO
    if(isset($_POST['acaousuario'])){    
        include "config_upload.php";

        if($_POST['acaousuario']=='editar')
        {

        $codusuario= $_POST['codusuario'];
        $nome= $_POST['nome'];
        $senha=$_POST['senha'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];

        if (!empty($nome_arquivo))
        {
        if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo"))
            die("Arquivo já existe");

        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
            die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
            die("Extensão de arquivo inválida para upload");

        $array1 = array($codusuario);
        $resultado1 = ImagemUsuario($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminho"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        
        if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
        {
        echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
        }
        }else
        { 
        $array1 = array($codusuario);
        $resultado1 = ImagemUsuario($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminho"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        $nome_arquivo='foto.png';
        }
        $array = array($nome, $senha, $nome_arquivo, $codusuario);
        alterarUsuario($conexao, $array);
        header('location:../../index.php');  

        }
        else
        {   

        if($_POST['acaousuario']=='excluir')
        {

            $codusuario= $_POST['codusuario'];
            $array1 = array($codusuario);
            $resultado1 = ImagemUsuario($conexao,$array1);

            if("foto.png"!=$resultado1){
                $mascara="$caminho"."/".$resultado1;
                array_map( "unlink", glob( $mascara) );
            }
        $array=array($codusuario);
        deletarUsuario($conexao, $array);
        header('Location:../../index.php');

        }
        }
    }



####ITENS####

#ALTERAR ITENS
    if(isset($_POST['acaoitem'])){    
        include "config_upload.php";

        if($_POST['acaoitem']=='editar')
        {
        $coditem= $_POST['coditem'];
        $codfornecedor= $_POST['codfornecedor'];
        $codvenda= $_POST['codvenda'];
        $nome= $_POST['nome'];
        $item_desc=$_POST['item_desc'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];
        $descricao=$_POST['descricao'];
            $endereco=$_POST['endereco'];
            $email_contato=$_POST['email_contato'];
            $cnpj=$_POST['cnpj'];
            $destino=$_POST['destino'];
            $venda=$_POST['venda'];
            $dt_saida=$_POST['dt_saida'];
            $num_telefone=$_POST['num_telefone'];
            $num_forn=$_POST['num_forn'];
        
        if (!empty($nome_arquivo))
        {
        if($sobrescrever=="não" && file_exists("$caminhoitem/$nome_arquivo"))
            die("Arquivo já existe");

        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
            die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
            die("Extensão de arquivo inválida para upload");

        $array1 = array($coditem);
        $resultado1 = ImagemItem($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminhoitem"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        
        if (move_uploaded_file($arquivo_temporario, "$caminhoitem/$nome_arquivo"))
        {
        echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
        }
        }else
        { 
        $array1 = array($coditem);
        $resultado1 = ImagemItem($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminhoitem"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        $nome_arquivo='foto.png';
        }
        $array = array($nome, $item_desc, $nome_arquivo, $coditem);
        alterarItem($conexao, $array);
        
            $array1 = array($descricao, $endereco, $email_contato, $cnpj, $codfornecedor);
            alterarFornecedor($conexao, $array1);

            $array2 = array($destino, $venda, $dt_saida, $codvenda);
            alterarDestino($conexao, $array2);

            $array3= array($num_telefone,$codvenda);
            alterarFonesDestino($conexao, $array3);

            $array4= array($num_forn,$codfornecedor);
            alterarFonesFornecedor($conexao, $array4);
        
        header('location:../../index.php');  

        }
        else
        {   

        if($_POST['acaoitem']=='excluir')
        {

            $coditem= $_POST['coditem'];
            $codfornecedor= $_POST['codfornecedor'];
            $codvenda= $_POST['codvenda'];
            $array1 = array($coditem);
            $resultado1 = ImagemItem($conexao,$array1);

            if("foto.png"!=$resultado1){
                $mascara="$caminhoitem"."/".$resultado1;
                array_map( "unlink", glob( $mascara) );
            }
        $array=array($coditem);
        $array2=array($codfornecedor);
        $array3=array($codvenda);
        deletarItem($conexao, $array);
        deletarFonesFornecedor($conexao, $array2);
        deletarFornecedor($conexao, $array2);
        deletarFonesDestino($conexao, $array3);
        deletarDestino($conexao, $array3);

        header('Location:../../index.php');

        }
        }
    }

#CADASTRO ITEM
    if(isset($_POST['item'])){
        

        include "config_upload.php";


            $codusuario=$_POST['codusuario'];
            $codcategoria=$_POST['codcategoria'];
            $nome=$_POST['nome'];
            $item_desc=$_POST['item_desc'];
            $nome_arquivo=$_FILES['arquivo']['name'];  
            $tamanho_arquivo=$_FILES['arquivo']['size']; 
            $arquivo_temporario=$_FILES['arquivo']['tmp_name'];
            $descricao=$_POST['descricao'];
            $endereco=$_POST['endereco'];
            $email_contato=$_POST['email_contato'];
            $cnpj=$_POST['cnpj'];
            $destino=$_POST['destino'];
            $venda=$_POST['venda'];
            $dt_saida=$_POST['dt_saida'];
            $num_telefone=$_POST['num_telefone'];
            $num_forn=$_POST['num_forn'];

        if (!empty($nome_arquivo))
        {
            if($sobrescrever=="não" && file_exists("$caminhoitem/$nome_arquivo"))
                die("Arquivo já existe");

            if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
                die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

            $ext = strrchr($nome_arquivo,'.');
            if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
                die("Extensão de arquivo inválida para upload");
        
            if (move_uploaded_file($arquivo_temporario, "$caminhoitem/$nome_arquivo"))
        {
            echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
            $nome_arquivo='foto.png';
        }
        }
        else
        { 
            $nome_arquivo='foto.png';
        }

        if($descricao){
            $array1 = array($descricao, $endereco, $email_contato, $cnpj);
            inserirFornecedor($conexao, $array1);
            $array2 = array($descricao);
            $query= "select codfornecedor from origem_fornecedores where descricao=?";
            $resultado=ConsultaSelect($query,$array2);
            if($resultado)
                $codfornecedor=$resultado['codfornecedor'];
            else
                $codfornecedor='';
        }
        if($destino){
            $array3 = array($destino, $venda, $dt_saida);
            inserirDestino($conexao, $array3);
            $array4 = array($destino);
            $query= "select codvenda from destino_venda where destino=?";
            $resultado=ConsultaSelect($query,$array4);
            if($resultado)
                $codvenda=$resultado['codvenda'];
            else
                $codvenda='';
        }
        $array5= array($num_telefone,$codvenda);
        inserirFonesDestino($conexao, $array5);

        $array6= array($num_forn,$codfornecedor);
        inserirFonesFornecedor($conexao, $array6);
        $array = array($codusuario, $codcategoria,$codfornecedor,$codvenda, $nome, $item_desc, $nome_arquivo);
        inserirItem($conexao, $array);
        header('location:../../index.php');
}



####AREAS####

#ALTERAR AREAS
    if(isset($_POST['acaoarea'])){    
        include "config_upload.php";

        if($_POST['acaoarea']=='editar')
        {
        $codarea= $_POST['codarea'];
        $nome= $_POST['nome'];
        $area_desc= $_POST['area_desc'];
        $nome_arquivo=$_FILES['arquivo']['name'];  
        $tamanho_arquivo=$_FILES['arquivo']['size']; 
        $arquivo_temporario=$_FILES['arquivo']['tmp_name'];

        
        if (!empty($nome_arquivo))
        {
        if($sobrescrever=="não" && file_exists("$caminhoitem/$nome_arquivo"))
            die("Arquivo já existe");

        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
            die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
            die("Extensão de arquivo inválida para upload");

        $array1 = array($codarea);
        $resultado1 = ImagemArea($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminhoitem"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        
        if (move_uploaded_file($arquivo_temporario, "$caminhoitem/$nome_arquivo"))
        {
        echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
        }
        }else
        { 
        $array1 = array($codarea);
        $resultado1 = ImagemArea($conexao,$array1);

        if("foto.png"!=$resultado1){
            $mascara="$caminhoitem"."/".$resultado1;
            array_map( "unlink", glob( $mascara) );
        }
        $nome_arquivo='foto.png';
        }
        $array = array($nome, $area_desc, $nome_arquivo, $codarea);
        alterarArea($conexao, $array);
        header('location:../../index.php');  

        }
        else
        {   

        if($_POST['acaoarea']=='excluir')
        {

            $codarea= $_POST['codarea'];
            $array1 = array($codarea);
            $resultado1 = ImagemArea($conexao,$array1);

            if("foto.png"!=$resultado1){
                $mascara="$caminhoitem"."/".$resultado1;
                array_map( "unlink", glob( $mascara) );
            }
        $array=array($codarea);
        deletarArea($conexao, $array);
        header('Location:../../index.php');

        }
        }
    }

#CADASTRO AREA
    if(isset($_POST['area'])){
        

        include "config_upload.php";

            $codusuario=$_POST['codusuario'];
            echo $codusuario;
            $codcategoria=$_POST['codcategoria'];
            $coditem=$_POST['coditem'];
            $nome=$_POST['nome'];
            $area_desc=$_POST['area_desc'];
            $nome_arquivo=$_FILES['arquivo']['name'];  
            $tamanho_arquivo=$_FILES['arquivo']['size']; 
            $arquivo_temporario=$_FILES['arquivo']['tmp_name'];
            
        if (!empty($nome_arquivo))
        {
            if($sobrescrever=="não" && file_exists("$caminhoitem/$nome_arquivo"))
                die("Arquivo já existe");

            if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
                die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

            $ext = strrchr($nome_arquivo,'.');
            if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
                die("Extensão de arquivo inválida para upload");
        
            if (move_uploaded_file($arquivo_temporario, "$caminhoitem/$nome_arquivo"))
        {
            echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";
        }
        else
        {
            echo "Arquivo não pode ser copiado para o servidor.";
            $nome_arquivo='foto.png';
        }
        }
        else
        { 
            $nome_arquivo='foto.png';
        }

        $array = array($codusuario, $codcategoria, $coditem, $nome, $area_desc, $nome_arquivo);
        inserirArea($conexao, $array);
        header('location:../../index.php');
}



####PESQUISAR#####
#PESQUISAR ITEM
    if(isset($_POST['pesquisar'])){
        $nome = strtoupper($_POST['nome']);
        $array=array("%".$nome."%");
        $itens=pesquisaritem($conexao, $array);
        require_once('mostrarpesquisa.php');   
    }
?>