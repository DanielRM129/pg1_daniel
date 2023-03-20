<?php
function fazconexao(){
    
    //conexao via PDO
    //try = tenta fazer o que há no bloco
    try{
        $conexao = new PDO("mysql:host=localhost; dbname=gaveteirovirtual; charset=utf8", "root","");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return($conexao);
        } //caso de algum erro, executa o catch
    catch(PDOException $ex){
    //encerra e apresenta mensagem de erro
    die($ex->getMessage());
    }

}

function ConsultaSelect($sql,$parametros=array()){
    try {
        //conecta
        $conexaoBD = fazConexao();
        //cria o objeto de consulta
        $consulta = $conexaoBD->prepare($sql);
        //executa a consulta
        if (sizeof($parametros) > 0) { 
           $result = $consulta->execute($parametros);
        } 
        else{

            $result = $consulta->execute();
        }  

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return($resultado);
    }
    catch (PDOException $e) {
        echo $e;
    }
}

function fazConsulta($sql,$parametros=array()){
    try {
          //conecta
        $conexaoBD = fazConexao();
        //cria o objeto de consulta
        $consulta = $conexaoBD->prepare($sql);
        //testa se foram passados parâmetros
        
        if (sizeof($parametros) > 0) { 
            $resultado=$consulta->execute($parametros);
        } 
        else{

             $resultado=$consulta->execute();
        }    
     
        return $resultado;
    }
    catch (PDOException $e) {
        echo $e;
    }
}

function pesquisarPessoaEmail($conexao,$array){
        try {

        $query = $conexao->prepare("select * from usuarios where md5(email) = ?");
        if($query->execute($array)){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
          if ($usuario)
            {  
                return $usuario;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

 function alterarStatustrue($conexao, $array){
        try {
            session_start();
            $query = $conexao->prepare("update usuarios set status = true where codusuario = ?");
            $resultado = $query->execute($array);   
           // $_SESSION['nome']=$array[0];         
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

####CATEGORIAS####

    function listarCategoria($conexao){
      try {
        $nome = $_SESSION['nome'];
        $sql = "select * from categorias where codusuario = (select codusuario ";
        $sql .= "from usuarios where nome = ";
        $sql .= "'$nome')";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

    function identificarUsuario($conexao){
      try {
        $nome = $_SESSION['nome'];
        echo $nome;
        $sql = "select codusuario ";
        $sql .= "from usuarios where nome = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $usuarios = $query->fetchAll();
        return $usuarios;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }    

    function inserirCategoria($conexao,$array){
       try {
            $query = $conexao->prepare("insert into categorias (codusuario, nome, imagem) values (?, ?, ?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function ImagemCategoria($conexao,$array1){
       try {
            $query = $conexao->prepare("select imagem from categorias where codcategoria = ?");

            $resultado = $query->execute($array1);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function alterarCategoria($conexao, $array){
        try {
            $query = $conexao->prepare("update categorias set nome=?,imagem=?  where codcategoria = ?");
            $resultado = $query->execute($array);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function deletarCategoria($conexao, $array){
        try {
            $query = $conexao->prepare("delete from categorias where codcategoria = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
    


####USUARIOS####

    function inserirUsuario($conexao,$array){
       try {
            $query = $conexao->prepare("insert into usuarios (nome,email,senha,imagem) values (?,?,?,?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function listarUsuario($conexao){
      try {
        $query = $conexao->prepare("select * from usuarios order by codusuario");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }
     
    function ImagemUsuario($conexao,$array1){
       try {
            $query = $conexao->prepare("select imagem from usuarios where codusuario = ?");

            $resultado = $query->execute($array1);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    
    function alterarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("update usuarios set nome=?, senha=?, imagem=?  where codusuario = ?");
            $resultado = $query->execute($array);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    
    function deletarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("delete from usuarios where codusuario = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }



####ITENS####

    function listarItens($conexao){
      try {
        $_SESSION['categoria']=$_GET['categoria'];
        $nome = $_SESSION['categoria'];
        echo $_SESSION['categoria'];
        $sql = "select * from itens where codcategoria = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

    function ImagemItem($conexao,$array1){
       try {
            $query = $conexao->prepare("select imagem from itens where coditem = ?");

            $resultado = $query->execute($array1);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function alterarItem($conexao, $array){
        try {
            $query = $conexao->prepare("update itens set nome=?, item_desc=?, imagem=? where coditem = ?");
            $resultado = $query->execute($array);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function deletarItem($conexao, $array){
        try {
            $query = $conexao->prepare("delete from itens where coditem = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function inserirItem($conexao,$array){
       try {
            $query = $conexao->prepare("insert into itens (codusuario,codcategoria,codfornecedor,codvenda,nome,item_desc,imagem) values (?, ?, ?, ?, ?, ?, ?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function inserirFornecedor($conexao,$array){
       try {
            $query = $conexao->prepare("insert into origem_fornecedores (descricao,endereco,email_contato,cnpj) values (?, ?, ?, ?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function listarFornecedores($conexao){
      try {
       
        $nome = $_SESSION['codfornecedor'];
        $sql = "select * from origem_fornecedores where codfornecedor = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

function deletarFornecedor($conexao, $array){
        try {
            $query = $conexao->prepare("delete from origem_fornecedores where codfornecedor = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function alterarFornecedor($conexao, $array){
        try {
            $query = $conexao->prepare("update origem_fornecedores set descricao=?, endereco=?, email_contato=?, cnpj=? where codfornecedor = ?");
            $resultado = $query->execute($array); 

            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
#DESTINO
function inserirDestino($conexao,$array){
       try {
            $query = $conexao->prepare("insert into destino_venda (destino, venda, dt_saida) values (?, ?, ?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function listarDestino($conexao){
      try {
       
        $nome = $_SESSION['codvenda'];
        $sql = "select * from destino_venda where codvenda = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

function deletarDestino($conexao, $array){
        try {
            $query = $conexao->prepare("delete from destino_venda where codvenda = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function alterarDestino($conexao, $array){
        try {
            $query = $conexao->prepare("update destino_venda set destino=?, venda=?, dt_saida=? where codvenda = ?");
            $resultado = $query->execute($array); 

            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

#FONES DESTINO
function inserirFonesDestino($conexao,$array){
       try {
            $query = $conexao->prepare("insert into fones_destino (num_telefone, codvenda) values (?,?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function listarFonesDestino($conexao){
      try {
       
        $nome = $_SESSION['codvenda'];
        $sql = "select * from fones_destino where codvenda = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

function deletarFonesDestino($conexao, $array){
        try {
            $query = $conexao->prepare("delete from fones_destino where codvenda = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function alterarFonesDestino($conexao, $array){
        try {
            $query = $conexao->prepare("update fones_destino set num_telefone=? where codvenda = ?");
            $resultado = $query->execute($array); 

            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


#FONES Fornecedor
function inserirFonesFornecedor($conexao,$array){
       try {
            $query = $conexao->prepare("insert into fones_fornecedores (num_telefone, codfornecedor) values (?,?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function listarFonesFornecedores($conexao){
      try {
       
        $nome = $_SESSION['codfornecedor'];
        $sql = "select * from fones_fornecedores where codfornecedor = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

function deletarFonesFornecedor($conexao, $array){
        try {
            $query = $conexao->prepare("delete from fones_fornecedores where codfornecedor = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

function alterarFonesFornecedor($conexao, $array){
        try {
            $query = $conexao->prepare("update fones_fornecedores set num_telefone=? where codfornecedor = ?");
            $resultado = $query->execute($array); 

            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

####AREAS####

    function listarAreas($conexao){
      try {
        $_SESSION['item']=$_GET['item'];
        $nome = $_SESSION['item'];
        echo $_SESSION['item'];
        $sql = "select * from areas where coditem = ";
        $sql .= "'$nome'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

    function ImagemArea($conexao,$array1){
       try {
            $query = $conexao->prepare("select imagem from areas where codarea = ?");

            $resultado = $query->execute($array1);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function alterarArea($conexao, $array){
        try {
            $query = $conexao->prepare("update areas set nome=?,area_desc=?,imagem=?  where codarea = ?");
            $resultado = $query->execute($array);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function deletarArea($conexao, $array){
        try {
            $query = $conexao->prepare("delete from areas where codarea = ?");
            $resultado = $query->execute($array);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function listarAreasItens($conexao){
      try {
        $sql1 = $_SESSION['item'];
        $sql = "select * from itens where coditem = ";
        $sql .= "'$sql1'";
        $query = $conexao->prepare("$sql");      
        $query->execute();
        $categorias = $query->fetchAll();
        return $categorias;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

    function inserirArea($conexao,$array){
       try {
            $query = $conexao->prepare("insert into areas (codusuario,codcategoria,coditem,nome,area_desc,imagem) values (?, ?, ?, ?, ?, ?)");

            $resultado = $query->execute($array);
            
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }




####PESQUISAR####

    function pesquisaritem($conexao,$array){
        try {
        $query = $conexao->prepare("select * from itens where upper(nome) like upper(?)");
        if($query->execute($array)){
            $itens = $query->fetchAll(); //coloca os dados num array $itens
          if ($itens)
            {  
                return $itens;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }


?>