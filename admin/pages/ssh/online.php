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
<script type="text/javascript">
function deleta(id){
decisao = confirm("Tem certeza que deseja deletar essa Conta?!");
if (decisao){
  window.location.href='home.php?page=ssh/online_free&deletar='+id;
} else {

}


}
</script>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Contas SSH FREE
        <small>Contas Online em Tempo Real</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Contas SSH</li>
        <li class="active">Online</li>
      </ol>
    </section>
     <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Contas SSH online</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Servidor</th>
				  <th>IP SSH</th>
				  <th>Login</th>
                  <th>Validade</th>
				  <th>Owner</th>
				  <th>Tempo</th>
				  <th>Online</th>
				  <th>Quantidade Online</th>
				  <th>Permitido</th>
                  <th>Informações</th>
                </tr>
                </thead>
                <tbody>

  <?php




					$SQLSub = "SELECT * FROM usuario_ssh";
                    $SQLSub = $conn->prepare($SQLSub);
                    $SQLSub->execute();


                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {

						    $SQLSSH = "SELECT * FROM servidor where tipo='premium' and id_servidor='".$rowSub['id_servidor']."' ORDER BY id_servidor";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
                            $row = $SQLSSH->fetch();



									//Calcula os dias restante
		$dias_acesso = 0 ;

	    $data_atual = date("Y-m-d ");
		$data_validade = $rowSub['data_validade'];
		if($data_validade > $data_atual){
		   $data1 = new DateTime( $data_validade );
           $data2 = new DateTime( $data_atual );
           $dias_acesso = 0;
           $diferenca = $data1->diff( $data2 );
           $ano = $diferenca->y * 364 ;
	       $mes = $diferenca->m * 30;
		   $dia = $diferenca->d;
           $dias_acesso = $ano + $mes + $dia;

		}

			        $SQLSubowner = "SELECT * FROM usuario where id_usuario='".$rowSub['id_usuario']."'";
                    $SQLSubowner = $conn->prepare($SQLSubowner);
                    $SQLSubowner->execute();
                    $own=$SQLSubowner->fetch();


								    $status="";
				                    if($rowSub['status']== 1){
						                $status="Ativo";
										$class = "class='btn-sm btn-primary'";
					                }else{
					           	        $status="Desativado";
				             	    }

									if($rowSub['online'] != 0){

								?>
								<tr>

                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>

                   <td><?php echo $rowSub['login'];?></td>
                   <td>

				       <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>



			      </td>
			      <td><?php echo $own['nome'];?></td>
				  <td><?php echo tempo_corrido($rowSub['online_start']);?> </td>
				   <td><?php
				   if($rowSub['online']>0){ ?>
				   <small class="label bg-green">Online</small>
				   <?php }else{
				   echo $rowSub['online']; } ?></td>

                   <td><?php echo $rowSub['online'];?></td>
                     <td><?php echo $rowSub['acesso'];?></td>
				   <td>
				 	  <a href="home.php?page=ssh/editar&id_ssh=<?php echo $rowSub['id_usuario_ssh'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
				   </td>
                  </tr>
								<?php
									}




					    }
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















