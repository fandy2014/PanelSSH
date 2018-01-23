<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();

        if($usuario['tipo']=='revenda'){
        // Clientes
        $SQLbuscaclientes= "select * from usuario where tipo='vpn' and id_mestre='".$usuario['id_usuario']."'";
        $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
        $SQLbuscaclientes->execute();
        $totalclientes = $SQLbuscaclientes->rowCount();

         // Servidores
        $SQLbuscaservidores= "select * from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
        $SQLbuscaservidores = $conn->prepare($SQLbuscaservidores);
        $SQLbuscaservidores->execute();
        $servidoresclientes = $SQLbuscaservidores->rowCount();

        // Cotas
        $totaldecotas=0;
        $SQLbuscacontasssh= "select sum(qtd) as cotas from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
        $SQLbuscacontasssh = $conn->prepare($SQLbuscacontasssh);
        $SQLbuscacontasssh->execute();
        $minhascotas = $SQLbuscacontasssh->fetch();
        $totaldecotas+=$minhascotas['cotas'];


        }else{        // Contas
        $SQLbuscacontinhas= "select * from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
        $SQLbuscacontinhas = $conn->prepare($SQLbuscacontinhas);
        $SQLbuscacontinhas->execute();
        $totalcontas = $SQLbuscacontinhas->rowCount();

        // Cotas
        $totaldecotas2=0;
        $SQLbuscacontasssh2= "select sum(acesso) as cotas from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
        $SQLbuscacontasssh2 = $conn->prepare($SQLbuscacontasssh2);
        $SQLbuscacontasssh2->execute();
        $minhascotas2 = $SQLbuscacontasssh2->fetch();
        $totaldecotas2+=$minhascotas2['cotas'];

        // Faturas
        if($usuario['id_mestre']==0){
        $SQLbuscafaturinhas= "select * from fatura where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
        $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
        $SQLbuscafaturinhas->execute();
        $minhasfatu = $SQLbuscafaturinhas->rowCount();
        }else{        // Faturas
        $SQLbuscafaturinhas= "select * from fatura_clientes where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
        $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
        $SQLbuscafaturinhas->execute();
        $minhasfatu = $SQLbuscafaturinhas->rowCount();

        }




        }

?>
 <!-- Main content -->
 <section class="content-header">
      <h1>
        Dashboard
        <small>Painel de Controle v2</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

      <!-- Inicial nova -->
    <section class="content">

    <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?php echo ucfirst($usuario['nome']);?></h3> <h3 class="widget-user-username pull-right">Seja Bem-Vindo</h3>
              <h5 class="widget-user-desc"><?php if($usuario['tipo']=='revenda'){ if($usuario['subrevenda']=='sim'){?>Acesso Conta SUBRevendedor<?php }else{ ?>Acesso Conta Revendedor<?php } }else{?>Acesso Cliente VPN<?php } ?></h5>

           </div>
            <div class="widget-user-image">
              <img class="img-circle" src="dist/img/<?php echo $avatarusu;?>" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                   <?php if($usuario['tipo']=='revenda'){?>
                   <h5 class="description-header"><?php echo $totalclientes;?></h5>
                   <span class="description-text">Clientes</span>
                    <?php }else{ ?>
                    <h5 class="description-header"><?php echo $totalcontas;?></h5>
                    <span class="description-text">Contas</span>
                    <?php } ?>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                  <?php if($usuario['tipo']=='revenda'){?>
                   <h5 class="description-header"><?php echo $totaldecotas;?></h5>
                   <span class="description-text">Cotas</span>
                    <?php }else{ ?>
                    <h5 class="description-header"><?php echo $totaldecotas2;?></h5>
                    <span class="description-text">Cotas</span>
                    <?php } ?>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                  <?php if($usuario['tipo']=='revenda'){?>
                   <h5 class="description-header"><?php echo $servidoresclientes;?></h5>
                   <span class="description-text">Servidores</span>
                    <?php }else{ ?>
                    <h5 class="description-header"><?php echo $minhasfatu;?></h5>
                    <span class="description-text">Faturas Abertas</span>
                    <?php } ?>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        </section>

     <!-- Noticias -->
    <?php if($procnoticias->rowCount()>0){
     $noticia=$procnoticias->fetch();

    $datapega=$noticia['data'];
    $data = date('D',strtotime($datapega));
    $mes = date('M',strtotime($datapega));
    $dia = date('d',strtotime($datapega));
    $ano = date('Y',strtotime($datapega));

    $semana = array(
        'Sun' => 'Domingo',
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terça-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado'
    );

    $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );


     ?>


    <div class="pad margin no-print">
      <div class="callout callout-success" style="margin-bottom: 0!important;">
        <h3><i class="fa fa-bullhorn"></i> <?php echo $noticia['titulo'];?> </h3> <br />
        <i class="fa fa-info"></i> <b><?php echo $noticia['subtitulo'];?></b><br /><br />
        <?php echo $noticia['msg'];?>
       <small> <i class="pull-right"><?php echo $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";;?></i></small>
      </div>
    </div>
    <?php } ?>


    <section class="content">

      <div class="row">

      <!--
       <div class="col-lg-12">
              <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><center>	<h4><i class="icon fa fa-check"></i>Bem-vindo!</h4></center></div>
            </div>
          inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="online"><?php echo $total_acesso_ssh_online; ?></h3>

              <p>Online</p>
            </div>
            <div class="icon">
              <i class="fa fa-rocket"></i>
            </div>
            <a href="home.php?page=ssh/online" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->






         <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php echo $quantidade_ssh; ?></h3>

              <p>Contas</p>
            </div>
            <div class="icon">
              <i class="fa fa-terminal"></i>
            </div>
            <a href="home.php?page=ssh/contas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->
         <?php if(($usuario['tipo']=="revenda") and ($usuario['subrevenda']=='nao') ){?>
           <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo $quantidade_sub_revenda; ?></h3>

              <p>Revendedores</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="home.php?page=subrevenda/revendedores" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->
         <?php }?>

          <?php if($usuario['tipo']=="revenda"){?>


        <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $quantidade_sub; ?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="home.php?page=usuario/listar" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

		<?php }?>

		 <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>

          <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo $acesso_servidor; ?></h3>

              <p>Meus Servidores</p>
            </div>
            <div class="icon">
              <i class="fa fa-server"></i>
            </div>
            <a href="home.php?page=servidor/meuservidor" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->


		<?php }?>
		   <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $todosarquivos; ?></h3>

              <p>Arquivos</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
            <a href="home.php?page=downloads/downloads" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

        <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3><?php echo $faturas; ?></h3>

              <p>Faturas</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
            <?php if($usuario['id_mestre']==0){?>
            <a href="home.php?page=faturas/abertas" class="small-box-footer">
            <?php }else{?>
             <a href="home.php?page=faturasclientes/minhas/abertas" class="small-box-footer">
            <?php } ?>
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

        <!-- /.col -->
          <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $all_chamados;?></h3>

              <p>Chamados</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="home.php?page=chamados/abertas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

        <?php if($usuario['tipo']=='revenda'){ ?>
         <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3><?php echo $faturas_clientes; ?></h3>

              <p>Faturas Clientes</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
             <a href="home.php?page=faturasclientes/abertas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

        <!-- /.col -->
          <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $all_chamados_clientes;?></h3>

              <p>Chamados Clientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="home.php?page=chamadosclientes/abertas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

         <?php } ?>

      </div>
      <!-- /.row -->








    </section>
    <!-- /.content -->
  </div>