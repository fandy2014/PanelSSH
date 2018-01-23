<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

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
$('.radiosbordas').click(function() {
  $('.hli').removeClass('hli');
  $(this).addClass('hli').find('input').prop('checked', true)
});
</script>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../plugins/select2/select2.full.min.js"></script>
<script src="../plugins/validator/validator.min.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../plugins/show-password/bootstrap-show-password.min.js"></script>
<script>
			$(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
<script>
		 $(document).ready(function ($) {
			 //$("[data-mask]").inputmask();
			 //Inputmask().mask(document.querySelectorAll("input"));

			 $('#celular').inputmask("(99) 9999[9]-9999");  //static mask
			});
		</script>
<!-- Main content -->
 <section class="content-header">
      <h1>
        Usuários
        <small>Cria um novo usuário</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuários</li>
        <li class="active">Criar</li>
      </ol>
    </section>
<section class="content">
      <div class="row">

      <div class="col-lg-12">
              <p class="m-t-10 m-b-20 f-16">Digite abaixo os dados do cliente</p>


           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Adicionar Usuário ao sistema</h3>
            </div>
          <div class="panel-body bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form data-toggle="validator" action="pages/usuario/adicionar_exe.php" method="POST" role="form">
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
                                <input type="text" name="nome" id="nome" class="form-control" minlength="4" placeholder="Digite o Nome ..." required>
                                <i class="icon-user"></i>
                              <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              </div>
                            </div>
                          </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Celular</label>
                              <div class="append-icon">
                                  <div class="input-group">
    <div class="input-group-addon">
      <i class="fa fa-phone"></i>
    </div>
                                <input type="text" name="celular" id="celular" placeholder="Digite os 11 Digítos..." class="form-control" minlength="4" maxlength="16" required>
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
                                <input type="text" name="login" id="login" class="form-control" minlength="4" placeholder="Digite o Login..." required="">
                                <i class="glyphicon glyphicon-lock form-control-feedback"></i>
                              </div>
                              <span class="help-block">Somente letras e/ou números. Mínimo 4 caracteres e no máximo 32!</span>
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
                              <input type="password" min="6" max="32" class="form-control"  name="senha"
							  data-minlength="6" id="senha"  data-toggle="password" placeholder="Digite a Senha" required>
							 </div>
							 <span class="help-block">Mínimo 6 caracteres e no máximo 32! Misture letras e números!</span>
                              </div>
                            </div>
                          </div>








                        <p>

                         <center>

<div class="radiosanimados">
<eae class="radiosbordas descricao" title="<b>Revendedor</b>:<br /><small>*Pode Vender SSH<br />*Pode Criar SubRevendedor</small>"><input id="radio1" type="radio" name="tipo" value="revenda"><label for="radio1"><span><span></span></span>Revendedor </eae></label>
<eae class="radiosbordas descricao" title="<b>Usuário VPN</b>:<br />*Acesso Comum VPN"><input id="radio2" type="radio" name="tipo" value="vpn"><label for="radio2"><span><span></span></span>Usuário VPN</eae></label>
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