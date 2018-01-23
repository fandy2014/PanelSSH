<?php
require_once("../pages/system/funcoes.php");
require_once("../pages/system/seguranca.php");
require_once("../pages/system/config.php");
require_once("../pages/system/classe.ssh.php");

protegePagina("admin");
if( $_SESSION['tipo'] == "user"){
	expulsaVisitante();
}


		$data_atual = date("Y-m-d");

		$SQLAdministrador = "SELECT * FROM admin WHERE id_administrador = '".$_SESSION['usuarioID']."'";
        $SQLAdministrador = $conn->prepare($SQLAdministrador);
        $SQLAdministrador->execute();
        $administrador = $SQLAdministrador->fetch();

		 //Carrega qtd contas ssh do sistema

		$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE status='2' ";
        $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
        $SQLUsuario_sshSUSP->execute();
        $ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

		$SQLContasSSH = "SELECT * FROM usuario_ssh ";
        $SQLContasSSH = $conn->prepare($SQLContasSSH);
        $SQLContasSSH->execute();
        $contas_ssh = $SQLContasSSH->rowCount();


		$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh  ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];

		$total_acesso_ssh_online = 0;
	    $SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];


		//carrega qtd de todos os usuarios do sistema
		$SQLUsuarios = "SELECT * FROM usuario ";
        $SQLUsuarios = $conn->prepare($SQLUsuarios);
        $SQLUsuarios->execute();
        $all_usuarios_qtd = $SQLUsuarios->rowCount();

		//carrega qtd de todos os usuarios do sistema SSH
		$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' ";
        $SQLVPN = $conn->prepare($SQLVPN);
        $SQLVPN->execute();
        $all_usuarios_vpn_qtd = $SQLVPN->rowCount();

		$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' and ativo='2' ";
        $SQLVPN = $conn->prepare($SQLVPN);
        $SQLVPN->execute();
        $all_usuarios_vpn_qtd_susp = $SQLVPN->rowCount();

		//carrega qtd de todos os usuarios do sistema SSH
		$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' ";
        $SQLRevenda = $conn->prepare($SQLRevenda);
        $SQLRevenda->execute();
        $all_usuarios_revenda_qtd = $SQLRevenda->rowCount();
		//carrega qtd de todos os usuarios do sistema SSH
		$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' and ativo='2'";
        $SQLRevenda = $conn->prepare($SQLRevenda);
        $SQLRevenda->execute();
        $revenda_qtd_susp = $SQLRevenda->rowCount();

		//carrega qtd de servidores
		$SQLServidor = "SELECT * FROM servidor ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
        $servidor_qtd = $SQLServidor->rowCount();

        // arquivos download
        $SQLArquivos= "select * from  arquivo_download";
        $SQLArquivos = $conn->prepare($SQLArquivos);
        $SQLArquivos->execute();
        $todosarquivos = $SQLArquivos->rowCount();
        // Faturas
        $SQLfaturas= "select * from  fatura where status='pendente'";
        $SQLfaturas = $conn->prepare($SQLfaturas);
        $SQLfaturas->execute();
        $faturas = $SQLfaturas->rowCount();
         // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and admin='sim'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();
         // Notificações fatura
        $SQLnoti2= "select * from  notificacoes where lido='nao' and tipo='fatura' and admin='sim'";
        $SQLnoti2= $conn->prepare($SQLnoti2);
        $SQLnoti2->execute();
        $totalnoti_fatura = $SQLnoti2->rowCount();
        // Notificações chamados
        $SQLnoti3= "select * from  notificacoes where lido='nao' and tipo='chamados' and admin='sim'";
        $SQLnoti3= $conn->prepare($SQLnoti3);
        $SQLnoti3->execute();
        $totalnoti_chamados = $SQLnoti3->rowCount();

         //Todos os chamados subRevendedores e usuarios do revendedor
        $SQLchamadoscli2= "select * from  chamados where status='resposta' and id_mestre=0";
        $SQLchamadoscli2= $conn->prepare($SQLchamadoscli2);
        $SQLchamadoscli2->execute();
        $all_chamados += $SQLchamadoscli2->rowCount();
        //Todos os chamados subRevendedores e usuarios do revendedor
        $SQLchamadoscli= "select * from  chamados where status='aberto' and id_mestre=0";
        $SQLchamadoscli= $conn->prepare($SQLchamadoscli);
        $SQLchamadoscli->execute();
        $all_chamados += $SQLchamadoscli->rowCount();



	?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pservers | Painel </title>
 <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <!-- Select 2 -->
  <link rel="stylesheet" href="../plugins/select2/select2.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="../painelmods.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut('slow');;
	});
</script>

<body class="hold-transition skin-red-light sidebar-mini">
	<!-- Paste this code after body tag -->
	<div class="se-pre-con"></div>
	<!-- Ends -->
<!-- Site wrapper -->
<div class="wrapper">

 <div class="modal fade" id="flaggeral" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-flag"></i> Alertar Todos!</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/notificacoes/notificar_home.php" method="post">
			 <div class="form-group">
                <label for="exampleInputEmail1">Tipo de Notificação </label>
                <select size="1" name="clientes" class="form-control select2 col-lg-12">
                <option value="1" selected=selected>Todos</option>
                <option value="2">Revendedores</option>
                <option value="3" >Clientes</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Mensagem</label>
                <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
              </div>



		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal" role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Confirmar</button>

				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
</div>

<script>
function usuariosonline()
{

	// Requisição
	$.post('pages/ssh/online_home.php?requisicao=1',
	function (resposta) {
	        //Adiciona Efeito Fade
	        $("#usuarioson").fadeOut("slow").fadeIn('slow');
			// Limpa
			$('#usuarioson').empty();
			// Exibe
			$('#usuarioson').append(resposta);
	});
}
// Intervalo para cada Chamada
setInterval("usuariosonline()", 30000);

// Após carregar a Pagina Primeiro Requisito
$(function() {
		// Requisita Função acima
		usuariosonline();
});
</script>
<script>
function atualizar()
{
		// Fazendo requisição AJAX
		$.post('pages/ssh/online_home.php?requisicao=2',
		function (online) {
				// Exibindo frase
				$('#online_nav').html(online);
				$('#online').html(online);

		}, 'JSON');
}
// Definindo intervalo que a função será chamada
setInterval("atualizar()", 10000);
// Quando carregar a página
$(function() {
		// Faz a primeira atualização
		atualizar();
});
</script>


<!-- =============================================== -->

   <header class="main-header">
          <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SSH</b></span>
				<span class="logo-lg"><b>Pservers</b>SSH</span>
    </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">

         <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
      </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications: style can be found in dropdown.less -->


               <li class="dropdown notifications-menu">
                <a data-toggle="modal" href="#flaggeral" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-warning"></span>
                </a>

                </li>

                  <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-rocket"></i>
							<span class="label label-success" id="online_nav"><?php echo $total_acesso_ssh_online; ?></span>
						</a>
							<ul class="dropdown-menu">
	              <li class="header"><center>Usuários Online</center></li>
	              <li>
	                <!-- inner menu: contains the actual data -->
	                <ul class="menu" id="usuarioson">

	                </ul>
	              </li>
	              <li class="footer"><a href="home.php?page=ssh/online" >Ver Todos</a></li>
	            </ul>
          </li>

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php echo $totalnoti;?></span>
                </a>
                <ul class="dropdown-menu">
                 <?php if($totalnoti==0){?>
                 <li class="header">Você não possui novas notificações</li>
                 <?php }else{ ?>
                 <li class="header">Você possui <?php echo $totalnoti;?> nova<?php if($totalnoti>1){ echo "s";}?> <?php if($totalnoti<=1){ echo "notificação";}else { echo "notificações";}?></li>
                  <?php }?>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                       <li>
                        <a href="?page=notificacoes/notificacoes&ler=fatu">
                          <i class="fa fa-shopping-cart text-green"></i> <?php echo $totalnoti_fatura;?> Em Faturas
                        </a>
                      </li>

                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=chamados">
                          <i class="fa fa-ticket text-red"></i> <?php echo $totalnoti_chamados;?> Em Chamados
                        </a>
                      </li>
                     <?php /*
                    <?php if($usuario['tipo']=='revenda'){ ?>
                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=reve">
                          <i class="fa fa-users text-aqua"></i> <?php echo $totalnoti_revenda;?> Em Revendas
                        </a>
                      </li>
                      <?php } ?>

                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=others">
                          <i class="fa fa-info-circle"></i> <?php echo $totalnoti_outros;?> Em Outros
                        </a>
                      </li>
                      <?php */ ?>
                    </ul>
                  </li>
                  <li class="footer"><a href="?page=notificacoes/notificacoes&ler=all">Ver Todos</a></li>
                </ul>
              </li>
                <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li>
            <a href="sair.php" ><i class="fa fa-power-off"></i> </a>
          </li>
        </ul>
      </div>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs"> Painel - <?php echo ucfirst($administrador['nome']);?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      <?php echo strtoupper($administrador['nome']);?> - Administrador
                    </p>
                  </li>
                  <!-- Menu Body
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Contas SSH</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Online</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="home.php?page=admin/dados" class="btn btn-default btn-flat">Meu Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="sair.php" class="btn btn-default btn-flat">Desconectar</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $administrador['nome']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">NAVEGAÇÃO PRINCIPAL</li>

		   <li>
          <a href="home.php">
            <i class="fa fa-home"></i> <span>INÍCIO</span>
          </a>
        </li>


        <li class="treeview ">
          <a href="#">
            <i class="fa fa-terminal"></i>
            <span>CONTAS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"> <?php echo $contas_ssh; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=ssh/adicionar"><i class="fa fa-circle-o"></i>Nova conta SSH</a></li>

            <li ><a href="?page=ssh/contas"><i class="fa fa-circle-o"></i>Listar contas </a></li>
			<li ><a href="?page=ssh/online"><i class="fa fa-circle-o"></i>Contas  Online</a></li>
			<li ><a href="?page=ssh/erro"><i class="fa fa-circle-o"></i>Contas com erro</a></li>
          </ul>
        </li>



	    <li class="treeview ">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>CLIENTES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $all_usuarios_qtd; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=usuario/1-etapa"><i class="fa fa-circle-o"></i>Novo usuário</a></li>
			<li><a href="?page=usuario/revenda"><i class="fa fa-circle-o"></i>Revendedores SSH <span class="label label-primary pull-right"><?php echo $all_usuarios_revenda_qtd; ?></span></a></li>
            <li><a href="?page=usuario/usuario_ssh"><i class="fa fa-circle-o"></i>Usuários SSH <span class="label label-primary pull-right"><?php echo $all_usuarios_vpn_qtd; ?></span></a></li>
             <li><a href="?page=usuario/addservidor"><i class="fa fa-circle-o"></i> ADD Servidor <small class="label pull-right bg-green">Novo</small></a></li>
          </ul>
        </li>

		 <li class="treeview ">
          <a href="#">
            <i class="fa fa-server"></i>
            <span>SERVIDORES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $servidor_qtd; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=servidor/adicionar"><i class="fa fa-circle-o"></i>Novo servidor</a></li>
            <li><a href="?page=servidor/listar"><i class="fa fa-circle-o"></i>Listar servidores</a></li>
            <li><a href="?page=servidor/alocados"><i class="fa fa-circle-o"></i>Servidores Alocados</a></li>
          </ul>
        </li>

        <li class="treeview ">
          <a href="#">
            <i class="fa fa-usd"></i>
            <span>FATURAS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $faturas; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=faturas/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=faturas/pagas"><i class="fa fa-circle-o"></i>Pagas</a></li>
            <li><a href="?page=faturas/canceladas"><i class="fa fa-circle-o"></i>Canceladas</a></li>
            <li><a href="?page=faturas/comprovantes"><i class="fa fa-circle-o"></i>Comprovantes</a></li>
            <li><a href="?page=faturas/cpfechados"><i class="fa fa-circle-o"></i>CP Fechados</a></li>
          </ul>
        </li>
          <li class="treeview ">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>CHAMADOS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $all_chamados; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=chamados/abertas"><i class="fa fa-circle-o"></i>Abertos</a></li>
            <li><a href="?page=chamados/respondidos"><i class="fa fa-circle-o"></i>Respondidos</a></li>
            <li><a href="?page=chamados/encerrados"><i class="fa fa-circle-o"></i>Encerrados</a></li>
          </ul>
        </li>
        <li class="treeview ">
          <a href="?page=apis/gerenciar">
            <i class="fa fa-sliders"></i> <span>GERENCIAR APIS</span>
           </a>
             <ul class="treeview-menu">

            <li><a href="?page=apis/gerenciar"><i class="fa fa-circle-o"></i>Sistemas</a></li>

          </ul>
        </li>

          <li>
          <a href="?page=notificacoes/notificar">
            <i class="fa fa-info-circle"></i> <span>NOTIFICAÇÕES</span>

          </a>
        </li>

	      <li>
          <a href="?page=admin/dados">
            <i class="fa fa-gear"></i> <span>CONFIGURAÇÕES</span>

          </a>
        </li>
		 <li>
          <a href="?page=email/enviaremail">
            <i class="fa fa-tty"></i> <span>EMAIL</span>

          </a>
        </li>
         <li>
          <a href="?page=download/downloads">
            <i class="fa fa-cloud-download"></i> <span>NUVEM</span>
             <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">Novo</small> -->
            </span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
     <?php


					if(isset($_GET["page"])){
					$page = $_GET["page"];
					if($page and file_exists("pages/".$page.".php")) {
					include("pages/".$page.".php");
					} else {
					include("./pages/inicial.php");
				  }
				}else{
					include("./pages/inicial.php");
				}


			?>



    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
  <!-- BEGIN PRELOADER -->

    <!-- END PRELOADER -->


<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>


<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>


<script src="../plugins/select2/select2.full.min.js"></script>
<script>
			$(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
</body>
</html>
