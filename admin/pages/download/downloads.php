<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script>
  $(function () {
  $('#example1').DataTable({
    "language": {
        "sProcessing":    "Processando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados resultados",
        "sEmptyTable":    "Nenhum arquivo encontrado no momento",
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
<script type="text/javascript">
function deletatudo(){
decisao = confirm("Tem certeza que deseja deletar todos downloads?!");
if (decisao){
  window.location.href='pages/download/excluir_todos.php?id=1';
} else {

}


}
</script>

<!-- Main content -->
 <section class="content-header">
      <h1>
        Downloads
        <small>Adiciona downloads aos clientes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Downloads</li>
      </ol>
    </section>
 <section class="content">
 <div class="row">

     <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Adicione Arquivos/APKS para todos os Seus Clientes</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-files-o"></i> Adicionar Downloads ao sistema</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/download/enviandoarquivo.php" enctype="multipart/form-data" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Nome do Arquivo</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-file-text-o"></i>
                              </div>
                                <input type="text" name="nome" id="nome" class="form-control" minlength="4"  placeholder="Digite o Nome do Arquivo..." required>
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Operadora</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-internet-explorer"></i>
                              </div>
                                 <select class="form-control select2" name="operadora">
                    <option value='1' selected=selected>Todas</option>
                    <option value='2'>Claro</option>
                    <option value='3'>Vivo</option>
                    <option value='4'>Tim</option>
                    <option value='5'>Oi</option>
                  </select>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Status</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-check"></i>
                              </div>
                               <select class="form-control select2" name="status">
                    <option value='1' selected=selected>Funcionando</option>
                    <option value='2'>Em Testes</option>
                  </select>
                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Tipo de Arquivo</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-file-archive-o"></i>
                              </div>
                              <select class="form-control select2" name="tipo">
                    <option value='1' selected=selected>Ehi</option>
                    <option value='2'>Apk</option>
                    <option value='3'>Outros</option>
                     </select>
                              </div>
                              </div>
                            </div>
                          </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Tipo de Cliente</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-users"></i>
                              </div>
                               <select class="form-control select2" name="tipocliente">
                    <option value='1' selected=selected>Todos</option>
                    <option value='2'>Revenda</option>
                    <option value='3'>Vpn</option>
                     </select>
                              </div>
                              </div>
                            </div>
                          </div>

                             <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Descrição</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-comment-o"></i>
                              </div>
                             <input type="text" name="msg" id="msg" class="form-control"  placeholder="Digite uma descrição..." required>

                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Arquivo</label>
                              <div class="append-icon">
                              <div class="input-group">

                              <input type="file" name="arquivo">

                              <p class="help-block">Caracteres permitidos : (_19az) Não utilize especiais</p>

                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Apagar</label>
                              <div class="append-icon">
                              <div class="input-group">
                             <button type="submit" class="btn btn-lg btn-primary" onclick="deletatudo();">Apagar Todos Downloads</button>

                              </div>
                              </div>
                            </div>
                          </div>





   </div>
<div class="text-center  m-t-20 box-footer">
                    <button type="submit" name="enviandoarquivos" class="btn btn-embossed btn-primary">Salvar Registro</button>
                          <button type="reset" class="cancel btn btn-embossed btn-default m-b-10 m-r-0">Limpar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



            </div>
               </div>
                  </div>

    </section>



      <section class="content">
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">


            <div class="box-header">
              <h3 class="box-title">Downloads/Ferramentas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tipo</th>
                  <th>Cliente</th>
                  <th>Operadora</th>
                  <th>Data Postado</th>
                  <th>Arquivo Pasta</th>
                  <th>Detalhes</th>
                  <th>Apagar</th>
                </tr>
                </thead>
                <tbody>

  	      <?php
                 $SQLSubSSH = "SELECT * FROM arquivo_download ORDER BY id desc";
                 $SQLSubSSH = $conn->prepare($SQLSubSSH);
                 $SQLSubSSH->execute();
                 if(($SQLSubSSH->rowCount()) > 0){
                 while($row = $SQLSubSSH->fetch()){

                 $dataatual=$row['data'];
                 $dataconv = substr($dataatual, 0, 10);

                 $partes = explode("-", $dataconv);
                 $ano = $partes[0];
                 $mes = $partes[1];
                 $dia = $partes[2];
                 ?>
                <tr>
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo ucfirst($row['tipo']);?></td>
                  <td><?php echo ucfirst($row['cliente_tipo']);?></td>
                  <td><?php echo ucfirst($row['operadora']);?></td>
                  <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                  <td><?php echo $row['nome_arquivo'];?></td>
                  <td><?php echo $row['detalhes'];?></td>
                  <td><a href="pages/download/excluir.php?id=<?php echo $row['id'];?>" class="btn btn-block btn-danger">Excluir</a></td>


                  <?php
                }

                  }


                  ?>
                  </tr>



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



