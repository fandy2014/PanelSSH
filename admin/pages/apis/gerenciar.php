<?php


	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

            $SQLmp = "select * from mercadopago";
            $SQLmp = $conn->prepare($SQLmp);
            $SQLmp->execute();
            $mp=$SQLmp->fetch();


if(isset($_GET['delinfo'])){
         $SQLinfo = "select * from informativo";
         $SQLinfo = $conn->prepare($SQLinfo);
         $SQLinfo->execute();

         if($SQLinfo->rowCount()>0){

         $info=$SQLinfo->fetch();


         if(unlink("../admin/pages/noticias/".$info['imagem']."")){
         $SQLinfo2 = "delete from informativo";
         $SQLinfo2 = $conn->prepare($SQLinfo2);
         $SQLinfo2->execute();

         echo '<script type="text/javascript">';
		 echo 	'alert("Informativo apagado!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }else{
         echo '<script type="text/javascript">';
		 echo 	'alert("houve algum erro durante o apagamento!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';

         }





         }else{

         echo '<script type="text/javascript">';
		 echo 	'alert("Não foi encontrado nenhum informativo!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';

         }



}

// desativa a noticia ativada
if(isset($_GET['delnoti'])){
         $id=$_GET['delnoti'];
         $SQLnoticia = "select * from noticias where id='".$id."'";
         $SQLnoticia = $conn->prepare($SQLnoticia);
         $SQLnoticia->execute();

         if($SQLnoticia->rowCount()>0){

         $not=$SQLnoticia->fetch();

         if($not['status']<>'ativo'){         echo '<script type="text/javascript">';
		 echo 	'alert("Noticia já está desativada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';
         exit;
         }


         $SQLinfo2 = "update noticias set status='desativado' where id='".$id."'";
         $SQLinfo2 = $conn->prepare($SQLinfo2);
         $SQLinfo2->execute();

         echo '<script type="text/javascript">';
		 echo 	'alert("Noticia Desativada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }else{

         echo '<script type="text/javascript">';
		 echo 	'alert("Nenhuma noticia encontrada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }





   }


?>

<!-- Main content -->
 <section class="content-header">
      <h1>
        Gerenciar APIS
        <small>Mercado Pago, PHP Mailer Entre outros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Api</li>
      </ol>
    </section>
<!-- Seção -->
<section class="content">
 <div class="row">
  <div class="col-md-12">
        <!-- left column -->
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Autenticação Mercado Pago</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/apis/atualizamp.php" method="post" onsubmit="return confirm('Tem certeza que deseja atualizar a autenticação (pode parar de funcionar)?');">
              <div class="box-body">




                <div class="form-group">
                  <label for="exampleInputPassword1">ID De Cliente</label>
                   <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                  <input required="required" value="<?php echo $mp['CLIENT_ID'];?>" class="form-control" id="clientid" name="clientid" placeholder="Digite o Seu Client_ID!">
                </div>
                   </div>
                    <p>Obtenha os dados: <a href="https://www.mercadopago.com.br/developers/pt/api-docs/basics/authentication/" target="_Blank">Clique Aqui</a> !</p>
                     </div>
				 <div class="form-group">
                  <label for="exampleInputPassword1">Token Secreto</label>
                    <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-key"></i>
                              </div>
                  <input required="required" value="<?php echo $mp['CLIENT_SECRET'];?>" class="form-control" id="clientsecret" name="clientsecret" placeholder="Digite o Seu CLIENT_SECRET">

                </div>
                </div>
                </div>
                <hr>
                <p>Funcional em: (Faturas,SSHPAGA,SSHREVENDA)</p>






              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Alterar</button>
				<br>

              </div>

            </form>
          </div>
          <!-- /.box -->






        </div>

            <!-- left column -->
        <div class="col-md-7">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Gerenciar Email do Sistema</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-footer" align="center">
                <a href="home.php?page=email/enviaremail" class="btn btn-primary">Clique aqui para Gerenciar o PHP Mailer</a>
				<hr>
				<p>Funcional em: (Recuperar Senha,Enviar Email,Contato)</p>

              </div>

          </div>
          <!-- /.box -->

 <?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();
?>

            <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Noticiar Na DashBoard</h3></center>
            </div>
            <!-- /.box-header -->
              <!-- form start -->
            <form role="form" action="pages/apis/addnoti.php" method="post" onsubmit="return confirm('Tem certeza que deseja fazer isso');" enctype="multipart/form-data" >
              <div class="box-body">
              <div class="form-group">
                   <label for="exampleInputPassword1">Titulo</label>
                    <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-comment"></i>
                              </div>
                  <input required="required" class="form-control" name="titu" placeholder="Titulo da noticia">
                </div>
                </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Subtitulo</label>
                    <div class="append-icon">
                               <div class="input-group">
                              <div class="input-group-addon">
                              <i class="fa fa-comment-o"></i>
                              </div>
                  <input required="required" class="form-control" name="subtitu" placeholder="Exemplo: Varias novas atualizações são aplicadas!">
                </div>
                </div>
                </div>
              <div class="form-group">
                  <label>Area da Noticia</label>
                  <textarea class="form-control" rows="10" name="msg" placeholder="Digite ... Use <br> para quebra de linhas"></textarea>
                </div>
              </div>
            <!-- form start -->

              <div class="box-footer" align="center">
                 <button type="submit" name="adicionanoticia" class="btn btn-primary pull-left">Adicionar</button></form><?php if($procnoticias->rowCount()>0){ $noticia=$procnoticias->fetch(); ?>
                 <a href="home.php?page=apis/gerenciar&delnoti=<?php echo $noticia['id'];?>" name="remove" class="btn btn-danger pull-right">Desativar</a>
                  <?php } ?>
				<br><br />
				<?php if($procnoticias->rowCount()>0){ ?>
				<p class="bg-green">Existe uma Noticia Ativa</p>
				<?php } ?>
				<p>Funcional em: (Home Clientes)</p>

              </div>

          </div>
          <!-- /.box -->

         </div>

      </div>
</section>
