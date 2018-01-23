<?php
require_once("../system/funcoes.php");
require_once("../system/seguranca.php");
require_once("../system/config.php");


protegePagina();

	$permitir_demo = 0;
	
	    if((isset($_POST["acesso_servidor"]))   and (isset($_POST["permitir_demo"]))  and (isset($_POST["dias_demo"])) ){
			$permitir_demo = $_POST["permitir_demo"];
			
			if($permitir_demo == 1){
				 $SQLUPUser = "update usuario set permitir_demo = '".$permitir_demo."', dias_demo_sub='".$_POST["dias_demo"]."'  WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
                 $SQLUPUser = $conn->prepare($SQLUPUser);
                 $SQLUPUser->execute();
	
				 $SQLAcesso = "select * from acesso_servidor where demo='1' and id_usuario = '".$_SESSION['usuarioID']."'";
                 $SQLAcesso = $conn->prepare($SQLAcesso);
                 $SQLAcesso->execute();
				
                 if(($SQLAcesso->rowCount())>0){
					$SQLUPAcess = "update acesso_servidor set demo ='0'  WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
                    $SQLUPAcess = $conn->prepare($SQLUPAcess);
                    $SQLUPAcess->execute();
					
					$SQLUPAcess = "update acesso_servidor set demo ='1'  WHERE id_usuario = '".$_SESSION['usuarioID']."' and id_acesso_servidor='".$_POST['acesso_servidor']."' ";
                    $SQLUPAcess = $conn->prepare($SQLUPAcess);
                    $SQLUPAcess->execute();
					
                   
				 }else{
					 $SQLUPAcess = "update acesso_servidor set demo ='1'  WHERE id_usuario = '".$_SESSION['usuarioID']."' and id_acesso_servidor='".$_POST['acesso_servidor']."'  ";
                     $SQLUPAcess = $conn->prepare($SQLUPAcess);
                     $SQLUPAcess->execute();
					
				 }
				 echo '<script type="text/javascript">';
			  echo 	'alert("Conta  demo habilitada!");';
			     echo	'window.location="../../home.php?page=demo/configurar";';
			     echo '</script>';
				 
			}else{
				
                $SQLUPUser = "update usuario set permitir_demo = '".$permitir_demo."' , dias_demo_sub='".$_POST["dias_demo"]."' WHERE id_usuario = '".$_SESSION['usuarioID']."'  ";
                $SQLUPUser = $conn->prepare($SQLUPUser);
                $SQLUPUser->execute();
				
				
				$SQLUPAcess = "update acesso_servidor set demo ='0'  WHERE id_usuario = '".$_SESSION['usuarioID']."' and id_acesso_servidor='".$_POST['acesso_servidor']."' ";
                $SQLUPAcess = $conn->prepare($SQLUPAcess);
                $SQLUPAcess->execute();
				 
				 echo '<script type="text/javascript">';
			      echo 	'alert("Alterado com sucesso!");';
			     echo	'window.location="../../home.php?page=demo/configurar";';
			    echo '</script>';
			}
			
			
		}else{
			echo '<script type="text/javascript">';
			echo 	'alert("Preencha todos os campos!");';
			echo	'window.location="../../home.php?page=demo/configurar";';
			echo '</script>';
			
		}

	
	
	?>