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
        "sSearchPlaceholder": "Procure a conta",
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
<!-- Main content -->
 <section class="content-header">
      <h1>
        Contas SSH
        <small>Lista as contas SSH Existentes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Contas SSH</li>
        <li class="active">Listar</li>
      </ol>
    </section>
   <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Contas SSH Criadas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Servidor</th>
				  <th>IP</th>
                  <th>Porta</th>
                  <th>Status</th>
                  <th>Login</th>
                  <th>Validade</th>
				  <th>Owner</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>


								  <?php
					$SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and  usuario_ssh.status <= '2' ORDER BY  usuario_ssh.status  ";
                    $SQLSSH = $conn->prepare($SQLSSH);
                    $SQLSSH->execute();


					// output data of each row
                   if (($SQLSSH->rowCount()) > 0) {

                   while($row = $SQLSSH->fetch())


				   {
					 $class = "class='btn btn-danger'";
					 $status="";
					 $owner="";
					 $color = "";
				     if($row['status']== 1){
						 $status="Ativo";
						 $class = "class='btn-sm btn-primary'";
					    }else if($row['status']== 2){
						$status="Suspenso";
						$color = "bgcolor='#FF6347'";
					}
                    if($row['id_usuario'] == 0){
						 $owner="Sistema";
					    }else{

						$SQLRevendedor = "select * from usuario WHERE id_usuario = '".$row['id_usuario']."'";
                        $SQLRevendedor = $conn->prepare($SQLRevendedor);
                        $SQLRevendedor->execute();
                        $revendedor = $SQLRevendedor->fetch();

						$owner = $revendedor['login'];
					}
//Calcula os dias restante
	    $data_atual = date("Y-m-d ");
		$data_validade = $row['data_validade'];
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

	<div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario_ssh'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/ssh/criarfatura_ssh.php" method="post">
			<input name="idcontassh" type="hidden" value="<?php echo $row['id_usuario_ssh'];?>">
			 <div class="form-group">
               <label for="exampleInputEmail1">Conta SSH</label>
                 <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['login'];?>" disabled>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Dono</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $revendedor['login'];?>" disabled>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="number" class="form-control" name="valor" value="1">
                <p><small>*Vezes Acesso que ele possui</small></p>
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
                <textarea class="form-control" name="msg" rows=3 cols=20 wrap="off" placeholder="Digite..."></textarea>
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

                  <tr <?php echo $color; ?> >

                   <td><?php echo $row['nome'];?></td>
				   <td><?php echo $row['ip_servidor'];?></td>
                   <td> 80,8080|443,22</td>
                    <td ><?php echo $status;?></td>
                   <td><?php echo $row['login'];?></td>

                   <td>
				   <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>



				   </td>
				   <td><?php echo $owner;?></td>

				   <td>


					  <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
                      <?php if(($revendedor['tipo']=='vpn')and($owner<>'Sistema')){?> <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-success label-orange"><i class="fa fa-shopping-cart"></i></a><?php }else{?><?php } ?>


				   </td>
                  </tr>




   <?php }
}


?>

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



