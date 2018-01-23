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
        "sSearchPlaceholder": "Procure",
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
        Servidor
        <small>Lista de servidores cadastrados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servidores</li>
        <li class="active">Lista</li>
      </ol>
    </section>
    <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Lista de Servidores</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Tipo</th>
                  <th>Região</th>
                  <th>Endereço IP</th>
                  <th>Login</th>
                  <th>OpenVPN</th>
                  <th>Contas Criadas</th>
				  <th>Acessos Liberados</th>
				  <th>Informações</th>
                </tr>
                </thead>
                <tbody>

  	  <?php





                    $SQLServidor = "select * from servidor";
                    $SQLServidor = $conn->prepare($SQLServidor);
                    $SQLServidor->execute();

					// output data of each row
                   if (($SQLServidor->rowCount()) > 0) {

                   while($row = $SQLServidor->fetch())


				   {
				       $acessos = 0 ;

					   if($row['tipo']=='premium'){
					   $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor='".$row['id_servidor']."' ";
                       $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                       $SQLAcessoSSH->execute();
	                   $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                       $acessos += $SQLAcessoSSH['quantidade'];

					   $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row['id_servidor']."' ";
                       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                       $SQLUsuarioSSH->execute();

                       }else{                       $SQLUsuarioSSH = "select * from usuario_ssh_free WHERE servidor = '".$row['id_servidor']."' ";
                       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                       $SQLUsuarioSSH->execute();
                       }

	                   $qtd_ssh = $SQLUsuarioSSH->rowCount();

	                   switch($row['tipo']){	                   case 'premium':$tipo='Premium';break;
	                   case 'free':$tipo='Free';break;
	                   default:$tipo='erro';break;
	                   }

	                   $SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
                       $SQLopen = $conn->prepare($SQLopen);
                       $SQLopen->execute();
                       if($SQLopen->rowCount()>0){                       $openvpn=$SQLopen->fetch();
                       $texto="<a href='../admin/pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
                       }else{                       $texto="<span class=\"label label-danger\">Indisponivel</span>";
                       }


					   ?>

                  <tr>

                   <td><?php echo $row['nome'];?></td>
                   <td><?php echo $tipo;?></td>
                   <td><?php echo ucfirst($row['regiao']);?></td>
                   <td><?php echo $row['ip_servidor'];?></td>
                   <td><?php echo $row['login_server'];?></td>
                    <td><?php echo $texto;?></td>
				    <td><?php echo $qtd_ssh;?></td>
					 <td><?php echo $acessos;?></td>


				   <td>


				    <a href="home.php?page=servidor/servidor&id_servidor=<?php echo $row['id_servidor'];?>" class="btn btn-primary">	Visualizar</a>
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




