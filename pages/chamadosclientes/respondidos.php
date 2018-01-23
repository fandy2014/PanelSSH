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
        "sEmptyTable":    "Nenhum chamado RESPONDIDO atualmente dos seus clientes",
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
        Chamados Respondidos
        <small>Lista Chamados Respondidos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Chamados</li>
        <li class="active">Respondidos</li>
      </ol>
    </section>
 <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Chamados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th>N° de Chamado</th>
                 <th>Status</th>
                 <th>Aberto Por</th>
                 <th>Tipo de Chamado</th>
                 <th>Login/Servidor</th>
                 <th>Ultima Atualização</th>
				 <th>Informações</th>
                </tr>
                </thead>
                <tbody>

   <?php




                    $SQLUsuario = "SELECT * FROM chamados   where  status = 'resposta' and id_mestre='".$_SESSION['usuarioID']."' ORDER BY id desc";
                    $SQLUsuario = $conn->prepare($SQLUsuario);
                    $SQLUsuario->execute();


					// output data of each row
                   if (($SQLUsuario->rowCount()) > 0) {

                   while($row = $SQLUsuario->fetch())


				   {

                    $SQLUsuario2 = "SELECT * FROM usuario   where  id_usuario = '".$row['usuario_id']."'";
                    $SQLUsuario2 = $conn->prepare($SQLUsuario2);
                    $SQLUsuario2->execute();
                    $user2 = $SQLUsuario2->fetch();

                    switch($row['tipo']){
                    case 'contassh':$tipo='SSH';break;
                    case 'revendassh':$tipo='REVENDA SSH';break;
                    case 'usuariossh':$tipo='USUÁRIO SSH';break;
                    case 'servidor':$tipo='SERVIDOR';break;
                    case 'outros':$tipo='OUTROS';break;
                    default:$tipo='Erro';break;
                    }

                    $data1=explode(' ',$row['data']);
                    $data2=explode('-',$data1[0]);
                    $dia=$data2[2];
                    $mes=$data2[1];
                    $ano=$data2[0];


					   ?>


   <div class="modal fade" id="squarespaceModal2<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-info"></i> Encerramento de Chamado</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/chamadosclientes/encerrar_chamado.php" method="post">
			<input name="chamado" type="hidden" value="<?php echo $row['id'];?>">
			<input name="diretorio" type="hidden" value="../../home.php?page=chamadosclientes/respondidos">
              <div class="form-group">
                <label for="exampleInputPassword1">Deseja deixar uma Resposta?</label>
                <textarea class="form-control" name="msg" rows=5 cols=20 wrap="off" placeholder="Resposta final opcional"></textarea>
              </div>



		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Encerrar Chamado</button>
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>

   <div class="modal fade" id="squarespaceModal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-info"></i> Informações do Chamado</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form action="pages/chamadosclientes/responder_chamado.php" method="post">
			<input name="chamado" type="hidden" value="<?php echo $row['id'];?>">
			<input name="diretorio" type="hidden" value="../../home.php?page=chamadosclientes/respondidos">
			 <div class="form-group">
                <label for="exampleInputEmail1">Motivo</label>
                 <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['motivo'];?>" disabled>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Mensagem</label>
               <textarea class="form-control" rows=5 cols=20 wrap="off" disabled><?php echo $row['mensagem'];?></textarea>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Problema</label>
               <select size="1" class="form-control" disabled>
              <option  selected=selectes><?php echo $tipo;?></option>
             </select>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Resposta</label>
                <textarea class="form-control" name="msg" rows=5 cols=20 wrap="off" placeholder="Deixe uma resposta para ele visualizar" required><?php echo $row['resposta'];?></textarea>
              </div>



		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Responder</button>
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>

                   <tr>
                   <td>#<?php echo $row['id'];?></td>
				   <td><small class="label label-warning"><?php echo ucfirst($row['status']);?></small></td>
                   <td><a href="home.php?page=usuario/perfil&id_usuario=<?php echo $user2['id_usuario'];?>"><?php echo $user2['nome'];?></a></td>
                   <td><?php echo $tipo;?></td>
                   <td><?php echo $subrev;?></td>
                   <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>


				   <td>

					<a data-toggle="modal" href="#squarespaceModal<?php echo $row['id'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                    <a data-toggle="modal" href="#squarespaceModal2<?php echo $row['id'];?>" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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






