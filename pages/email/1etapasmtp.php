<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

$buscasmtp = "SELECT * FROM smtp_usuarios WHERE usuario_id='".$_SESSION['usuarioID']."'";
$buscasmtp = $conn->prepare($buscasmtp);
$buscasmtp->execute();
$smtp = $buscasmtp->fetch();

$conta=$buscasmtp->rowCount();

?>
<section class="content-header">
      <h1>
        SMTP 1 Etapa
        <small>Configure os dados do Servidor  de Email</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li class="active"><a href="home.php?page=email/enviaremail">Email</a></li>
         <li class="active">Smtp</li>
      </ol>
       </section>
<section class="content">
      <div class="row">

        <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os novos dados do seu servidor de email</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-pencil"></i> Alterar Informações</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/email/configurasmtp.php" method="POST" role="form">
                        <div class="row">

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Nome de Sua Empresa</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info"></i>
                              </div>
                             <input required="required" type="text" value="<?php echo $smtp['empresa'];?>" class="form-control" id="nomeempresa" name="nomeempresa" placeholder="Ex: Rei dos SSH">

                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Servidor</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-server"></i>
                              </div>
                               <input required="required" type="text" value="<?php echo $smtp['servidor'];?>" class="form-control" id="servidor" name="servidor" placeholder="Ex: smtp.gmail.com">
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Porta</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-check"></i>
                              </div>
                               <input required="required" type="text" value="<?php echo $smtp['porta'];?>" class="form-control" id="porta" name="porta" placeholder="Ex: 465">
                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">SSL</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-cog"></i>
                              </div>
                              <input required="required" type="text" value="<?php echo $smtp['ssl_secure'];?>" class="form-control" id="ssl" name="ssl" placeholder="Ex: ssl ou tls">
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
                              <input required="required" type="text" value="<?php echo $smtp['email'];?>" class="form-control" id="email" name="email" placeholder="Email do servidor">
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Senha</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                              <input  class="form-control" type="password" value ="<?php echo $smtp['senha'];?>" id="senha" name="senha" placeholder="Senha do Email">
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