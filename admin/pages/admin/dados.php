<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<section class="content-header">
      <h1>
        Configurações
        <small>Configure seus dados de acesso</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li class="active">Configurações</li>
      </ol>
       </section>
<section class="content">
      <div class="row">

        <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os novos dados administrativos</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-pencil"></i> Alterar Informações</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/admin/alterar.php" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Nome</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-hashtag"></i>
                              </div>
                                <input type="text" name="nome" id="nome" class="form-control" minlength="4"  value="<?php echo $administrador['nome'];?>" required>
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Login</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                                <input type="text" disabled class="form-control" minlength="4" value="<?php echo $administrador['login'];?>" required="">
                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Email</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                              </div>
                              <input type="text" name="email" id="email" minlength="5" class="form-control" value="<?php echo $administrador['email'];?>" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Site do Painel</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-internet-explorer"></i>
                              </div>
                              <input type="text" name="site" id="site" minlength="5" value="<?php echo $administrador['site'];?>" class="form-control" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Senha Antiga</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                              <input type="password" name="senhaantiga" id="senhaantiga" minlength="5" placeholder="Digite a Senha Antiga..." class="form-control">
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                             <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Nova Senha</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                              <input type="password" name="novasenha" id="novasenha" minlength="5" placeholder="Digite a Nova Senha..." class="form-control">
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