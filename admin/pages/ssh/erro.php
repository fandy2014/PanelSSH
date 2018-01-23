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
        "sEmptyTable":    "Nenhuma conta online no momento",
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
        <small>Contas SSH com Erros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Contas SSH</li>
        <li class="active">Erro</li>
      </ol>
    </section>


    <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Contas SSH com erros</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Servidor</th>
				  <th>IP SSH e Proxy</th>
                  <th>Problema</th>
                  <th>Login</th>
                  <th>Validade</th>
				  <th>Owner</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>

   <?php
					$SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.status > '2'";
                    $SQLSSH = $conn->prepare($SQLSSH);
                    $SQLSSH->execute();


					// output data of each row
                   if (($SQLSSH->rowCount()) > 0) {

                   while($row = $SQLSSH->fetch())


				   {
					 $class = "class='btn btn-danger'";
					 $status="";
					 $erro="";
					 $owner="";
					 $color = "";


				     if($row['status']== 1){
						 $status="Ativo";
						 $class = "class='btn btn-primary'";
					    }else if($row['status']== 2){
						$status="Suspenso";
						$color = "bgcolor='#FF6347'";
					} if($row['apagar']== 5){
						 $erro="Erro ao deletar";

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

                  <tr <?php echo $color; ?> >

                   <td><?php echo $row['nome'];?></td>
				   <td><?php echo $row['ip_servidor'];?></td>
                   <td> <?php echo $erro; ?></td>
                   <td><?php echo $row['login'];?></td>

                   <td>
				   <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>

					   <?php echo date('d/m/Y', strtotime($row['data_validade']));?>


				   </td>
				   <td><?php echo $owner;?></td>

				   <td>


					  <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>>Visualizar</a>



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











