<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
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
                <select class="form-control select2" style="width: 100%;"  name="servidor" id="servidor">
                  
                  <?php
    
	
   
	$SQLAcessoSRV = "SELECT * FROM servidor WHERE  demo='1' LIMIT 1";
    $SQLAcessoSRV = $conn->prepare($SQLAcessoSRV);
    $SQLAcessoSRV->execute();
   

if (($SQLAcessoSRV->rowCount()) > 0) {
    // output data of each row
   $row_srv_principal = $SQLAcessoSRV->fetch();
		
		?>
        
	<option value="<?php echo $row_srv_principal['id_servidor'];?>" > <?php echo $row_srv_principal['nome'];?> - <?php echo $row_srv_principal['ip_servidor'];?> </option>
	
   <?php 
}

	
	$SQLAcessoSRV = "SELECT * FROM servidor WHERE   demo='0' ";
    $SQLAcessoSRV = $conn->prepare($SQLAcessoSRV);
    $SQLAcessoSRV->execute();
	

if (($SQLAcessoSRV->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcessoSRV->fetch()) {
		
		?>
        
	<option value="<?php echo $row_srv['id_servidor'];?>" > <?php echo $row_srv['nome'];?> - <?php echo $row_srv['ip_servidor'];?> </option>
	
   <?php }
}

?>
				  
				  
                </select>
              </div>
			  
              
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Quantidade de dias </label>
                  <input required="required" type="number" class="form-control" id="dias_demo" name="dias_demo" placeholder="Digite a quantidade de dias " value="<?php echo $row_srv_principal['dias'];?>" >
                </div>
				
				
			  
			  
				<br>
				
                <center>  <span class="label label-primary pull-center" > 
			        <a style="text-decoration: none;color: #fff;font-size:10px;" href="<?php echo "http://".$endereco_web."/new.php?p=admin"?>" target="_blank">
					  <?php echo "http://".$endereco_web."/new.php?p=admin"?></a></span>
				</center>
				
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