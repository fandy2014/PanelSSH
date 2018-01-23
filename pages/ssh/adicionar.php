<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script src="plugins/validator/validator.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/show-password/bootstrap-show-password.min.js"></script>
<script>
			$(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
<section class="content-header">
      <h1>
        Adicionar SSH
        <small>Criar conta SSH</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
         <li class="active">Contas SSH</li>
        <li class="active">Adicionar</li>
      </ol>
       </section>
<section class="content">
      <div class="row">

          <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os dados de cliente</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Adicionar Contas SSH & OpenVPN</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form data-toggle="validator" action="pages/system/conta.ssh.php" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Servidor</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-server"></i>
                              </div>
                                  <select class="form-control select2" style="width: 100%;"  name="acesso_servidor" id="acesso_servidor">
                               <option selected="selected">--</option>
                  <?php



	                $SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$usuario['id_usuario']."' ";
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


		$SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."' and id_usuario='".$_SESSION['usuarioID']."' ";
        $SQLContasSSH = $conn->prepare($SQLContasSSH);
        $SQLContasSSH->execute();
		$SQLContasSSH = $SQLContasSSH->fetch();
        $contas_ssh_criadas += $SQLContasSSH['quantidade'];

		    $SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' ";
            $SQLSub = $conn->prepare($SQLSub);
            $SQLSub->execute();


			if (($SQLSub->rowCount()) > 0) {
				  while($row = $SQLSub->fetch()) {
					   $SQLSubSSH= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and id_servidor='".$servidor['id_servidor']."' ";
                       $SQLSubSSH = $conn->prepare($SQLSubSSH);
                       $SQLSubSSH->execute();
					   $SQLSubSSH = $SQLSubSSH->fetch();
					   $contas_ssh_criadas += $SQLSubSSH['quantidade'];
				  }

			}



		?>

	<option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> -  <?php echo $contas_ssh_criadas;?> de <?php echo $row_srv['qtd'];?>  Conexões </option>

   <?php }
}

?>


                </select>

                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Usuário Gerenciador da Conta SSH</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                                 <select class="form-control select2" style="width: 100%;"  name="usuario" id="usuario">
                  <option selected="selected" value="<?php echo $_SESSION['usuarioID']; ?>">Usuário Atual do Sistema</option>

                  <?php



	   $SQL = "SELECT * FROM usuario where id_mestre = '".$_SESSION['usuarioID']."'";
       $SQL = $conn->prepare($SQL);
       $SQL->execute();



if (($SQL->rowCount()) > 0) {
    // output data of each row
    while($row = $SQL->fetch()) {?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?></option>

   <?php }
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
                              <label class="control-label">Quantidade de Acesso</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-ticket"></i>
                              </div>
                              <input type="number" name="acessos" id="acessos" placeholder="1" class="form-control" required>

                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Login SSH</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                               <input type="text" name="login_ssh" id="login_ssh" class="form-control" data-minlength="4" data-maxlength="32" placeholder="Digite o Login..." required="">
                               <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                               <span class="help-block">Somente letras e/ou números. Mínimo 4 caracteres e no máximo 32!</span>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Senha SSH</label>
                              <div class="append-icon">
                              <div class="input-group">
                             <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                              <input type="password" min="6" max="32" class="form-control"  name="senha_ssh"
							  data-minlength="6" id="senha_ssh"  data-toggle="password" placeholder="Digite a Senha" required>
							 </div>
							 <span class="help-block">Mínimo 6 caracteres e no máximo 32! Misture letras e números!</span>
                              </div>
                            </div>
                          </div>

                           </div>

                        <p>


<input  type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../home.php?page=ssh/adicionar">
<input  type="hidden" class="form-control" id="owner" name="owner"  value="<?php echo $_SESSION['usuarioID'];?>">





                        <p></p>



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