<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}


   
    $SQLValidar = "SELECT * FROM acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."'";
    $SQLValidar = $conn->prepare($SQLValidar);
    $SQLValidar->execute();
   
		 
    if (($SQLValidar->rowCount()) <= 0) {
		echo '<script type="text/javascript">';
			echo 	'alert("Voce nao tem servidor!");';
			echo	'window.location="home.php";';
			echo '</script>';
			exit;
		
	}
	
	
 $permitir = "";
 $npermitir = "";
 $cadastro = "";
 $dias = $usuario['dias_demo_sub'];
 if($usuario['permitir_demo']==1){
	$permitir = "checked";
	$npermitir ="";
	$cadastro = "";
 }else if($usuario['permitir_demo']==2){
	$permitir = "";
    $npermitir = "checked";
	$cadastro = "";
 }else if($usuario['permitir_demo']==0){
	$permitir = "";
    $npermitir = "";
	$cadastro = "checked";
 }
?>
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <center><h3 class="box-title">Configurar link de demonstração</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/demo/configurar_exe.php" method="post">
              <div class="box-body">
			   
			   <div class="form-group">
                <label>Selecione servidor Default</label>
                <select class="form-control select2" style="width: 100%;"  name="acesso_servidor" id="acesso_servidor">
                  
                  <?php
    
	
   
	$SQLAcessoSRV = "SELECT * FROM acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."' and demo='1' ";
    $SQLAcessoSRV = $conn->prepare($SQLAcessoSRV);
    $SQLAcessoSRV->execute();
   

if (($SQLAcessoSRV->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcessoSRV->fetch()) {
		$result_servidor = " SELECT * FROM servidor where id_servidor = '".$row_srv['id_servidor']."'  ";
        $result_servidor = $conn->prepare($result_servidor);
        $result_servidor->execute();
        $servidor = $result_servidor->fetch();

		?>
        
	<option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> - Máximo <?php echo $row_srv['qtd'];?> contas</option>
	
   <?php }
}

	
	$SQLAcessoSRV = "SELECT * FROM acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."' and demo='0' ";
    $SQLAcessoSRV = $conn->prepare($SQLAcessoSRV);
    $SQLAcessoSRV->execute();
	

if (($SQLAcessoSRV->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcessoSRV->fetch()) {
		$result_servidor = "SELECT * FROM servidor where id_servidor = '".$row_srv['id_servidor']."'";
        $result_servidor = $conn->prepare($result_servidor);
        $result_servidor->execute();
        $servidor = $result_servidor->fetch();
		 
		
		
		?>
        
	<option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> - Máximo <?php echo $row_srv['qtd'];?> contas</option>
	
   <?php }
}

?>
				  
				  
                </select>
              </div>
			  
              
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Quantidade de dias </label>
                  <input required="required" type="number" class="form-control" id="dias_demo" name="dias_demo" placeholder="Digite a quantidade de dias " value="<?php echo $dias; ?>" >
                </div>
				
				
			  
			  <div class="form-group">
                <label>
                  <input type="radio" name="permitir_demo" id="permitir_demo" class="minimal" <?php echo $permitir;?>  value="1">
				   Permitir teste
                </label>
				<br>
				<label>
                  <input type="radio" name="permitir_demo" id="permitir_demo" class="minimal"  <?php echo $npermitir;?> value="2">
				   Não permitir teste
                </label>
				<br>
                <label>
                  <input type="radio" name="permitir_demo" id="permitir_demo" class="minimal"  <?php echo $cadastro;?> value="0">
				   Somente cadastro
                </label>
                
              </div>
			  
			  
				<br>
				
              <center>  <span class="label label-primary pull-center" > <a style="text-decoration: none;color: #fff;font-size:10px;" href="<?php echo "http://".$endereco_web."/new.php?p=".$usuario['token_user']?>" target="_blank"><?php echo "http://".$endereco_web."/new.php?p=".$usuario['token_user']?></a></span></center>
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
				<br/>
				
              </div>
			  
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>