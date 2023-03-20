<link rel="stylesheet" href="assets/css/index.css">

<?php
session_start();
?>

<link rel="stylesheet" href="assets/css/index.css">
<title>Login</title>
<script src="camposVazios.js"> </script>
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body class="grid">
 <img class="item1" src="imagens/logo.png"> 

<h1 class="item2"> Ola, Bem Vindo! </h1>

    <form class="item3" id="formulario" action="includes/logica/logica.php" method="post">
      <input class="subitem1" type="text" placeholder="USUÁRIO" name="nome" id="nome">
      <input class="subitem2" type="password" placeholder="SENHA" name="senha" id="senha">
      <button class="subitem3" type="submit" id='entrar' name='entrar' value="Entrar"> Entrar </button>      
    </form>
<p class="item5"><a href="esqueci_senha.php">Esqueci a senha</a><br>
<a href='form_cad_usuario.php'>Cadastrar</a></p>


<div id='msg' class="item6">
<?php 
if(isset($_SESSION['msg']))
{ 
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
}
?>
</div>
</body>
</html>