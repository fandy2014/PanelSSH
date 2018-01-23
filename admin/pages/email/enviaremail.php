<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

$buscasmtp = "SELECT * FROM smtp WHERE usuario_id='".$_SESSION['usuarioID']."'";
$buscasmtp = $conn->prepare($buscasmtp);
$buscasmtp->execute();
$smtp = $buscasmtp->fetch();

$conta=$buscasmtp->rowCount();

?>
<script language="JavaScript">
<!--
function desabilitar(){
with(document.form){
qtd_ssh.disabled=true;
}
}
function habilitar(){
with(document.form){

qtd_ssh.disabled=false;

}
}
// -->
</script>
<section class="content-header">
      <h1>
        Email
        <small>Envie email para os clientes</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-dashboard"></i>Inicio</a></li>
         <li class="active">Email</li>
      </ol>
       </section>
<section class="content">
      <div class="row">


        <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Envie um E-mail Personalizado</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-envelope-o"></i> Enviar Emails</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/email/enviandoemail.php" method="POST" role="form">
                        <div class="row">


                         <div class="col-sm-6">
                            <div class="form-group">
                           <!-- <p>
                        <label>Usuario teste</label><br>
                        <input name="teste" type="checkbox" value="">
                        </p>-->
                              <label class="control-label">Tipo de Contato</label>
                              <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info"></i>
                              </div>
                                <select class="form-control select2" name="tipomodelo">
                    <option value="1">Suporte Tecnico</option>
                    <option value="2">Entrega de Contas</option>
                  </select>
                              </div>
                              </div>
                               <p class=help-block">Selecione o Tipo de contato com seu cliente (modelo diferente)</p>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Tipo de Conta</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                              </div>
                                <select class="form-control select2" name="tipoconta">
                    <option value="1" selected=selected>Conta SSH</option>
                    <option value="2">Acesso Painel V5</option>
                  </select>

                              </div>
                              </div>
                                <p class=help-block">Somente para Entrega de Contas</p>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Email do Destinatario</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                              </div>
                              <input required="required" type="text" class="form-control" name="email" placeholder="Completo ou Selecione o Servidor ao lado">
  <div class="input-group-btn">
    <select class="btn btn-default dropdown-toggle" name="servidoremail" data-toggle="dropdown" aria-expanded="false">
       <option value="1" selected=selected>Eu Decido</a></option>
       <option value="2">@Gmail.com</a></option>
       <option value="3">@Outlook.com</a></option>
       <option value="4">@Hotmail.com</a></option>
       <option value="5">@Yahoo.com.br</a></option>
    </select>
  </div><!-- /btn-group -->
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
                              <i class="fa fa-sign-in"></i>
                              </div>
                              <input type="text" class="form-control" id="login" name="login" placeholder="Digite o Login">
                              </div>
                              </div>
                              <p class=help-block">Opcional no Suporte Técnico</p>
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
                              <input class="form-control" id="senha" name="senha" placeholder="Digite a Senha">
                              </div>
                              </div>
                              <p class=help-block">Opcional no Suporte Técnico</p>
                            </div>
                          </div>

                             <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Link de Acesso (<small>ou ip conexão</small>)</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-desktop"></i>
                              </div>
                               <input class="form-control" id="link" name="link" placeholder="Ip ou endereço">
                              </div>
                              </div>
                              <p class=help-block">Opcional no Suporte Técnico</p>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Assunto</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-desktop"></i>
                              </div>
                               <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Digite um Assunto EX: Compra de SSH ">
                              </div>
                              </div>
                              <p class=help-block">Opcional na Entrega de Contas</p>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Validade</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                              </div>
                               <input type="text" class="form-control" id="validade" name="validade" placeholder="30">
                              </div>
                              </div>
                              <p class=help-block">Opcional no Suporte Técnico</p>
                            </div>
                          </div>

                              <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Mensagem</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-comment-o"></i>
                              </div>
                              <textarea class="form-control" name="msg" id="msg" rows="3" placeholder="Digite a Mensagem ..."></textarea>
                              </div>
                              </div>
                             <p class=help-block">Opcional na Entrega de Contas</p>
                            </div>
                          </div>
                            <?php if($conta>0){ ?>
                            <div class="col-sm-6">
                            <div class="form-group">
                            <a href="home.php?page=email/1etapasmtp" class="cancel btn btn btn-embossed btn-default m-b-10 m-r-0">Reconfigurar SMTP</a>
                            </div>
                            </div>
                            <?php } ?>
                         </div>







<div class="text-center  m-t-20 box-footer">
                  <?php if($conta>0){ ?>   <button type="submit" class="btn btn-embossed btn-primary">Salvar Registro</button> <?php }else{ ?><a class="btn btn-embossed btn-warning" href="home.php?page=email/1etapasmtp">1° Configurar SMTP</a><?php } ?>
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