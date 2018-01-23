<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
			$(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
<section class="content-header">
      <h1>
        Chamados
        <small>Abrir um Chamados</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li class="active">Chamados</li>
         <li class="active">Abrir</li>
      </ol>
       </section>
<section class="content">
      <div class="row">

        <div class="col-lg-12">
        <div class="callout callout-info lead">
          <h4><i class="fa fa-info"></i> Abrir Chamado!</h4>
          <p>Ao Abrir um chamado você deverá esperar de 24 a 48 horas pela resposta do administrador pois precisamos investigar o problema!.</p>
        </div>
              <p class="m-t-10 m-b-20 f-16">Informe o motivo abaixo pelo Ticket de Suporte</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-ticket"></i> Chamado de Suporte</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form name="abrirchamado" action="pages/chamados/abrindo_chamado.php" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Tipo de Problema</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-exclamation-triangle"></i>
                              </div>
                              <select size="1" class="form-control select2" name="tipo" required>
                              <option value="1">Problema na SSH</option>
                              <?php if($usuario['tipo']=='revenda'){?>
                              <option value="2">Problema na Revenda</option>
                              <?php } ?>
                              <option value="3">Problema no Usuário</option>
                              <option value="4">Problema Em Servidor</option>
                              <option value="5">Outros/Faturas Problemas</option>
                               </select>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Login/Servidor/ContaSSH</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                                <input type="text" class="form-control" name="login" minlength="4" placeholder="Digite o Login ou o Servidor com Problemas" required>
                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Motivo</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                              </div>
                              <input type="text" name="motivo" placeholder="Fale qual é o motivo Principal..." minlength="5" class="form-control" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Qual o Problema?</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-question-circle"></i>
                              </div>
                              <textarea class="form-control" name="problema" placeholder="Fale mais sobre oquê está acontecento..." rows=3 cols=20 wrap="off" required></textarea>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>
                            </div>



<div class="text-center  m-t-20 box-footer">
                    <button type="submit" class="btn btn-embossed btn-primary">Salvar Registro</button>
                          <button type="reset" class="cancel btn btn-embossed btn-default m-b-10 m-r-0">Limpar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>



            </div>
               </div>
                  </div>



      </div>
      <!-- /.row -->
    </section>