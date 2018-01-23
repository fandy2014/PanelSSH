 <?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

// Usados

$qtddoserverusado=0;

$SQLusuariosdele= "SELECT * FROM acesso_servidor where id_mestre = '".$_SESSION['usuarioID']."'";
$SQLusuariosdele = $conn->prepare($SQLusuariosdele);
$SQLusuariosdele->execute();

if ($SQLusuariosdele->rowCount()>0) {
while($usuariosdele=$SQLusuariosdele->fetch()){


$SQLcontaqtdsshusadodele= "SELECT sum(acesso) as acessosdosserversusados2 FROM usuario_ssh where id_usuario = '".$usuariosdele['id_usuario']."'";
$SQLcontaqtdsshusadodele = $conn->prepare($SQLcontaqtdsshusadodele);
$SQLcontaqtdsshusadodele->execute();

$qtdusadosdele=$SQLcontaqtdsshusadodele->fetch();

$qtddoserverusado+=$qtdusadosdele['acessosdosserversusados2'];

//Select sub deles

$SQLusuariossubdele= "SELECT * FROM usuario where id_mestre = '".$usuariosdele['id_usuario']."'";
$SQLusuariossubdele = $conn->prepare($SQLusuariossubdele);
$SQLusuariossubdele->execute();

if ($SQLusuariossubdele->rowCount()>0) {
while($usuariossubdele=$SQLusuariossubdele->fetch()){
$SQLcontaqtdsshusado= "SELECT sum(acesso) as acessosdosserversusados FROM usuario_ssh where id_usuario = '".$usuariossubdele['id_usuario']."'";
$SQLcontaqtdsshusado = $conn->prepare($SQLcontaqtdsshusado);
$SQLcontaqtdsshusado->execute();

$qtdusados=$SQLcontaqtdsshusado->fetch();

$qtddoserverusado+=$qtdusados['acessosdosserversusados'];


}
}


}

}




// Todos Acessos

$todosacessos=0;

$SQLqtdserveracessos2= "SELECT sum(qtd) as tudo FROM  acesso_servidor where id_mestre = '".$_SESSION['usuarioID']."'";
$SQLqtdserveracessos2 = $conn->prepare($SQLqtdserveracessos2);
$SQLqtdserveracessos2->execute();

$totalacessf=$SQLqtdserveracessos2->fetch();

$todosacessos+=$totalacessf['tudo'];


//Disponiveis
$disponiveis=$todosacessos-$qtddoserverusado;

if($disponiveis<=0){$disponiveis=0;}


//Calculo Porcentagem

$porcent = ($qtddoserverusado/$todosacessos)*100; // %

$resultado = $porcent;

$valor_porce = round($resultado);

if($valor_porce>=100){$valor_porce=100;
}



if(($valor_porce>=70)and($valor_porce<90)){
$sucessobar="warning";
$bgbar="orange";
}elseif($valor_porce>=90){
$sucessobar="danger";
$bgbar="red";
}else{
$sucessobar="success";
$bgbar="green";
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
        "sSearchPlaceholder": "Procure o servidor",
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
        Servidores
        <small>Lista de Todos os Servidores</small>
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
                  <th>Cliente</th>
                  <th>Uso</th>
                  <th>Endereço IP</th>
				  <th>Contas Criadas</th>
				  <th>Acessos Liberados</th>
				  <th>Limite</th>
				  <th>Validade</th>
				  <th>Editar</th>
                </tr>
                </thead>
                <tbody>

            	  <?php

				    $SQLAcessoServidor = "SELECT * FROM acesso_servidor where id_mestre = '".$_SESSION['usuarioID']."' ";
                    $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
                    $SQLAcessoServidor->execute();



					// output data of each row
                   if (($SQLAcessoServidor->rowCount()) > 0) {

                   while($row = $SQLAcessoServidor->fetch())


				   {

				    $SQLusuario = "SELECT * FROM usuario where id_usuario = '".$row['id_usuario']."' ";
                    $SQLusuario = $conn->prepare($SQLusuario);
                    $SQLusuario->execute();
                    $usuario=$SQLusuario->fetch();


					  $contas=0;
                      $total_acesso_ssh=0;

					$SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and id_servidor='".$row['id_servidor']."'";
                    $SQLContasSSH = $conn->prepare($SQLContasSSH);
                    $SQLContasSSH->execute();
                    $contas += $SQLContasSSH->rowCount();

                    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' and id_servidor='".$row['id_servidor']."'";
                    $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                    $SQLAcessoSSH->execute();
	             	$SQLAcessoSSH = $SQLAcessoSSH->fetch();
                    $total_acesso_ssh += $SQLAcessoSSH['quantidade'];

                    $SQLUserSub = "select * from usuario WHERE id_mestre = '".$row['id_usuario']."'";
                    $SQLUserSub = $conn->prepare($SQLUserSub);
                    $SQLUserSub->execute();

                       if (($SQLUserSub->rowCount()) > 0) {

                        while($rowS = $SQLUserSub->fetch()) {
                           $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowS['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                           $SQLContasSSH = $conn->prepare($SQLContasSSH);
                           $SQLContasSSH->execute();
                           $contas += $SQLContasSSH->rowCount();

						    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$rowS['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                            $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                            $SQLAcessoSSH->execute();
	             	        $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                            $total_acesso_ssh += $SQLAcessoSSH['quantidade'];

                            $SQLusuariossubdele2= "SELECT * FROM usuario where id_mestre = '".$rowS['id_usuario']."'";
                            $SQLusuariossubdele2 = $conn->prepare($SQLusuariossubdele2);
                            $SQLusuariossubdele2->execute();
                            if (($SQLusuariossubdele2->rowCount()) > 0) {                            while($rowSubdele = $SQLusuariossubdele2->fetch()) {
                            $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowSubdele['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                            $SQLContasSSH = $conn->prepare($SQLContasSSH);
                            $SQLContasSSH->execute();
                            $contas += $SQLContasSSH->rowCount();

						    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$rowSubdele['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                            $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                            $SQLAcessoSSH->execute();
	             	        $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                            $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


                            }
                            }

						}
					}



                      $Servidor = "select * from servidor where id_servidor='".$row['id_servidor']."'";
                      $Servidor = $conn->prepare($Servidor);
                      $Servidor->execute();
                      $rowservidor = $Servidor->fetch();

                      $SQLcliennte = "select * from usuario WHERE id_usuario='".$row['id_usuario']."' ";
                      $SQLcliennte = $conn->prepare($SQLcliennte);
                      $SQLcliennte->execute();
                      $cliente=$SQLcliennte->fetch();

 $todosacessos2=0;

$SQLqtdserveracessos2= "SELECT sum(qtd) as todosacessos FROM  acesso_servidor where id_usuario = '".$row['id_usuario']."' and id_servidor='".$row['id_servidor']."' ";
$SQLqtdserveracessos2 = $conn->prepare($SQLqtdserveracessos2);
$SQLqtdserveracessos2->execute();

$totalacess2=$SQLqtdserveracessos2->fetch();

$todosacessos2+=$totalacess2['todosacessos'];

//Calculo Porcentagem

$porcentagem = ($total_acesso_ssh/$todosacessos2)*100; // %

$resultado2 = $porcentagem;

$valor_porcetage = round($resultado2);

if($valor_porcetage>=100){
$valor_porcetage=100;
}

if($valor_porcetage<=0){
$valor_porcetage=0;
}
if(($valor_porcetage>=70)and($valor_porcetage<90)){
$sucessobar="warning";
$bgbar2="orange";
}elseif($valor_porcetage>=90){
$sucessobar="danger";
$bgbar2="red";
}else{
$sucessobar="success";
$bgbar2="green";
}


					   $SQLServidor= "select * from servidor WHERE id_servidor = '".$row['id_servidor']."' ";
                       $SQLServidor = $conn->prepare($SQLServidor);
                       $SQLServidor->execute();
					   $servidor =  $SQLServidor->fetch();


		               $SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
                       $SQLopen = $conn->prepare($SQLopen);
                       $SQLopen->execute();
                       if($SQLopen->rowCount()>0){
                       $openvpn=$SQLopen->fetch();
                       $texto="<a href='../admin/pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
                       }else{
                       $texto="<span class=\"label label-danger\">Indisponivel</span>";
                       }

                 //Calcula os dias restante
	             $data_atual = date("Y-m-d");
		         $data_validade = $row['validade'];
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


                              //Carrega contas SSH criadas
$SQLContasminha = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row['id_servidor']."' and id_usuario='".$_SESSION['usuarioID']."' ";
$SQLContasminha = $conn->prepare($SQLContasminha);
$SQLContasminha->execute();
$SQLContasminha = $SQLContasminha->fetch();
$contas_ssh_criadas_minhas = $SQLContasminha['quantidade'];

	    //Carrega usuario sub
		$SQLUsuarioSub_minhas = "SELECT * FROM usuario WHERE id_mestre ='".$_SESSION['usuarioID']."' and subrevenda='nao'";
        $SQLUsuarioSub_minhas = $conn->prepare($SQLUsuarioSub_minhas);
        $SQLUsuarioSub_minhas->execute();


		if (($SQLUsuarioSub_minhas->rowCount()) > 0) {
				while($row2 = $SQLUsuarioSub_minhas->fetch()) {
				$SQLSubSSH_minhas= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row2['id_usuario']."' and id_servidor='".$serveacesso['id_servidor']."' ";
                $SQLSubSSH_minhas = $conn->prepare($SQLSubSSH_minhas);
                $SQLSubSSH_minhas->execute();
				$SQLSubSSH_minhas = $SQLSubSSH_minhas->fetch();
			    $contas_ssh_criadas_minhas += $SQLSubSSH_minhas['quantidade'];

			}

		}


                    $SQLservermy = "select * from acesso_servidor WHERE id_acesso_servidor='".$row['id_servidor_mestre']."'";
                    $SQLservermy = $conn->prepare($SQLservermy);
                    $SQLservermy->execute();

                    $meuserver=$SQLservermy->fetch();

                       $somameusatuais=$meuserver['qtd']-$contas_ssh_criadas_minhas;

					   ?>

					   			<div id="myModal<?php echo $row['id_acesso_servidor'];?>" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
               <form name="deletarserver" action="pages/subrevenda/deletarservidor_exe.php" method="post">
                <input name="servidor" type="hidden" value="<?php echo $row['id_acesso_servidor'];?>">
                <input name="cliente" type="hidden" value="<?php echo $cliente['id_usuario'];?>">
                <div class="modal-header">
                    <a class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
                    <h4 class="modal-title">Apagar Tudo de <?php echo $cliente['nome'];?></h4>
                </div>
                <div class="modal-body">
                    <h4>Tem certeza?</h4>
                    <p>Todos os clientes deles irão ter a conta SSH Deletada.</p>
                    <p>Você recebe os Acessos de Volta.</p>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                        <button name="deletandoserver" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Confirmar</button>
                        </form>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
    </div><!-- /.modal -->

 <div class="modal fade" id="squarespaceModal<?php echo $row['id_acesso_servidor'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i> Editar Servidor de Acesso</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/subrevenda/editar_acesso.php" method="post">
			<input name="idservidoracesso" type="hidden" value="<?php echo $row['id_acesso_servidor'];?>">
			 <div class="form-group">
                <label for="exampleInputEmail1">Servidor</label>
                <select size="1" class="form-control select2" name="fazer" disabled>
                <option value="<?php echo $rowservidor['id_servidor'];?>" selected=selected> <?php echo $rowservidor['nome'];?> - <?php echo $rowservidor['ip_servidor'];?> -  Limite Atual: <?php echo $row['qtd'];?> Saldo: <?php echo $somameusatuais;?></option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Revendedor</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $cliente['nome'];?>" disabled>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">+ Dias</label>
                <input type="number" class="form-control" name="dias" value="1">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">+ Limite</label>
                <input type="number" class="form-control" name="limite" value="0">
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

<div class="modal fade" id="criarfatura<?php echo $row['id_acesso_servidor'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/subrevenda/criafatura_subaloc.php" method="post">
			<input name="idcontausuario" type="hidden" value="<?php echo $row['id_usuario'];?>">
			<input name="servidoralocado" type="hidden" value="<?php echo $row['id_acesso_servidor'];?>">
			 <div class="form-group">
               <label for="exampleInputEmail1">Servidor</label>
                 <input type="text" class="form-control" value="<?php echo $servidor['nome'];?>" disabled="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Cliente</label>
                 <input type="text" class="form-control" disabled value="<?php echo $cliente['nome'];?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Tipo</label>
                <select size="1" class="form-control" disabled>
                <option value="3" selected=selected>Revenda</option>
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


                  <tr>

                   <td><?php echo $servidor['nome'];?></td>
                   <td><?php echo $usuario['nome'];?></td>
                   <td><span class="badge bg-<?php echo $bgbar2;?>"><?php echo $valor_porcetage;?>%</span></td>
                   <td><?php echo $servidor['ip_servidor'];?></td>
				   <td><?php echo $contas;?></td>
                   <td><?php echo $total_acesso_ssh;?></td>
                   <td><?php echo $row['qtd'];?></td>
                     <td><span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span></td>

                 <td>

				  <a data-toggle="modal" href="#myModal<?php echo $row['id_acesso_servidor'];?>" class="btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
				  <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_acesso_servidor'];?>" class="btn-sm btn-warning label-orange"><i class="fa fa-list-alt"></i></a>
				  <a data-toggle="modal" href="#criarfatura<?php echo $row['id_acesso_servidor'];?>" class="btn-sm btn-success label-orange"><b>$</b></a>
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

     <div class="box">
        <div class="box-header">
          <center><h3 class="box-title">Estatísticas (Deles)</h3></center>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody><tr>
              <th style="width: 50%">Acessos</th>
              <th style="width: 50%">Acessos Disponíveis</th>
            </tr>
            <tr>
              <td><?php echo $qtddoserverusado;?>/<?php echo $todosacessos;?></td>
              <td><?php echo $disponiveis;?></td>
            </tr>
            <tr>
              <th>Progresso de Uso</th>
              <th style="width: 40px">Utilizado (%)</th>
            </tr>
            <tr>
                            <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-<?php echo $sucessobar;?>" style="width: <?php echo $valor_porce;?>%"></div>
                </div>
              </td>
              <td><span class="badge bg-<?php echo $bgbar;?> "><?php echo $valor_porce;?>%</span></td>
            </tr>


          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>

      </div>


    </section>
 <style>
.modal .modal-header {
  border-bottom: none;
  position: relative;
}
.modal .modal-header .btn {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: 0;
  border-top-left-radius: 0;
  border-bottom-right-radius: 0;
}
.modal .modal-footer {
  border-top: none;
  padding: 0;
}
.modal .modal-footer .btn-group > .btn:first-child {
  border-bottom-left-radius: 0;
}
.modal .modal-footer .btn-group > .btn:last-child {
  border-top-right-radius: 0;
}
</style>



