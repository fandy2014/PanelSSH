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
        "sSearchPlaceholder": "Procure a fatura",
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
        Faturas
        <small>Lista de faturas pagas</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
         <li class="active">Faturas</li>
        <li class="active">Pagas</li>
      </ol>
       </section>
    <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Verifique suas faturas completas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Fatura</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Data</th>
                  <th>Vencimento</th>
				  <th>Valor</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>

                <?php




					$SQLUPUser= "SELECT * FROM fatura where usuario_id =  '".$usuario['id_usuario']."' and status='pago' ORDER BY id desc ";
                    $SQLUPUser = $conn->prepare($SQLUPUser);
                    $SQLUPUser->execute();

					// output data of each row
                   if (($SQLUPUser->rowCount()) > 0) {

                   while($row = $SQLUPUser->fetch())


				   {

					  switch($row['tipo']){
					  case 'vpn':$tipo='Acesso VPN';break;
					  case 'revenda':$tipo='Revenda';break;
					  default:$tipo='Outros';break;
	                  }


					 $datacriado=$row['data'];
					 $dataconvcriado = substr($datacriado, 0, 10);
					 $partes = explode("-", $dataconvcriado);
                     $ano = $partes[0];
                     $mes = $partes[1];
                     $dia = $partes[2];

                     $vencimento=$row['datavencimento'];
					 $datavn = substr($vencimento, 0, 10);
					 $partesven = explode("-", $datavn);
                     $anov = $partesven[0];
                     $mesv = $partesven[1];
                     $diav = $partesven[2];

                     $valor=number_format(($row['valor'])*($row['qtd']),2);

                      switch($row['status']){
					  case 'pendente':$botao='<span class="label label-warning">Pendente</span>';break;
					  case 'cancelado':$botao='<span class="label label-danger">Cancelado</span>';break;
					  case 'pago':$botao='<span class="label label-success">Pago</span>';break;
					  default:$botao='Outros';break;
	                  }


					   ?>

                  <tr >
				   <td >#<?php echo $row['id'];?></td>
                   <td><?php echo $tipo;?></td>
                   <td><?php echo $botao;?></td>
                   <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                   <td><?php echo $diav;?>/<?php echo $mesv;?> - <?php echo $anov;?></td>
				   <td>R$<?php echo number_format($valor, 2, ',', '.');?></td>


				   <td>

					   <a href="home.php?page=faturas/verfatura&id=<?php echo $row['id'];?>" class="btn btn-block btn-success">Visualizar</a>



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







