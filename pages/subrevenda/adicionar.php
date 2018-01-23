<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
			$(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Subrevendas
        <small>Adiciona um Servidor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Subrevenda</li>
        <li class="active">Add Servidor</li>
      </ol>
    </section>

<section class="content">
      <div class="row">

         <div class="col-lg-12">
         <div class="callout callout-info lead">
          <h4><i class="fa fa-info"></i> Adicionar Servidor!</h4>
          <p>Você entrega parte de seu limite em um dos seus servidores ao seu Subrevendedor não é possivel entregar mais limites que não estiver sobrando.</p>
        </div>

              <p class="m-t-10 m-b-20 f-16">Escolha um servidor abaixo</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Adicionar Servidor aos Subrevendedores</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/subrevenda/addservidor_exe.php" method="POST" role="form">
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
                                 <option selected="selected">--</option>
                  <?php



	                $SQLAcesso= "select * from acesso_servidor where id_usuario='".$usuario['id_usuario']."'  ";
                    $SQLAcesso = $conn->prepare($SQLAcesso);
                    $SQLAcesso->execute();


if (($SQLAcesso->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcesso->fetch()) {
		$contas_ssh_criadas = 0;

       $SQLServidor = "select * from servidor WHERE id_servidor = '".$row_srv['id_servidor']."' ";
       $SQLServidor = $conn->prepare($SQLServidor);
       $SQLServidor->execute();
       $servidor = $SQLServidor->fetch();


		//Carrega contas SSH criadas
$SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."' and id_usuario='".$usuario['id_usuario']."' ";
$SQLContasSSH = $conn->prepare($SQLContasSSH);
$SQLContasSSH->execute();
$SQLContasSSH = $SQLContasSSH->fetch();
$contas_ssh_criadas += $SQLContasSSH['quantidade'];

	    //Carrega usuario sub
		$SQLUsuarioSub = "SELECT * FROM usuario WHERE id_mestre ='".$usuario['id_usuario']."' and subrevenda='nao'";
        $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
        $SQLUsuarioSub->execute();


		if (($SQLUsuarioSub->rowCount()) > 0) {
				while($row = $SQLUsuarioSub->fetch()) {
				$SQLSubSSH= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and id_servidor='".$row_srv['id_servidor']."' ";
                $SQLSubSSH = $conn->prepare($SQLSubSSH);
                $SQLSubSSH->execute();
				$SQLSubSSH = $SQLSubSSH->fetch();
			    $contas_ssh_criadas += $SQLSubSSH['quantidade'];

			}

		}







		?>

	<option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> - Limite: <?php echo $contas_ssh_criadas;?>/<?php echo $row_srv['qtd'];?> </option>

   <?php }
}else{ ?>
<option value="nada">Nenhum Servidor</option>
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
                              <label class="control-label">SubRevendedor</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                                <select class="form-control select2" style="width: 100%;"  name="subusuario" id="subusuario">
                                <option selected="selected">--</option>

                  <?php



	   $SQL = "SELECT * FROM usuario where id_mestre='".$usuario['id_usuario']."' and subrevenda='sim'";
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
}else{ ?><option value="nada">Nenhum Subrevendedor</option>
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


<input  type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../admin/home.php?page=ssh/adicionar">
<input  type="hidden" class="form-control" id="owner" name="owner"  value="<?php echo $accessKEY;?>">

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