<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

$sqlan= "select * from anuncios";
$sqlan = $conn->prepare($sqlan);
$sqlan->execute();

$anunc=$sqlan->fetch();



?>

<!-- Main content -->
 <section class="content-header">
      <h1>
        Publicidade
        <small>Edita e Adiciona codigos de Anuncios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Gerenciar APis</li>
        <li class="active">Anúncios</li>
      </ol>
    </section>

<div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Nota:</h4>
       Copie o Código do anúncio completo no site do Google Adsense ou outros onde não pega responsivo não recomendamos colocar responsivo e sim o tamanho ideal.
      </div>
    </div>

<section class="content">
<div class="row">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">SSH Gratis 1</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/apis/atualizaanuncios.php" method="post">
              <div class="box-body">



                <input name="anuncio" type="hidden" value="1">
                <div class="form-group">
                  <label for="exampleInputPassword1">Codígo do Anuncio</label>
                  <textarea class="form-control" name="codanuncio" rows="3" placeholder="Cole o codigo ..."><?php echo $anunc['anuncio1'];?></textarea>
                </div>
                <hr>
                <p>Posição: SSHRegiões 2, SSHFree 2 e Criar SSH Cima e Baixo 2.</p>
                <p>Todos o mesmo Codigo Responsivo.</p>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
				<br>

              </div>

            </form>
          </div>
          <!-- /.box -->
          </div>

           <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">SSH Gratis 2</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/apis/atualizaanuncios.php" method="post">
              <div class="box-body">



                <input name="anuncio" type="hidden" value="2">
                <div class="form-group">
                  <label for="exampleInputPassword1">Codígo do Anuncio</label>
                  <textarea class="form-control" name="codanuncio"  rows="3" placeholder="Cole o codigo ..."><?php echo $anunc['anuncio2'];?></textarea>
                </div>
                <hr>
                <p>Posição: SSH FREE (Criar SSH).</p>
                <p>Tamanho: 300x325</p>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
				<br>

              </div>

            </form>
          </div>
          <!-- /.box -->
          </div>






</div>
</section>