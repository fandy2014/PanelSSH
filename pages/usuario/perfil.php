<style>
.modal .modal-header {
  border-bottom: none;
  position: relative;
}
.modal .modal-header .btn {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: 0;
  border-top-left-radius: 0;
  border-bottom-right-radius: 0;
}
.modal .modal-footer {
  border-top: none;
  padding: 0;
}
.modal .modal-footer .btn-group > .btn:first-child {
  border-bottom-left-radius: 0;
}
.modal .modal-footer .btn-group > .btn:last-child {
  border-top-right-radius: 0;
}
</style>
<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}



   if(isset($_GET["id_usuario"])){

       $id_usuario = $_GET["id_usuario"];
	   $owner= $_SESSION['usuarioID'];


	   $SQLUsuario= "SELECT * FROM usuario where id_usuario='".$id_usuario."' and id_mestre =  '".$_SESSION['usuarioID']."' ";
       $SQLUsuario = $conn->prepare($SQLUsuario);
       $SQLUsuario->execute();

	    $SQLUsuarioSSH= "SELECT * FROM usuario_ssh where id_usuario='".$id_usuario."'   ";
       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
       $SQLUsuarioSSH->execute();

	   $total_ssh = $SQLUsuarioSSH->rowCount();

	    $total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$id_usuario."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];



	   if(($SQLUsuario->rowCount()) <= 0){
				echo '<script type="text/javascript">';
			echo 	'alert("O usuario nao existe!");';
			echo	'window.location="home.php?page=usuario/listar";';
			echo '</script>';
			exit;
		}else{
				$usuarioGET = $SQLUsuario->fetch();
		}





   }else{

	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=usuario/listar";';
		echo '</script>';
   }






	 $diretorio = " ";

?>



    <!-- Main content -->
    <section class="content">
      <!-- Alerta de usuario suspenso -->
      <div class="row">
	   <?php if($usuarioGET['ativo'] == 2 ){?>
	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <center><h4><i class="icon fa fa-ban"></i>  Esta conta se encontra suspensa desde <?php echo $usuarioGET['suspenso']; ?> </h4></center>

        </div>
	   <?php }?>


        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/avatar5.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $usuarioGET['nome'];?></h3>
             <?php if($usuarioGET['tipo']== "vpn"){ ?>
			 <p class="text-muted text-center">Usuário SSH</p>

				<?php }elseif($usuarioGET['tipo']== "revenda"){
				if($usuarioGET['subrevenda']=='sim'){
				?>
				<p class="text-muted text-center">Sub-Revendedor</p>


				<?php } else{
				?>
				<p class="text-muted text-center">Revendedor</p>
				<?php
				}

				 } ?>


              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                <b>Contas SSH</b> <a class="pull-right"><?php echo $total_ssh;?></a><br>
                </li>
                <li class="list-group-item">
                <b>Acessos SSH</b> <a class="pull-right"><?php echo $total_acesso_ssh;?></a>
                </li>
                <?php if($usuarioGET['subrevenda']=='sim'){
               $SQLUsuario2= "SELECT * FROM usuario where id_mestre='".$id_usuario."'";
               $SQLUsuario2 = $conn->prepare($SQLUsuario2);
               $SQLUsuario2->execute();
               $total_acesso_usuarios=$SQLUsuario2->rowCount();


                ?>
                <li class="list-group-item">
                <b>Usuários Criados</b> <a class="pull-right"><?php echo $total_acesso_usuarios;?></a>
                </li>
                <?php } ?>
              </ul>
              <!-- <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=senha" class="btn btn-primary btn-primary"><b>REENVIAR SENHA</b></a></center> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ações</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<script type="text/javascript">
function excluir_usuario(){
decisao = confirm("Tem certeza que vai excluir?!");
if (decisao){
   window.location.href='pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=deletar'
} else {

}


}
function suspende_usuario(){
decisao = confirm("Tem certeza que vai suspender?!");
if (decisao){
   window.location.href='pages/system/funcoes.usuario.php?&id_usuario=<?php echo $id_usuario;?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=suspender'
} else {

}


}
</script>

<center><a onclick="excluir_usuario()"  class="btn btn-primary btn-danger"><b>DELETAR TUDO</b></a></center>
 <br>
             <?php if($usuarioGET['ativo']== 1){?>
			    <center><a onclick="suspende_usuario()" class="btn btn-primary btn-warning"><b>SUSPENDER TUDO</b></a></center><br>
			 <?php }else{?>
			    <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=ususpender" class="btn btn-primary btn-success"><b>REATIVAR TUDO</b></a></center><br>

			 <?php }?>
                 <?php
                 /*
                 $SQLHist= "SELECT * FROM historico_login where id_usuario='".$id_usuario."' LIMIT 4 ";
                 $SQLHist = $conn->prepare($SQLHist);
                 $SQLHist->execute();




if (($SQLHist->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLHist->fetch()) {

		?>



	    <strong><i class="fa fa-map-marker margin-r-5"></i> <?php echo $row['ip_login'];?></strong>

              <p class="text-muted"> <?php echo $row['data_login'];?></p>

              <hr>

   <?php }
}

*/
?>








            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Informações do Usuário</a></li>

           <?php if($usuarioGET['subrevenda']=='sim'){  ?>
           <li><a href="#ssh" data-toggle="tab">Servidores Alocados</a></li>
           <?php }else{ ?>
		   <li><a href="#ssh" data-toggle="tab">Contas SSH</a></li>
           <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                 <form class="form-horizontal"  role="perfil" name="perfil" id="perfil" action="pages/usuario/editarusuario.php" method="post" >


				 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
                         <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                                <input type="text" name="login" id="login" class="form-control" minlength="4" value="<?php echo $usuarioGET['login'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
					    <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $usuarioGET['id_usuario'];?>">
					    <input type="hidden" class="form-control" id="diretorio" name="diretorio" value="../../home.php?page=usuario/perfil&id_usuario=<?php echo $usuarioGET['id_usuario'];?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Senha</label>

                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                                <input type="password" name="senha" id="senha" class="form-control" minlength="4" value="<?php echo $usuarioGET['senha'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                     <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                              </div>
                                <input type="text" name="email" id="email" class="form-control" minlength="4" value="<?php echo $usuarioGET['email'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Celular</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                              </div>
                                <input type="text" name="celular" id="celular" class="form-control" minlength="4" value="<?php echo $usuarioGET['celular'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>

				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Data de cadastro</label>

                    <div class="col-sm-10">
                         <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                                   <input type="text" class="form-control" disabled value="<?php echo $usuarioGET['data_cadastro'];?>">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Alterar Dados</button>
                    </div>
                  </div>
                </form>

              </div>

			  <div class=" tab-pane" id="ssh">
			  	<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <?php if($usuarioGET['subrevenda']=='sim'){ ?>
              <h3 class="box-title">Servidores Alocados</h3>
              <?php }else{ ?>
              <h3 class="box-title">Contas SSH</h3>
              <?php }?>
            </div>
            <!-- /.box-header -->
            <?php if($usuarioGET['subrevenda']=='sim'){ ?>
              <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Servidor</th>
                  <th>Limite Acessos</th>
                  <th>Validade</th>
                  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th></th>

                </tr>
				 <?php


    $SQLAcessoServidor = "select * from acesso_servidor where id_usuario='".$usuarioGET['id_usuario']."'  ";
    $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
    $SQLAcessoServidor->execute();


if (($SQLAcessoServidor->rowCount()) > 0) {


    while($row2 = $SQLAcessoServidor->fetch()   ){

		   $SQLTotalUser = "select * from usuario WHERE id_usuario = '".$_GET['id_usuario']."' ";
           $SQLTotalUser = $conn->prepare($SQLTotalUser);
           $SQLTotalUser->execute();
	       $total_user = $SQLTotalUser->rowCount();



		 $SQLServidor = "select * from servidor where id_servidor = '".$row2['id_servidor']."'";
         $SQLServidor = $conn->prepare($SQLServidor);
         $SQLServidor->execute();



		 $contas=0;
		 $acessos=0;


		 $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row2['id_servidor']."'
		                                               and id_usuario='".$_GET['id_usuario']."'  ";
         $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
         $SQLUsuarioSSH->execute();
		 $contas += $SQLUsuarioSSH->rowCount();

		 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row2['id_servidor']."'  and id_usuario='".$_GET['id_usuario']."' ";
         $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
         $SQLAcessoSSH->execute();
	     $SQLAcessoSSH = $SQLAcessoSSH->fetch();
         $acessos += $SQLAcessoSSH['quantidade'];



		    $SQLUsuarioSub = "select * from usuario WHERE id_mestre = '".$_GET['id_usuario']."'  ";
            $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
            $SQLUsuarioSub->execute();

			 if (($SQLUsuarioSub->rowCount()) > 0) {
			  while($row3 = $SQLUsuarioSub->fetch()   ){

				  $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row2['id_servidor']."'
		                                               and id_usuario='".$row3['id_usuario']."'  ";
                  $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                  $SQLUsuarioSSH->execute();
		          $contas += $SQLUsuarioSSH->rowCount();

				   $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row2['id_servidor']."'  and id_usuario='".$row3['id_usuario']."' ";
                   $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                   $SQLAcessoSSH->execute();
	               $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                   $acessos += $SQLAcessoSSH['quantidade'];



			    }
			 }





		 if (($SQLServidor->rowCount()) > 0) {
			  while($row3 = $SQLServidor->fetch()   ){

				$qtd_srv =0;

			//Calcula os dias restante
	    $data_atual = date("Y-m-d");
		$data_validade = $row2['validade'];
		if($data_validade > $data_atual){
		   $data1 = new DateTime( $data_validade );
           $data2 = new DateTime( $data_atual );
           $dias_acesso = 0;
           $diferenca = $data1->diff( $data2 );
           $ano = $diferenca->y * 364 ;
	       $mes = $diferenca->m * 30;
		   $dia = $diferenca->d;
           $dias_acesso = $ano + $mes + $dia;

		}else{
			 $dias_acesso = 0;
		}

		 ?>

		 <div id="myModal<?php echo $row2['id_acesso_servidor'];?>" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
               <form name="deletarserver" action="pages/subrevenda/deletarservidor_exe.php" method="post">
                <input name="servidor" type="hidden" value="<?php echo $row2['id_acesso_servidor'];?>">
                <input name="cliente" type="hidden" value="<?php echo $usuarioGET['id_usuario'];?>">
                <div class="modal-header">
                    <a class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
                    <h4 class="modal-title">Apagar Tudo de <?php echo $usuarioGET['nome'];?></h4>
                </div>
                <div class="modal-body">
                    <h4>Tem certeza?</h4>
                    <p>Todos os clientes deles irão ter a conta SSH Deletada.</p>
                    <p>Você recebe os Acessos de Volta.</p>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                        <button name="deletandoserver" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Confirmar</button>
                        </form>
                    </div>
                </div>


	          <tr>
                  <td><?php echo $row3['nome'];?></td>
                  <td><?php echo $row2['qtd'];?></td>
                    <td>
				   <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>



				   </td>
                  <td><?php echo $contas;?></td>
				   <td><?php echo $acessos;?></td>
				  <td>
				    <center>
					<!-- <a href="#" class="btn btn-warning">Editar Acesso</a> -->
					 <a data-toggle="modal" href="#myModal<?php echo $row2['id_acesso_servidor'];?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>

					</center>
				  </td>

                </tr>


	<?php
			  }
		 }
	}
}
?>




              </table>
            </div>

            <?php }else{ ?>

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Login</th>
                  <th>Servidor</th>
                  <th>Validade</th>
				  <th></th>

                </tr>

                		 <?php

	$SQLUsuario= "SELECT * FROM usuario_ssh where id_usuario =  '".$usuarioGET['id_usuario']."' and status <= '2' ";
    $SQLUsuario = $conn->prepare($SQLUsuario);
    $SQLUsuario->execute();




if (($SQLUsuario->rowCount()) > 0) {

    // output data of each row
    while($row_user = $SQLUsuario->fetch()   ){

		$SQLServidor= "SELECT * FROM servidor where id_servidor =  '".$row_user['id_servidor']."' ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
		$servidor = $SQLServidor->fetch();
		$color = "";


				    if($row_user['status']== 2){

						$color = "bgcolor='#FF6347'";
					}




		 ?>


	          <tr <?php echo $color; ?>  >
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
                  <td><?php echo date('d/m/Y', strtotime($row_user['data_validade']));?></td>
				  <td>

                    <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row_user['id_usuario_ssh'];?>" class="btn btn-primary">Detalhes</a></center>

				 </td>

                </tr>


	<?php


	}
}





?>





              </table>
            </div>
            <?php } ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>



              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
