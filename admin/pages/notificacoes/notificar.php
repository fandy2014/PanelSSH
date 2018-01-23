<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}


?>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Notificar Usuarios
        <small>Notifique clientes e revendedores ou todos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Notificar</li>
      </ol>
    </section>
   <section class="content">

    <section class="content">
 <div class="row">

<!-- Revendedor -->
<div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Revendedores</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="form" id="form" action="pages/notificacoes/notificar_revendedor.php" method="post">
              <div class="box-body">
               <div class="form-group">
                  <label>Selecione o Revendedor</label>
                  <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                  <select class="form-control select2" name="revendedor">
                    <option selected=selected>Selecione</option>
                     <?php

                     $SQLUsuario = "SELECT * FROM usuario where tipo='revenda' and subrevenda='nao'";
     $SQLUsuario = $conn->prepare($SQLUsuario);
     $SQLUsuario->execute();

if (($SQLUsuario->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLUsuario->fetch()) {
		if($row['id_usuario'] != $usuario_sistema['id_usuario']){

     $SQLserv = "SELECT * FROM acesso_servidor where id_usuario='".$row['id_usuario']."'";
     $SQLserv = $conn->prepare($SQLserv);
     $SQLserv->execute();
     $sv=$SQLserv->rowCount();

		?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo ucfirst($row['nome']);?> - Servidores: <?php echo $sv;?> </option>

   <?php }
	}
}
                     ?>
                    </select>
                    </div>
                    </div>
                </div>
                   <div class="form-group">
                  <label>Selecione o Tipo</label>
                   <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info"></i>
                              </div>
                  <select class="form-control select2" name="tipo">
                    <option selected=selected>Selecione</option>
                    <option value="1">Fatura</option>
                    <option value="2">Outros/Servidores</option>
                      </select>
                      </div>
                      </div>
                </div>
                <div class="form-group">
                  <label>Mensagem</label>
                  <textarea class="form-control"  name="msg" rows="3" placeholder="Digite ..."></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Notificar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

       </div>

<!-- Cliente -->
 <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cliente VPN</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="form" id="form" action="pages/notificacoes/notificar_clientevpn.php" method="post">
              <div class="box-body">
               <div class="form-group">
                  <label>Selecione o Cliente VPN</label>
                    <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                  <select class="form-control select2" name="clientevpn">
                    <option selected=selected>Selecione</option>
                     <?php

     $SQLUsuario = "SELECT * FROM usuario where id_mestre='0' and tipo='vpn'";
     $SQLUsuario = $conn->prepare($SQLUsuario);
     $SQLUsuario->execute();

if (($SQLUsuario->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLUsuario->fetch()) {
		if($row['id_usuario'] != $usuario_sistema['id_usuario']){

     $SQLserv = "SELECT * FROM  usuario_ssh where id_usuario='".$row['id_usuario']."'";
     $SQLserv = $conn->prepare($SQLserv);
     $SQLserv->execute();
     $sv=$SQLserv->rowCount();

		?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo ucfirst($row['nome']);?> - Contas SSH: <?php echo $sv;?> </option>

   <?php }
	}
}
                     ?>
                    </select>
                    </div>
                    </div>
                </div>
                   <div class="form-group">
                  <label>Selecione o Tipo</label>
                    <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info"></i>
                              </div>
                  <select class="form-control select2" name="tipo">
                    <option selected=selected>Selecione</option>
                    <option value="1">Fatura</option>
                    <option value="2">Outros/Servidores</option>
                      </select>
                   </div>
                   </div>
                </div>
                <div class="form-group">
                  <label>Mensagem</label>
                  <textarea class="form-control"  name="msg" rows="3" placeholder="Digite ..."></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Notificar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

       </div>
     <!-- Todos -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Geral</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="form" id="form" action="pages/notificacoes/notificar_todos.php" method="post">
              <div class="box-body">
               <div class="form-group">
                  <label>Selecione os Clientes</label>
                     <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                  <select class="form-control select2" name="clientes">
                    <option selected=selected>Selecione</option>
                    <option value="1">Todos</option>
                    <option value="2">Todos Revendedores</option>
                    <option value="3">Todos Clientes VPN</option>
                    </select>
                       </div>
                          </div>
                </div>
                   <div class="form-group">
                  <label>Selecione o Tipo</label>
                      <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info"></i>
                              </div>
                  <select class="form-control select2" name="tipo">
                    <option selected=selected>Selecione</option>
                    <option value="1">Fatura</option>
                    <option value="2">Outros/Servidores</option>
                      </select>
                </div>
                 </div>
                  </div>
                <div class="form-group">
                  <label>Mensagem</label>
                  <textarea class="form-control"  name="msg" rows="3" placeholder="Digite ..."></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Notificar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

       </div>

 </div>
 </section>