<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../plugins/show-password/bootstrap-show-password.min.js"></script>
<script src="../plugins/validator/validator.min.js"></script>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Contas SSH
        <small>Adiciona uma conta SSH</small>
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
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os dados do cliente</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Adicionar Contas SSH & OpenVPN</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form data-toggle="validator" action="../pages/system/conta.ssh.php" method="POST" role="form">
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



	                $SQLAcesso= "select * from servidor  ";
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


		$SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."'  ";
        $SQLContasSSH = $conn->prepare($SQLContasSSH);
        $SQLContasSSH->execute();
		$SQLContasSSH = $SQLContasSSH->fetch();
        $contas_ssh_criadas += $SQLContasSSH['quantidade'];








		?>

	<option value="<?php echo $row_srv['id_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> -  <?php echo $contas_ssh_criadas;?>  Conexões </option>

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
                              <label class="control-label">Usuário Gerenciador</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                                <select class="form-control select2" style="width: 100%;"  name="usuario" id="usuario">


                  <?php



	   $SQL = "SELECT * FROM usuario where id_mestre=0";
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
                                <input type="text" name="login_ssh" id="login_ssh" class="form-control" minlength="5" maxlength="20" placeholder="Digite o Login..." required="">
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