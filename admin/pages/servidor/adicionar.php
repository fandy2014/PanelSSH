<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../plugins/show-password/bootstrap-show-password.min.js"></script>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Servidor
        <small>Adicionar Servidor ao Sistema</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servidores</li>
        <li class="active">Adicionar</li>
      </ol>
    </section>

<section class="content">
<script>
function ValidateIPaddress(inputText)
 {
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
 if(inputText.value.match(ipformat))
 {
 document.form1.ip.focus();
 return true;
 }
 else
 {
 alert("Endereço IP Invalido!");
 document.form1.ip.focus();<br>return false;
 }
 }
</script>
      <div class="row">

 <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os Dados do Servidor</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-server"></i> Adicionar Servidor ao Sistema</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form action="pages/servidor/adicionar_exe.php" method="POST" role="form">
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
                              <i class="fa fa-keyboard-o"></i>
                              </div>
                                <input type="text" id="nomesrv" name="nomesrv" class="form-control" minlength="4" placeholder="Digite o Nome do Servidor ..." required>
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                         <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Endereço de IP</label>
                              <div class="append-icon">
                                <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-map-marker"></i>
                              </div>
                                <input type="text" name="ip" id="ip" class="form-control" minlength="4" placeholder="Digite o IP do seu Servidor..." required="">
                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Login Root</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-sign-in"></i>
                              </div>
                              <input type="text" name="login" id="login" value="root" class="form-control" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>



                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Senha Root</label>
                              <div class="append-icon">
                                  <div class="input-group">
    <div class="input-group-addon">
      <i class="fa fa-key"></i>
    </div>
                                 <input type="password" min="6" max="32" class="form-control"  name="senha"
							  data-minlength="6" id="senha"  data-toggle="password" placeholder="Digite a Senha" required>
                              </div>
                            </div>
                          </div>


                        </div>


    <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Região Global</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-globe"></i>
                              </div>
                             <select class="form-control select2" name="regiao" required>
                    <option value='1'>Asia</option>
                    <option value='2'>America</option>
                    <option value='3'>Europa</option>
                    <option value='4'>Australia</option>
                    </select>
                              </div>
                              </div>
                            </div>
                          </div>




 <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Localização</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-map-o"></i>
                              </div>
                              <input type="text" name="localiza" id="localiza" placeholder="São Paulo" class="form-control" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Hostname</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-info-circle"></i>
                              </div>
                              <input type="text" name="siteserver" id="siteserver" placeholder="us.seusite.com" class="form-control" required>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
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
                              <input type="number" name="validade" id="validade" placeholder="1" class="form-control" required>
                              </div>
                              </div>
                            </div>
                          </div>

                             <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Limite</label>
                              <div class="append-icon">
                              <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-ticket"></i>
                              </div>
                              <input type="number" name="limite" id="limite" placeholder="1" class="form-control" required>
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
                              <i class="fa fa-info"></i>
                              </div>
                  <?php if($administrador['site']<>''){?>
                  <input required="required" type="text" class="form-control" id="sitevps" name="sitevps" value="<?php echo $administrador['site'];?>" disabled>
                  <?php }else{ ?>
                  <input required="required" type="text" class="form-control" id="sitevps" name="sitevps" value="seusite.com ou o ip">
                  <?php } ?>
                              </div>
                              </div>
                            </div>
                          </div>




<p>

                         <center>
<p>Tipo do Servidor</P>
<div class="radiosanimados">
<eae class="radiosbordas descricao"  title="Servidor Premium:<br /><small>- Só quem está no Painel tem Acesso<br />- Deve Criar Div em SSHPaga e Revenda<br />- Usuarios Online</small>"><input id="radio1" type="radio" name="tiposerver" value="premium" checked><label for="radio1"><span><span></span></span>Premium </eae></label>
<eae class="radiosbordas descricao" title="Servidor Free:<br /><small>- Desabilitado em PainelV5</small><br /> <small>- Usuarios Criam automatico<br />- Pode Gerenciar as Contas FREE<br />- Usuarios Online</small>"><input disabled id="radio2" type="radio" name="tiposerver" value="free"><label for="radio2"><span><span></span></span>Free</eae></label>
</div>
<p>Tipo de Instalação</P>
<div class="radiosanimados">
<eae class="radiosbordas descricao" title="Instala VPSManager Automaticamente<br />Debian 8/Ubuntu 16<br /><small>*Após instalar Screen sshlimiter<br />*OpenVPN Manual<br />*Configure o Site do Painel <b>Antes</b></small>" ><input id="radio3" type="radio" name="tipo" value="full"><label for="radio3"><span><span></span></span>Full Install </eae></label>
<eae class="radiosbordas descricao" title="Atualiza os Scripts <br />*<small>Apenas Envia os Arquivos para Pasta Root<br />*Efetua o CHMOD 777 E +X</small>"><input id="radio4" type="radio" name="tipo" value="nada" checked><label for="radio4"><span><span></span></span>Apenas Atualiza</eae></label>
</div>


                           </center>
                             <p></p>




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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/tooltipsy.min.js"></script>
<script type="text/javascript">
$('.descricao').tooltipsy({
    offset: [0, 10],
    css: {
        'padding': '10px',
        'max-width': '200px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none'
    }
});
</script>