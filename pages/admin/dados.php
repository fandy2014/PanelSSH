<?php

  if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

if(isset($_GET['char'])){

$novochar=$_GET['char'];

switch($novochar){case 1:$char=1;break;
case 2:$char=2;break;
case 3:$char=3;break;
case 4:$char=4;break;
case 5:$char=5;break;
default:$char=0;break;
}

if($char==0){echo '<script type="text/javascript">';
		            echo 	'alert("Ocorreu um erro na seleção do char!");';
			        echo	'window.location="../home.php?page=admin/dados"';
			        echo '</script>';
			        exit;

}

if(($char==5)and($usuario['tipo']<>'revenda')){                    echo '<script type="text/javascript">';
		            echo 	'alert("Você não é um revendedor!");';
			        echo	'window.location="../home.php?page=admin/dados"';
			        echo '</script>';
			        exit;

}

$SQLDelSSH = "update usuario set avatar='".$char."' WHERE id_usuario = '".$usuario['id_usuario']."'  ";
$SQLDelSSH = $conn->prepare($SQLDelSSH);
$SQLDelSSH->execute();

echo '<script type="text/javascript">';
echo 	'alert("Avatar atualizado com sucesso!");';
echo	'window.location="../../home.php?page=admin/dados"';
echo '</script>';



}

switch($usuario['tipo']){
case 'vpn':$tipousuario='Usuário VPN';break;
case 'revenda':$tipousuario='Revendedor';break;
default:$tipousuario='erro';break;
}
if(($usuario['tipo']=='revenda')&&($usuario['subrevenda']=='sim')){
$tipousuario='Sub Revendedor';
}

if(($usuario['tipo']=='revenda')&&($usuario['subrevenda']=='nao')){
$SQLSubrevendedores= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and tipo='revenda' and subrevenda='sim' ";
$SQLSubrevendedores = $conn->prepare($SQLSubrevendedores);
$SQLSubrevendedores->execute();
$todossubrevendedores=$SQLSubrevendedores->rowCount();

if (($SQLSubrevendedores->rowCount()) > 0) {

                while($subrow = $SQLSubrevendedores->fetch()) {
                    $quantidade_ssh_subs=0;
					$SQLSubSSHsubs= "select * from usuario_ssh WHERE id_usuario = '".$subrow['id_usuario']."'  ";
                    $SQLSubSSHsubs = $conn->prepare($SQLSubSSHsubs);
                    $SQLSubSSHsubs->execute();
                    $quantidade_ssh_subs += $SQLSubSSHsubs->rowCount();

                    $sshsubs=$SQLSubSSHsubs->rowCount();


                    $SQLSubUSUARIOSsubs= "select * from usuario WHERE id_mestre = '".$subrow['id_usuario']."'  ";
                    $SQLSubUSUARIOSsubs = $conn->prepare($SQLSubUSUARIOSsubs);
                    $SQLSubUSUARIOSsubs->execute();
                    $quantidade_USUARIOS_subs += $SQLSubUSUARIOSsubs->rowCount();
                    $sshsubs132=$SQLSubUSUARIOSsubs->rowCount();
                    if (($SQLSubUSUARIOSsubs->rowCount()) > 0) {                    while($subrow2 = $SQLSubUSUARIOSsubs->fetch()) {
                    $SQLSubSSHsubs123= "select * from usuario_ssh WHERE id_usuario = '".$subrow2['id_usuario']."'  ";
                    $SQLSubSSHsubs123 = $conn->prepare($SQLSubSSHsubs123);
                    $SQLSubSSHsubs123->execute();
                    $quantidade_ssh_subs += $SQLSubSSHsubs123->rowCount();
                    }

                    }









		        }


		    }



}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/show-password/bootstrap-show-password.min.js"></script>
<script>
		 $(document).ready(function ($) {
			 //$("[data-mask]").inputmask();
			 //Inputmask().mask(document.querySelectorAll("input"));

			 $('#celular').inputmask("(99) 9999[9]-9999");  //static mask
			});
		</script>
<section class="content-header">
      <h1>
        Configurações
        <small>Alterar meus dados de usuário</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
         <li class="active">Configurações</li>
        <li class="active">Alterar</li>
      </ol>
       </section>
  <?php if($usuario['atualiza_dados']==0){?>
    <div class="callout callout-warning">
                <center><h4>Primeiro acesso</h4>

                <p>Para continuar, preencha todos os campos e salve!</p>
				</center>
    </div>
  <?php }?>

  <style>
  #container {
    width: 100%;
    border-color: blue;
    text-align: center;
    vertical-align:middle;
}

.box {

    display: inline-block;


}

#box-1 {background: rgba(255,175,75,1);
background: -moz-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,175,75,1)), color-stop(100%, rgba(255,146,10,1)));
background: -webkit-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -o-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -ms-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: linear-gradient(to right, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffaf4b', endColorstr='#ff920a', GradientType=1 );
}
#box-2 { background: rgba(98,125,77,1);
background: -moz-linear-gradient(left, rgba(98,125,77,1) 0%, rgba(31,59,8,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(98,125,77,1)), color-stop(100%, rgba(31,59,8,1)));
background: -webkit-linear-gradient(left, rgba(98,125,77,1) 0%, rgba(31,59,8,1) 100%);
background: -o-linear-gradient(left, rgba(98,125,77,1) 0%, rgba(31,59,8,1) 100%);
background: -ms-linear-gradient(left, rgba(98,125,77,1) 0%, rgba(31,59,8,1) 100%);
background: linear-gradient(to right, rgba(98,125,77,1) 0%, rgba(31,59,8,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#627d4d', endColorstr='#1f3b08', GradientType=1 ); }
#box-3 { background: rgba(203,96,179,1);
background: -moz-linear-gradient(left, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 43%, rgba(168,0,119,1) 64%, rgba(219,54,164,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(203,96,179,1)), color-stop(43%, rgba(193,70,161,1)), color-stop(64%, rgba(168,0,119,1)), color-stop(100%, rgba(219,54,164,1)));
background: -webkit-linear-gradient(left, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 43%, rgba(168,0,119,1) 64%, rgba(219,54,164,1) 100%);
background: -o-linear-gradient(left, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 43%, rgba(168,0,119,1) 64%, rgba(219,54,164,1) 100%);
background: -ms-linear-gradient(left, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 43%, rgba(168,0,119,1) 64%, rgba(219,54,164,1) 100%);
background: linear-gradient(to right, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 43%, rgba(168,0,119,1) 64%, rgba(219,54,164,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cb60b3', endColorstr='#db36a4', GradientType=1 );  }
#box-4 {
background: rgba(252,236,252,1);
background: -moz-linear-gradient(left, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 43%, rgba(253,137,215,1) 62%, rgba(255,124,216,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(252,236,252,1)), color-stop(43%, rgba(251,166,225,1)), color-stop(62%, rgba(253,137,215,1)), color-stop(100%, rgba(255,124,216,1)));
background: -webkit-linear-gradient(left, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 43%, rgba(253,137,215,1) 62%, rgba(255,124,216,1) 100%);
background: -o-linear-gradient(left, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 43%, rgba(253,137,215,1) 62%, rgba(255,124,216,1) 100%);
background: -ms-linear-gradient(left, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 43%, rgba(253,137,215,1) 62%, rgba(255,124,216,1) 100%);
background: linear-gradient(to right, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 43%, rgba(253,137,215,1) 62%, rgba(255,124,216,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcecfc', endColorstr='#ff7cd8', GradientType=1 );
}
#box-5 {
background: rgba(183,222,237,1);
background: -moz-linear-gradient(left, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 43%, rgba(33,180,226,1) 59%, rgba(183,222,237,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(183,222,237,1)), color-stop(43%, rgba(113,206,239,1)), color-stop(59%, rgba(33,180,226,1)), color-stop(100%, rgba(183,222,237,1)));
background: -webkit-linear-gradient(left, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 43%, rgba(33,180,226,1) 59%, rgba(183,222,237,1) 100%);
background: -o-linear-gradient(left, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 43%, rgba(33,180,226,1) 59%, rgba(183,222,237,1) 100%);
background: -ms-linear-gradient(left, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 43%, rgba(33,180,226,1) 59%, rgba(183,222,237,1) 100%);
background: linear-gradient(to right, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 43%, rgba(33,180,226,1) 59%, rgba(183,222,237,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#b7deed', GradientType=1 );
}


#box-1:hover{
  box-shadow: 5px 5px 25px rgba(0,0,0,.3);
}
#box-2:hover{
  box-shadow: 5px 5px 25px rgba(0,0,0,.3);
}
#box-3:hover{
  box-shadow: 5px 5px 25px rgba(0,0,0,.3);
}
#box-4:hover{
  box-shadow: 5px 5px 25px rgba(0,0,0,.3);
}
#box-5:hover{
  box-shadow: 5px 5px 25px rgba(0,0,0,.3);
}
       </style>
<script>
function selecionachar(id){
decisao = confirm("Confirme o novo Avatar!");
if (decisao){
   window.location.href='../home.php?page=admin/dados&char='+id;
} else {

}


}
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Avatares Disponiveis:</h4>
      </div>
      <div class="modal-body" id="container">

    <div id="box-1" class="box"><img onclick="selecionachar(1);" style="cursor:pointer;" class="profile-user-img img-responsive img-circle"  src="dist/img/avatar1.png" alt="User profile picture"></div>
    <div id="box-2" class="box"><img onclick="selecionachar(2);" style="cursor:pointer;" class="profile-user-img img-responsive img-circle"  src="dist/img/avatar2.png" alt="User profile picture"></div>
    <div id="box-3" class="box"><img onclick="selecionachar(3);" style="cursor:pointer;" class="profile-user-img img-responsive img-circle"  src="dist/img/avatar3.png" alt="User profile picture"></div>
    <div id="box-4" class="box"><img onclick="selecionachar(4);" style="cursor:pointer;" class="profile-user-img img-responsive img-circle"  src="dist/img/avatar4.png" alt="User profile picture"></div>
    <div id="box-5" class="box"><span>Exclusivo Revenda</span><img onclick="selecionachar(5);" style="cursor:pointer;" class="profile-user-img img-responsive img-circle" src="dist/img/avatar5.png" alt="User profile picture"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<section class="content">
      <div class="row">
      <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/<?php echo $avatarusu;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $usuario['nome'];?></h3>

              <p class="text-muted text-center"><?php echo $tipousuario;?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Contas SSH</b> <a class="pull-right"><?php echo $quantidade_ssh;?></a>
                </li>
                 <li class="list-group-item">
                  <b>Contas SSH Susp.</b> <a class="pull-right"><?php echo $all_ssh_susp_qtd;?></a>
                </li>
                <li class="list-group-item">
                  <b>Acessos SSH </b> <a class="pull-right"><?php echo $total_acesso_ssh;?></a>
                </li>
                <?php if($usuario['tipo']=='revenda'){?>
                <li class="list-group-item">
                  <b>Usuários SSH</b> <a class="pull-right"><?php echo $quantidade_sub;?></a>
                </li>
                <li class="list-group-item">
                  <b>Contas SSH Usuários</b> <a class="pull-right"><?php echo $sshsub;?></a>
                </li>
                <?php } ?>
                <?php if(($usuario['tipo']=='revenda')and($usuario['subrevenda']=='nao')){?>
                <li class="list-group-item">
                  <b>SubRevendedores</b> <a class="pull-right"><?php echo $todossubrevendedores;?></a>
                </li>
                <li class="list-group-item">
                  <b>Usuários dos Sub</b> <a class="pull-right"><?php echo $quantidade_USUARIOS_subs;?></a>
                </li>
                <li class="list-group-item">
                  <b>Contas SSH dos Sub</b> <a class="pull-right"><?php echo $quantidade_ssh_subs;?></a>
                </li>
                <?php } ?>
              </ul>

              <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-block"><b>Alterar Avatar</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sobre Mim</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Membro do Site</strong>

              <p class="text-muted">
                Membro desde <?php echo $Meses;?> de <?php echo $ano;?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Sem informações</p>



            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
             <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Configuração</a></li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="settings">
                <form  class="form-horizontal" role="form" id="form" name="form" action="pages/admin/alterar.php" method="post">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                                <input disabled type="text" class="form-control" minlength="4" value="<?php echo $usuario['login'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Data de Cadastro</label>

                    <div class="col-sm-10">
                    <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                              </div>
                                <input disabled type="text" class="form-control" minlength="4" value="<?php echo date('d/m/Y', strtotime($usuario['data_cadastro']));?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
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
                                <input type="text" class="form-control" minlength="4" id="nome" name="nome" value="<?php echo $usuario['nome'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">E-Mail</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                              </div>
                                <input type="text" class="form-control" minlength="4" id="email" name="email" value="<?php echo $usuario['email'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Celular</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                              </div>
                                <input type="text" class="form-control" minlength="4" id="celular" name="celular" value="<?php echo $usuario['celular'];?>" required="">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Senha</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                              <input type="password" min="6" max="32" class="form-control"  name="senha"
							  data-minlength="6" value="<?php echo $usuario['senha'];?>"  data-toggle="password" placeholder="Digite a Senha" required>

                              </div>
                    </div>
                  </div>



                     <?php if($usuario['tipo']=='revenda'){?>
                     <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">ID De Cliente</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-gear"></i>
                              </div>
                                <input type="text" class="form-control" placeholder="Do Mercado Pago..." name="idcliente" value="<?php echo $usuario['idcliente_mp'];?>">
                                <i class="icon-gear"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>

                     <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Token Secreto</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-gear"></i>
                              </div>
                                <input type="text" class="form-control" name="tokensecreto"  placeholder="Do Mercado Pago..." value="<?php echo $usuario['tokensecret_mp'];?>">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                    </div>
                  </div>

                     <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Dados Bancários</label>

                    <div class="col-sm-10">
                       <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-usd"></i>
                              </div>
                                <textarea name="bancarios" class="form-control" placeholder="Exemplo: Conta Bradesco Para Deposito/Trânsferencia <br> Agencia: 1548 Conta: 6468 Nome: João Paulo" rows=3 cols=20 wrap="off"><?php echo $usuario['dadosdeposito'];?></textarea>

                              </div>
                    </div>
                  </div>

                  <?php } ?>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Alterar Dados</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>




      </div>
      <!-- /.row -->
    </section>