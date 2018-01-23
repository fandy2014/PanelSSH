<?php

require_once("system/seguranca.php");
require_once("system/config.php");

protegePagina("user");


		 $SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
         $SQLUsuario = $conn->prepare($SQLUsuario);
         $SQLUsuario->execute();
         $usuario = $SQLUsuario->fetch();

		if(($usuario['ativo']==1)|| ($usuario['tipo']=='vpn')){
			                 echo '<script type="text/javascript">';
			                 echo 	'alert("Sua conta não encontra-se Suspensa!");';
			                 echo	'window.location="../home.php";';
			                 echo '</script>';
							 exit;
		}
	?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PserversSSH | Conta Suspensa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="#"><b>Pservers</b>SSH</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Seu acesso está Suspenso!</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="../dist/img/user2-160x160.jpg" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->

        <center><p  class="form-control"> Pagamento em atraso</p></center>



    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <br>
  <div class="text-center">
    <a href="#">Resolva a sua situação agora mesmo entre em contato pelo telegram com o @salvadorsucessos!!</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2017-2018 <b><a href="#" class="text-black">Pservers</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
