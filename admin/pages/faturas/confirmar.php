<?php
	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

if(isset($_GET['id'])){
$fatura_id=$_GET['id'];


$SQLUPUser= "SELECT * FROM fatura where id='".$fatura_id."'";
$SQLUPUser = $conn->prepare($SQLUPUser);
$SQLUPUser->execute();

$conta=$SQLUPUser->rowCount();
if($conta==0){
        echo '<script type="text/javascript">';
		echo 	'alert("Fatura não encontrada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
		exit;

}
$fatu=$SQLUPUser->fetch();

if($fatu['usuario_id']<>$_SESSION['usuarioID']){
echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura não é sua!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
        exit;
}
if($fatu['status']=='cancelado'){
echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura está vencida ou expirada!");';
		echo	'window.location="home.php?page=faturas/canceladas";';
		echo '</script>';
        exit;
}
if($fatu['status']=='pago'){
echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura está paga!");';
		echo	'window.location="home.php?page=faturas/pagas";';
		echo '</script>';
		exit;

}





}

?>
<section class="content-header">
      <h1>
        Fatura N°
        <small>#<?php echo $fatu['id']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Faturas</a></li>
        <li class="active">Confirmar</li>
      </ol>
    </section>

      <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Nota:</h4>
        Anexe uma Print do Comprovante para agilizar o processo que pode levar até 24 horas para ser efetuado e você ver refletido em sua conta.
      </div>
    </div>


    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">

    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Comprovar Pagamento</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <form role="form" action="pages/faturas/confirmando.php" enctype="multipart/form-data" method="post">
              <div class="box-body">
              <div class="form-group">
                  <label>Fatura</label>
                  <input type="text" class="form-control" placeholder="#<?php echo $fatu['id'];?>" value="#<?php echo $fatu['id'];?>" disabled="">
                  <input name="fatura" value="<?php echo $fatu['id'];?>" type="hidden">
                </div>
            <div class="form-group">
                  <label>Forma de Pagamento</label>
                  <select name="formap" class="form-control">
                    <option value="1" selected=selected>Boleto</option>
                    <option value="2">Depósito/Transfência</option>
                  </select>
                </div>
              <div class="form-group">
                  <label>Deixar uma Nota</label>
                  <div class="form-group has-feedback">
                              <textarea class="form-control" name="msg" id="msg" rows="3" placeholder="Digite ... (Opcional)"></textarea>

                              <span class="glyphicon glyphicon-comment form-control-feedback"></span>
                              </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Anexo de comprovante</label>
                  <input type="file" id="arquivo" name="arquivo" required=required>

                  <p class="help-block">JPG , PNG ou GIF Tamanho Máximo 2MB.</p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Enviar</button> <button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>'"  class="btn btn-default pull-right"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Voltar</button>
              </div>
            </form>
          </div>

          </div>
          </div>
          </section>