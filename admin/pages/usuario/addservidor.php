<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Revendedores
        <small>Adiciona um Servidor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usúarios</li>
        <li class="active">Add Servidor</li>
      </ol>
    </section>

<section class="content">
      <div class="row">

         <div class="col-lg-12">
         <div class="callout callout-info lead">
          <h4><i class="fa fa-info"></i> Adicionar Servidor!</h4>
          <p>Você adiciona um servidor e uma quantidade de limite que você queira aos seus Revendedores.</p>
        </div>

              <p class="m-t-10 m-b-20 f-16">Escolha um servidor abaixo</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Adicionar Servidor aos Revendedores</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/usuario/addservidor_exe.php" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Selecione um Servidor</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-server"></i>
                              </div>
                                 <select class="form-control select2" style="width: 100%;"  name="servidor" id="servidor">

                  <?php



	                $SQLAcesso= "select * from servidor where tipo='premium'";
                    $SQLAcesso = $conn->prepare($SQLAcesso);
                    $SQLAcesso->execute();


if (($SQLAcesso->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcesso->fetch()) {







		?>

	<option value="<?php echo $row_srv['id_servidor'];?>" > <?php echo $row_srv['nome'];?> - <?php echo $row_srv['ip_servidor'];?></option>

   <?php }
}else{ ?>
<option>Nenhum Servidor</option>
<?php
}

?>


                </select>

                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Revendedor</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                                <select class="form-control select2" style="width: 100%;"  name="revendedor" id="revendedor">


                  <?php



	   $SQL = "SELECT * FROM usuario where tipo='revenda' and subrevenda='nao' and id_mestre=0";
       $SQL = $conn->prepare($SQL);
       $SQL->execute();



if (($SQL->rowCount()) > 0) {
    // output data of each row
    while($row = $SQL->fetch()) {

       $SQLServidor = "select * from acesso_servidor  WHERE id_usuario = '".$row['id_usuario']."' ";
       $SQLServidor = $conn->prepare($SQLServidor);
       $SQLServidor->execute();
       $acesso_server=$SQLServidor->rowCount();

    ?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?> - Servidores Alocados: <?php echo $acesso_server;?> </option>

   <?php }
}else{ ?>
<option>Nenhum Revendedor</option>
<?php
}

?>


                </select>

                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Validade em Dias</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="number" name="dias" id="dias" class="form-control" placeholder="1" required>

                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Limite</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-ticket"></i>
                              </div>
                              <input type="number" name="limite" id="limite" placeholder="1" class="form-control" required>

                              </div>
                              </div>
                            </div>
                          </div>

                          </div>



<div class="text-center  m-t-20 box-footer">
                    <button type="submit" class="btn btn-embossed btn-primary">Salvar Registro</button>
                          <button type="reset" class="cancel btn btn-embossed btn-default m-b-10 m-r-0">Limpar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



            </div>
               </div>
                  </div>













      </div>
      <!-- /.row -->
    </section>