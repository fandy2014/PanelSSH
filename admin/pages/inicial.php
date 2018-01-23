<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();


        // Clientes
        $SQLbuscaclientes= "select * from usuario where tipo='vpn'";
        $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
        $SQLbuscaclientes->execute();
        $totalclientes = $SQLbuscaclientes->rowCount();
        // Revendedores
        $SQLbuscarevendedores= "select * from  usuario where tipo='revenda'";
        $SQLbuscarevendedores = $conn->prepare($SQLbuscarevendedores);
        $SQLbuscarevendedores->execute();
        $totalrevendedores = $SQLbuscarevendedores->rowCount();
        // Servidores
        $SQLbuscaservidores= "select * from  servidor";
        $SQLbuscaservidores= $conn->prepare($SQLbuscaservidores);
        $SQLbuscaservidores->execute();
        $totalservidores = $SQLbuscaservidores->rowCount();

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
              <h3 class="widget-user-username"><?php echo $administrador['nome'];?></h3><h3 class="widget-user-username pull-right">Seja Bem-Vindo</h3>
              <h5 class="widget-user-desc">Fundador &amp; CEO</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="../dist/img/user2-160x160.jpg" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $totalclientes;?></h5>
                    <span class="description-text">Clientes</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $totalrevendedores;?></h5>
                    <span class="description-text">Revendedores</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $totalservidores;?></h5>
                    <span class="description-text">Servidores</span>
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
                   <!-- inicia o box de cada coisa -->
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
              <h3><?php echo $total_acesso_ssh;?></h3>

              <p>Acessos</p>
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




		     <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $contas_ssh;?></h3>

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


                   <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo $servidor_qtd; ?></h3>

              <p>Servidores</p>
            </div>
            <div class="icon">
              <i class="fa fa-server"></i>
            </div>
            <a href="home.php?page=servidor/listar" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

       <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $ssh_susp_qtd;?></h3>

              <p>Contas SSH Susp.</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="home.php?page=ssh/contas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

      <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $all_usuarios_revenda_qtd;?></h3>

              <p>Revendedores</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="home.php?page=usuario/revenda" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

    <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $revenda_qtd_susp;?></h3>

              <p>Revendedores Susp.</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="home.php?page=usuario/revenda" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->


  <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $all_usuarios_vpn_qtd;?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="home.php?page=usuario/usuario_ssh" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->


		  <!-- inicia o box de cada coisa -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $all_usuarios_vpn_qtd_susp;?></h3>

              <p>Clientes SSH Susp.</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="home.php?page=usuario/usuario_ssh" class="small-box-footer">
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
            <a href="../home.php?page=faturas/abertas" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

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
            <a href="home.php?page=usuario/usuario_ssh" class="small-box-footer">
              Mais informações <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
         <!-- fim -->

      </div>
      <!-- /.row -->

       <!-- /.row -->


      <!-- /.row -->






    </section>
    <!-- /.content -->
  </div>