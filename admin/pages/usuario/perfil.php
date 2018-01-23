<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}



   if(isset($_GET["id_usuario"])){
	   $id_usuario=$_GET['id_usuario'];
	   $diretorio = "../../admin/home.php?page=usuario/perfil&id_usuario=".$id_usuario;
	   $SQLUsuario = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
       $SQLUsuario = $conn->prepare($SQLUsuario);
       $SQLUsuario->execute();
	   $usuario = $SQLUsuario->fetch();
       if(($SQLUsuario->rowCount()) <= 0){
				echo '<script type="text/javascript">';
			echo 	'alert("O usuario nao existe!");';
			echo	'window.location="home.php?page=usuario/listar";';
			echo '</script>';
			exit;
			}

		// avatares
        switch($usuario['avatar']){
        case 1:$avatarusu="avatar1.png";break;
        case 2:$avatarusu="avatar2.png";break;
        case 3:$avatarusu="avatar3.png";break;
        case 4:$avatarusu="avatar4.png";break;
        case 5:$avatarusu="avatar5.png";break;
        default:$avatarusu="boxed-bg.png";break;
        }

	   $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario = '".$id_usuario."' ";
       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
       $SQLUsuarioSSH->execute();
	   $total_ssh = $SQLUsuarioSSH->rowCount();



$SQLSubrevendedores= "select * from usuario WHERE id_mestre = '".$id_usuario."' and tipo='revenda' and subrevenda='sim' ";
$SQLSubrevendedores = $conn->prepare($SQLSubrevendedores);
$SQLSubrevendedores->execute();
$todossubrevendedores=$SQLSubrevendedores->rowCount();

if (($SQLSubrevendedores->rowCount()) > 0) {

                while($subrow = $SQLSubrevendedores->fetch()) {
                    $quantidade_ssh_subs=0;
					$SQLSubSSHsubs= "select * from usuario_ssh WHERE id_usuario = '".$subrow['id_usuario']."'  ";
                    $SQLSubSSHsubs = $conn->prepare($SQLSubSSHsubs);
                    $SQLSubSSHsubs->execute();


                    $sshsubs=$SQLSubSSHsubs->rowCount();


                    $SQLSubUSUARIOSsubs= "select * from usuario WHERE id_mestre = '".$subrow['id_usuario']."' ";
                    $SQLSubUSUARIOSsubs = $conn->prepare($SQLSubUSUARIOSsubs);
                    $SQLSubUSUARIOSsubs->execute();
                    $quantidade_USUARIOS_subs += $SQLSubUSUARIOSsubs->rowCount();
                    $sshsubs132=$SQLSubUSUARIOSsubs->rowCount();










		        }


		    }






	   $total_ssh_sub = 0;

	   if($usuario['tipo']=="revenda"){


		   $SQLUsuarioSUB = "select * from usuario WHERE id_mestre = '".$_GET['id_usuario']."' and subrevenda='nao' ";
           $SQLUsuarioSUB = $conn->prepare($SQLUsuarioSUB);
           $SQLUsuarioSUB->execute();
	       $total_user = $SQLUsuarioSUB->rowCount();

		   if(($SQLUsuarioSUB->rowCount()) > 0){
			    while($row_sub = $SQLUsuarioSUB->fetch()) {

					$SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario = '".$row_sub['id_usuario']."' ";
                    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                    $SQLUsuarioSSH->execute();
	                $total_ssh_sub += $SQLUsuarioSSH->rowCount();


				}
				$total = $total_ssh +$total_ssh_sub;

		   }

	   }






	   if($usuario['id_mestre']!=0 ){

		$SQLUsuario = "select * from usuario WHERE id_usuario = '".$usuario['id_mestre']."'  ";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
	    $usuario_mestre = $SQLUsuario->fetch();

	   }

   }else{

	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=usuario/listar";';
		echo '</script>';
   }


?>



    <!-- Main content -->
    <section class="content">

      <div class="row">
	    <?php if($usuario['ativo'] == 2 ){?>
	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <center><h4><i class="icon fa fa-ban"></i> Conta Suspensa! </h4></center>

        </div>
	   <?php }?>
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../dist/img/<?php echo $avatarusu;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $usuario['nome'];?></h3>
             <?php if($usuario['tipo']== "vpn"){ ?>
			 <p class="text-muted text-center">Usuário SSH</p>

				<?php }elseif($usuario['tipo']== "revenda"){
				if($usuario['subrevenda']=='sim'){

				?>
				<p class="text-muted text-center">Sub-Revendedor (<a href="home.php?page=usuario/perfil&id_usuario=<?php echo $usuario_mestre['id_usuario'];?>"><?php echo $usuario_mestre['nome'];?></a>)</p>


				<?php } else{				?>
				<p class="text-muted text-center">Revendedor</p>
				<?php
				}

				 } ?>


              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Contas SSH</b> <a class="pull-right"><?php echo $total_ssh;?></a>
                </li>
				<?php if($usuario['tipo']=="revenda"){?>
                <li class="list-group-item">
                  <b>Usuários SSH</b> <a class="pull-right"><?php echo $total_user;?></a>
                </li>
                <li class="list-group-item">
                  <b>Contas dos Usuários SSH</b> <a class="pull-right"><?php echo $total_ssh_sub;?></a>
                </li>
                <?php if($usuario['subrevenda']=='sim'){                	$totalserversadd = "select * from acesso_servidor WHERE id_usuario = '".$usuario['id_usuario']."' ";
                    $totalserversadd = $conn->prepare($totalserversadd);
                    $totalserversadd->execute();
	                $total_servers_add = $totalserversadd->rowCount();

                ?>
                <li class="list-group-item">
                  <b>Servidores Adicionados</b> <a class="pull-right"><?php echo $total_servers_add;?></a>
                </li>
                <?php } ?>
                <?php if($usuario['subrevenda']=='nao'){?>
                <li class="list-group-item">
                <b>SubRevendedores</b> <a class="pull-right"><?php echo $todossubrevendedores;?></a>
                </li>
                <li class="list-group-item">
                <b>Usuários dos Sub</b> <a class="pull-right"><?php echo $quantidade_USUARIOS_subs;?></a>
                </li>
                <?php } ?>
				<?php  } ?>


              </ul>
<script type="text/javascript">
function excluir_usuario(){
decisao = confirm("Tem certeza que vai excluir?!");
if (decisao){
   window.location.href='../pages/system/funcoes.usuario.php?&op=deletar&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/revenda&owner=<?php echo $accessKEY;?>'
} else {

}


}
function suspende_usuario(){
decisao = confirm("Tem certeza que vai suspender?!");
if (decisao){
   window.location.href='../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=suspender'
} else {

}


}

</script>



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

                   <center><a onclick="excluir_usuario()" class="btn btn-danger">Deletar TUDO</a></center>
 <br>
              <?php if($usuario['ativo']== 1){?>
			    <center><a onclick="suspende_usuario()" class="btn btn-primary btn-warning"><b>SUSPENDER TUDO</b></a></center><br>
			 <?php }else{?>
			    <center><a href="../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=ususpender" class="btn btn-primary btn-success"><b>REATIVAR TUDO</b></a></center><br>

			 <?php }?>
              <center><a href="../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=senha" class="btn btn-primary btn-primary"><b>REENVIAR SENHA</b></a></center>





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
			  <?php if($usuario['tipo']=="revenda"){?>
			  <?php if($usuario['subrevenda']=="nao"){?>
              <li><a href="#timeline" data-toggle="tab">Servidores</a></li>
              <?php } ?>
              <li><a href="#users" data-toggle="tab">Usuários</a></li>
			  <?php } ?>
			  <li><a href="#ssh" data-toggle="tab">Contas SSH</a></li>
			  <?php if($usuario['subrevenda']=="nao"){?>
			  <li><a href="#fatura" data-toggle="tab">Gerar Fatura</a></li>
			  <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                 <form class="form-horizontal"  role="perfil" name="perfil" id="perfil" action="pages/usuario/editar_exe.php" method="post" >
				 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Login</label>



                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                      <input type="text" class="form-control" disabled value="<?php echo $usuario['login'];?>">
					  <input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?php echo $usuario['id_usuario'];?>">
                       </div>
                    </div>
                  </div>

                   <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Senha</label>



                    <div class="col-sm-10">
                    <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
					  <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $usuario['senha'];?>">
                       </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome</label>

                    <div class="col-sm-10">
                    <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-hashtag"></i>
                              </div>
                      <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuario['nome'];?>">
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
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email'];?>">
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
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $usuario['celular'];?>">
                     </div>
                    </div>
                  </div>

				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Data de cadastro</label>

                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                              </div>
                        <input type="text" class="form-control" disabled value="<?php echo $usuario['data_cadastro'];?>">
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
              <!-- /.tab-pane -->
			  <?php if($usuario['tipo']=="revenda"){?>
			  <?php if($usuario['subrevenda']=='nao'){ ?>
              <div class=" tab-pane" id="timeline">




            <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Servidores com acesso</h3>


            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Servidor</th>
                  <th>Limite Atual</th>
                  <th>Validade</th>
                  <th>SubServidores</th>
                  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th></th>

                </tr>
				 <?php


    $SQLAcessoServidor = "select * from acesso_servidor where id_usuario='".$_GET['id_usuario']."'  ";
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

            $SQLsubservidores = "select * from acesso_servidor WHERE id_servidor_mestre = '".$row2['id_acesso_servidor']."'";
            $SQLsubservidores = $conn->prepare($SQLsubservidores);
            $SQLsubservidores->execute();
            $total_subservers = $SQLsubservidores->rowCount();

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



		    $SQLUsuarioSub = "select * from usuario WHERE id_mestre = '".$_GET['id_usuario']."' and subrevenda='nao' ";
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
				  <td><?php echo $total_subservers;?></td>
                  <td><?php echo $contas;?></td>
				  <td><?php echo $acessos;?></td>
				  <td>
				    <center>
				    <script>
				    function apaga_tudo<?php echo $row2['id_acesso_servidor'];?>(){
decisao = confirm("Tem certeza que vai apagar o servidor dele?!\n Vai apagar o servidor dos subrevendedores dele.");
if (decisao){
   window.location.href='pages/usuario/remover_servidor.php?&id_acesso=<?php echo $row2['id_acesso_servidor'];?>'
} else {

}


}
				    </script>
					<!-- <a href="#" class="btn btn-warning">Editar Acesso</a> -->
					<a onclick="apaga_tudo<?php echo $row2['id_acesso_servidor'];?>()" class="btn btn-danger"><i class="fa fa-trash"></i></a>

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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>



			  </div>
              <!-- /.tab-pane -->
              <?php } ?>
              <div class="tab-pane" id="users">


				<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Usuários de sistema</h3>


            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Login</th>
                  <th>Nome</th>
                  <th>Contas</th>


                </tr>
				 <?php

    $SQLUsuarioSUB = "select * from usuario where id_mestre='".$usuario['id_usuario']."'  ";
    $SQLUsuarioSUB = $conn->prepare($SQLUsuarioSUB);
    $SQLUsuarioSUB->execute();


if (($SQLUsuarioSUB->rowCount()) > 0) {
    // output data of each row
    while($row_user = $SQLUsuarioSUB->fetch()   ){

		$total_ssh = 0;

	    $SQLUsuarioSSH = "select * from usuario_ssh where id_usuario = '".$row_user['id_usuario']."' ";
        $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
        $SQLUsuarioSSH->execute();
	    $total_ssh += $SQLUsuarioSSH->rowCount();
        $color = "";


				    if($row_user['ativo']== 2){

						$color = "bgcolor='#FF6347'";
					}

		 ?>


	          <tr <?php echo $color; ?>>
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $row_user['nome'];?></td>
                  <td><?php echo $total_ssh;?></td>


                </tr>


	<?php

	}
}
?>




              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>


			 </div>
              <?php }?>
			  <!-- /.tab-pane -->
			  <div class=" tab-pane" id="ssh">
			  	<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Contas SSH</h3>


            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Login</th>
                  <th>Servidor</th>
				  <th>Acessos</th>
                  <th>Owner</th>


                </tr>
				 <?php



	$SQLUsuarioSSH = "select * from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
    $SQLUsuarioSSH->execute();


if (($SQLUsuarioSSH->rowCount()) > 0) {

    // output data of each row
    while($row_user = $SQLUsuarioSSH->fetch()   ){

		$SQLServidor = "select * from servidor where id_servidor='".$row_user['id_servidor']."'  ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
	    $servidor = $SQLServidor->fetch();
       $color = "";

	    $acessos = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario_ssh='".$row_user['id_usuario_ssh']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $acessos += $SQLAcessoSSH['quantidade'];


				    if($row_user['status']== 2){

						$color = "bgcolor='#FF6347'";
					}



		 ?>


	          <tr <?php echo $color; ?>>
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
				  <td><?php echo $acessos;?></td>
                  <td>Owner</td>


                </tr>


	<?php


	}
}



if($usuario['tipo'] == "revenda"){

			$SQLUserSub = "select * from usuario where id_mestre = '".$usuario['id_usuario']."'  ";
            $SQLUserSub = $conn->prepare($SQLUserSub);
            $SQLUserSub->execute();




			if (($SQLUserSub->rowCount()) > 0) {

				while($row_user_sub = $SQLUserSub->fetch()   ){


					$SQLSubSSH = "select * from usuario_ssh where id_usuario='".$row_user_sub['id_usuario']."'  ";
                    $SQLSubSSH = $conn->prepare($SQLSubSSH);
                    $SQLSubSSH->execute();

					if (($SQLSubSSH->rowCount()) > 0) {
						while($row_ssh_sub = $SQLSubSSH->fetch()   ){

		                $SQLServidor = "select * from servidor where id_servidor='".$row_ssh_sub['id_servidor']."'  ";
                        $SQLServidor = $conn->prepare($SQLServidor);
                        $SQLServidor->execute();
	             	    $servidor = $SQLServidor->fetch();
                         $color = "";
		                  $acessos  = 0;

				    if($row_ssh_sub['status']== 2){

						$color = "bgcolor='#FF6347'";
					}

					 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario_ssh='".$row_ssh_sub['id_usuario_ssh']."'  ";
                     $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                     $SQLAcessoSSH->execute();
		             $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                     $acessos += $SQLAcessoSSH['quantidade'];


						?>

							<tr <?php echo $color; ?>>
                  <td><?php echo $row_ssh_sub['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
				  <td><?php echo $acessos;?></td>
                  <td><?php echo $row_user_sub['login'];?></td>


                </tr>

					<?php	}

					}
				}

			}

		}


?>




              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>



              </div>
              <!-- /.tab-pane -->
                <!-- /.tab-fatura -->
               <div class="tab-pane" id="fatura">
			  	<div class="row">
        <div class="col-xs-12">
          <form class="form-horizontal"  role="perfil" name="gerandofatura" id="gerandofatura" action="pages/usuario/gerarfatura_exe.php" method="post" >
				 <div class="form-group">
				  <input  type="hidden" class="form-control" id="usuarioid" name="usuarioid" value="<?php echo $_GET['id_usuario'];?>">
                    <label for="inputName" class="col-sm-2 control-label">Tipo da Fatura</label>

                    <div class="col-sm-10">

                    <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-cogs"></i>
                              </div>
                                     <select class="form-control" name="tipofat">
                     <?php if($usuario['tipo']=='vpn'){?><option value='1'> Acesso VPN</option><?php } ?>
                    <option value='2'>Outros</option>
                    <?php if($usuario['tipo']=='revenda'){?><option value='1' selected=selected>Revenda</option><?php } ?>
                  </select>
                              </div>

                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Quantidade</label>

                    <div class="col-sm-10">
                    <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-plus"></i>
                              </div>
                                   <input type="number" class="form-control" id="qtd" name="qtd" value="1" required>

                              </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Valor</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-money"></i>
                              </div>
                      <input type="number" class="form-control" id="valor" name="valor" value="5" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Desconto</label>

                    <div class="col-sm-10">
                     <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-smile-o"></i>
                              </div>
                        <input type="number" class="form-control" id="desconto" name="desconto" value="0" required>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">

                    <label for="inputName" class="col-sm-2 control-label">Vencimento</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                              </div>
                        <input type="number" class="form-control" id="venc" name="venc" value="5" required>
                     </div>
                   </div>
                  </div>


				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Descrição</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" name="msg" id="msg" rows="3" placeholder="Digite ..." required></textarea>
                    </div>
                  </div>
				  <?php if($usuario['tipo']=="revenda"){?>
				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Servidor</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-server"></i>
                              </div>
                     <select class="form-control" name="servidorid">
                    <option selected=selected>Servidores</option>
                    <?php


    $SQLServidor2 = "select * from servidor";
    $SQLServidor2 = $conn->prepare($SQLServidor2);
    $SQLServidor2->execute();

if (($SQLServidor2->rowCount()) > 0) {
    // output data of each row
    while($row22 = $SQLServidor2->fetch()   ) {

		$SQLAcessoServidor = "select * from acesso_servidor where id_servidor='".$row22['id_servidor']."'  and  id_usuario = '".$_GET['id_usuario']."'";
        $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
        $SQLAcessoServidor->execute();
        $acc=$SQLAcessoServidor->fetch();

		if(($SQLAcessoServidor->rowCount()) > 0 ){
		?>

	<option value="<?php echo $row22['id_servidor'];?>" > <?php echo $row22['ip_servidor'];?> - Acessos: <?php echo $acc['qtd'];?> - VAL: <?php echo $acc['validade'];?>  </option>

		<?php
		}else{ ?>        <option value="<?php echo $row22['id_servidor'];?>" > <?php echo $row22['nome'];?> - <?php echo $row22['ip_servidor'];?> - Não tem acesso </option>
		<?php }
   }
}


?>
                  </select>
                    </div>
                    </div>
                  </div>
				  <?php }elseif($usuario['tipo']=="vpn"){?>
				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Contas SSH</label>

                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                     <select class="form-control" name="account">
                    <option value="outros" selected=selected>Gerar em Outros</option>
                    <?php


    $SQLServidor2 = "select * from usuario_ssh where id_usuario='".$_GET['id_usuario']."'";
    $SQLServidor2 = $conn->prepare($SQLServidor2);
    $SQLServidor2->execute();

if (($SQLServidor2->rowCount()) > 0) {
    // output data of each row
    while($row22 = $SQLServidor2->fetch()   ) {
        $data=$row22['data_validade'];

                     $datacriado=$data;
					 $dataconvcriado = substr($datacriado, 0, 10);
					 $partes = explode("-", $dataconvcriado);
                     $ano = $partes[0];
                     $mes = $partes[1];
                     $dia = $partes[2];

        /*
		$SQLAcessoServidor = "select * from acesso_servidor where id_servidor='".$row22['id_servidor']."'  and  id_usuario = '".$_GET['id_usuario']."'";
        $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
        $SQLAcessoServidor->execute();
        $acc=$SQLAcessoServidor->fetch();

		if(($SQLAcessoServidor->rowCount()) > 0 ){   */
		?>

	<option value="<?php echo $row22['id_usuario_ssh'];?>" > <?php echo $row22['login'];?> - Acessos: <?php echo $row22['acesso'];?> - VAL: <?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?>  </option>

		<?php /*
		}else{ ?>
        <option value="<?php echo $row22['id_servidor'];?>" > <?php echo $row22['nome'];?> - <?php echo $row22['ip_servidor'];?> - Não tem acesso </option>
		<?php }   */
   }
}


?>
                  </select>
                   </div>
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Servidor</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-server"></i>
                              </div>
                     <select class="form-control" name="servidorid">
                    <option value="outros" selected=selected>Outros (Tipo em outros Tbm)</option>
                    <?php


    $SQLServidor2 = "select * from servidor";
    $SQLServidor2 = $conn->prepare($SQLServidor2);
    $SQLServidor2->execute();

if (($SQLServidor2->rowCount()) > 0) {
    // output data of each row
    while($row22 = $SQLServidor2->fetch()   ) {



		$SQLcriados = "select * from usuario_ssh where id_servidor='".$row22['id_servidor']."'";
        $SQLcriados = $conn->prepare($SQLcriados);
        $SQLcriados->execute();
        $criados=$SQLcriados->rowCount();
        /*
		if(($SQLAcessoServidor->rowCount()) > 0 ){   */
		?>

	<option value="<?php echo $row22['id_servidor'];?>" > <?php echo $row22['nome'];?> -  <?php echo $row22['ip_servidor'];?>  - Contas: <?php echo $criados;?></option>

		<?php /*
		}else{ ?>
        <option value="<?php echo $row22['id_servidor'];?>" > <?php echo $row22['nome'];?> - <?php echo $row22['ip_servidor'];?> - Não tem acesso </option>
		<?php }   */
   }
}


?>
                  </select>
                     </div>
                    </div>
                  </div>
				  <?php } ?>



                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Gerar Fatura</button>
                    </div>
                  </div>
                </form>

        </div>
        </div>
        </div>


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
