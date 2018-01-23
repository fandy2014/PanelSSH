 <?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
  $('#example1').DataTable({
    "language": {
        "sProcessing":    "Processando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados resultados",
        "sEmptyTable":    "Nenhum dado disponivel",
        "sInfo":          "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando de 0 até 0 de 0 registos",
        "sInfoFiltered":  "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix":   "",
        "sSearch":        "Procurar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sSearchPlaceholder": "Procure o usuario",
        "sLoadingRecords": "A carregar dados...",
        "oPaginate": {
            "sFirst":    "Primeiro",
            "sLast":    "Último",
            "sNext":    "Seguinte",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Clique para ordenar ascendente (ASC)",
            "sSortDescending": ": Clique para ordenar descendente (DESC)"
        }
    }
});
  responsive: true
  });
</script>
<section class="content-header">
      <h1>
        Usuários
        <small>Lista de usuários no sistema</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
         <li class="active">Usuários</li>
        <li class="active">Lista</li>
      </ol>
       </section>
    <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Contas dos Usúarios do Sistema</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Status</th>
                  <th>Nome</th>
                  <th>Login</th>
                  <th>Senha</th>
                  <th>Tipo</th>
				  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>

                <?php




					$SQLUPUser= "SELECT * FROM usuario where id_mestre =  '".$usuario['id_usuario']."' and subrevenda='nao' ORDER BY ativo ";
                    $SQLUPUser = $conn->prepare($SQLUPUser);
                    $SQLUPUser->execute();

					// output data of each row
                   if (($SQLUPUser->rowCount()) > 0) {

                   while($row = $SQLUPUser->fetch())


				   {
					  $SQLSubUser= "SELECT * FROM usuario_ssh where id_usuario =  '".$row['id_usuario']."' ";
                      $SQLSubUser = $conn->prepare($SQLSubUser);
                      $SQLSubUser->execute();
					  $contas = $SQLSubUser->rowCount();
					  $color = "";
					  $status="";
					  $tipo="";
				    if($row['ativo']== 1){
						 $status="Ativo";
					}else if($row['ativo']!= 1){
						$status="Suspenso";
						$color = "bgcolor='#FF6347'";
					}else{

					}
					if($row['tipo']=="vpn"){
						 $tipo="Usuário SSH";
					}else{						if($row['subrevenda']=='sim'){
						$tipo="Sub-Revendedor";
						}else{						$tipo="Revendedor";
						}
					}

					$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];



					   ?>

					<div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i> Notificar Usuario</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form action="pages/usuario/notifica_user.php" method="post">
			<input name="iduser" type="hidden" value="<?php echo $row['id_usuario'];?>">
			 <div class="form-group">
                <label for="exampleInputEmail1">Usuario</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['nome'];?>" disabled>
              </div>
                <div class="form-group">
                <label for="exampleInputEmail1">Tipo de Alerta</label>
                <select size="1" name="tipo" class="form-control">
                <option value="1" selected=selected>Usuário VPN</option>
                <option value="2">Outros</option>
                </select>
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Mensagem</label>
                <textarea class="form-control" name="msg" rows=5 cols=20 wrap="off" placeholder="Digite..." required></textarea>
              </div>
		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Confirmar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>

<div class="modal fade" id="criarfatura<?php echo $row['id_usuario'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/usuario/criafatura_usuario.php" method="post">
			<input name="idcontausuario" type="hidden" value="<?php echo $row['id_usuario'];?>">
			 <div class="form-group">
               <label for="exampleInputEmail1">Usuário</label>
                 <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['nome'];?>" disabled="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Tipo</label>
                <select size="1" name="tipo" class="form-control">
                <option value="1" selected=selected>Acesso VPN</option>
                <option value="2">Outros</option>
                <?php if($row['revenda']=='sim'){?><option value="3">Revenda</option> <?php }?>

                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="number" class="form-control" name="valor" value="1">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Desconto</label>
                <input type="number" class="form-control" name="desconto" value="0">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Prazo</label>
                <input type="number" class="form-control" name="prazo" value="1">
              </div>
                 <div class="form-group">
                <label for="exampleInputPassword1">Descrição</label>
                <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
              </div>



		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal" role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Confirmar</button>

				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
</div>

                  <tr  <?php echo $color; ?> >
				   <td ><?php echo $status;?></td>
                   <td><?php echo $row['nome'];?></td>

                   <td><?php echo $row['login'];?></td>
                    <td><?php echo $row['senha'];?></td>
                   <td><?php echo $tipo;?></td>
				    <td><?php echo $contas;?></td>
					 <td><?php echo $total_acesso_ssh;?></td>


				   <td>

					   <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                       <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario'];?>"  class="btn-sm btn-warning"><i class="fa fa-flag"></i></a>
                       <a data-toggle="modal" href="#criarfatura<?php echo $row['id_usuario'];?>" class="btn-sm btn-success label-orange"><b>$</b></a>

				   </td>
                  </tr>




   <?php } } ?>


                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
          <!-- /.box -->
        </div>
      </div>


    </section>







