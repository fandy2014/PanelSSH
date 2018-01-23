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
        "sEmptyTable":    "Nenhum usuário online",
        "sInfo":          "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando de 0 até 0 de 0 registos",
        "sInfoFiltered":  "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix":   "",
        "sSearch":        "Procurar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sSearchPlaceholder": "Procure o usuário",
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
        Contas Online
        <small>Contas online em Tempo Real</small>
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
              <h3 class="box-title">Contas SSH Online</h3>
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
				  <th>Tempo</th>
				  <th>Online</th>
				  <th>Quantidade Online</th>
				  <th>Permitido</th>
				  <th>Owner</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>


				  <?php

				     $SQLSub = "SELECT * FROM usuario where id_usuario= '".$_SESSION['usuarioID']."'";
                        $SQLSub = $conn->prepare($SQLSub);
                        $SQLSub->execute();



                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {
						    $SQLSubSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$_SESSION['usuarioID']."'";
                            $SQLSubSSH = $conn->prepare($SQLSubSSH);
                            $SQLSubSSH->execute();


						    if(($SQLSubSSH->rowCount()) > 0){
								while($row = $SQLSubSSH->fetch()){
								    $status="";
				                    if($row['status']== 1){
						                $status="Ativo";
					                }else{
					           	        $status="Desativado";
				             	    }
									if($row['online'] != 0){
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



								<tr>

                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>

                   <td><?php echo $row['login'];?></td>

                   <td><span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>

                    <td><?php echo tempo_corrido($row['online_start']);?> </td>
				   <td><small class="label bg-green">Online</small></td>
				   <td><?php echo $row['online'];?></td>
                    <td><?php echo $row['acesso'];?></td>
				    <td>Sistema</td>
				   <td>
				   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
				   </td>
                  </tr>
								<?php
								}

								}

							}

					    }
					}



				    if($usuario['tipo']=="revenda"){



					$SQLSub = "SELECT * FROM usuario where id_mestre= '".$_SESSION['usuarioID']."' and subrevenda='nao'";
                    $SQLSub = $conn->prepare($SQLSub);
                    $SQLSub->execute();


                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {
						    $SQLSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$rowSub['id_usuario']."'";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();


						    if(($SQLSSH->rowCount()) > 0){
								while($row = $SQLSSH->fetch()){
								    $status="";
				                    if($row['status']== 1){
						                $status="Ativo";
					                }else{
					           	        $status="Desativado";
				             	    }
								if($row['online'] != 0){


								?>
								<tr>

                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>
                   <td><?php echo $row['login'];?></td>
                 <td><span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span>

				   <td><?php echo tempo_corrido($row['online_start']);?> </td>
				   <td><small class="label bg-green">Online</small></td>
				   <td><?php echo $row['online'];?></td>
				    <td><?php echo $row['acesso'];?></td>
                   <td><?php echo $rowSub['login'];?></td>

				   <td>
				   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
				   </td>
                  </tr>
								<?php
								}

								}

							}

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





