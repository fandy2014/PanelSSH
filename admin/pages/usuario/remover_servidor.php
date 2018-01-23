<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
protegePagina("admin");
if( $_SESSION['tipo'] == "user"){
	expulsaVisitante();
}

	    if(isset($_GET["id_acesso"]) ) {

		    $SQLAcesso = "select * from acesso_servidor where id_acesso_servidor = '".$_GET['id_acesso']."'  ";
            $SQLAcesso = $conn->prepare($SQLAcesso);
            $SQLAcesso->execute();

			if(($SQLAcesso->rowCount()) > 0){
				   $acesso = $SQLAcesso->fetch();

					$SQLUpdateSSH = "update usuario_ssh set status='3', apagar='3', id_usuario='0' where id_servidor='".$acesso['id_servidor']."' and id_usuario='".$acesso['id_usuario']."' ";
                    $SQLUpdateSSH = $conn->prepare($SQLUpdateSSH);
                    $SQLUpdateSSH->execute();

					$SQLUserSub = "SELECT * from usuario where id_mestre = '".$acesso['id_usuario']."' ";
                    $SQLUserSub = $conn->prepare($SQLUserSub);
                    $SQLUserSub->execute();


                    if (($SQLUserSub->rowCount()) > 0) {
					        while($row = $SQLUserSub->fetch()) {

								$SQLUpdateSSH = "update usuario_ssh set id_usuario='0', status='3', apagar='3' WHERE id_servidor='".$acesso['id_servidor']."' and id_usuario = '".$acesso['id_usuario']."' ";
                                $SQLUpdateSSH = $conn->prepare($SQLUpdateSSH);
                                $SQLUpdateSSH->execute();
							}

					}

					 $SQLserver = "select * from servidor WHERE id_servidor = '".$acesso['id_servidor']."'";
                     $SQLserver = $conn->prepare($SQLserver);
                     $SQLserver->execute();
                     $server=$SQLserver->fetch();

                     // Procura os servidores de acesso
                     $SQLAcesso2 = "select * from acesso_servidor where id_servidor_mestre='".$_GET['id_acesso']."'  ";
                     $SQLAcesso2 = $conn->prepare($SQLAcesso2);
                     $SQLAcesso2->execute();


                      if (($SQLAcesso2->rowCount()) > 0) {
					  while($acesso2 = $SQLAcesso2->fetch()) {

                     $SQLUpdateSSH = "update usuario_ssh set status='3', apagar='3', id_usuario='0' where id_servidor='".$acesso2['id_servidor']."' and id_usuario='".$acesso2['id_usuario']."' ";
                     $SQLUpdateSSH = $conn->prepare($SQLUpdateSSH);
                     $SQLUpdateSSH->execute();

                     // procura usuarios dos subrevendedores
                     $SQLreset = "select * from usuario where id_mestre='".$acesso2['id_usuario']."'  ";
                     $SQLreset = $conn->prepare($SQLreset);
                     $SQLreset->execute();

                     if($SQLreset->rowCount()>0){                     while($acesso3 = $SQLreset->fetch()) {
                     $SQLUpdateSSH3 = "update usuario_ssh set status='3', apagar='3', id_usuario='0' where id_servidor='".$acesso['id_servidor']."' and id_usuario='".$acesso3['id_usuario']."' ";
                     $SQLUpdateSSH3 = $conn->prepare($SQLUpdateSSH3);
                     $SQLUpdateSSH3->execute();
                     }
                     }
                      // apaga servidor

                      $apaga= "delete from acesso_servidor where id_acesso_servidor='".$acesso2['id_acesso_servidor']."'";
                      $apaga = $conn->prepare($apaga);
                      $apaga->execute();

						}

					}







					//Insere notificacao

                    $msg="Servidor Removido <small><b>".$server['ip_servidor']."</b></small> Foi removido todos seus acessos pelo Administrador  !";
                    $notins = "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem) values ('".$acesso['id_usuario']."','".date('Y-m-d H:i:s')."','revenda','Admin','".$msg."')";
                    $notins = $conn->prepare($notins);
                    $notins->execute();





                  	echo '<script type="text/javascript">';
			        echo 	'alert("Acesso Removido!");';
			        echo	'window.location="home.php?page=usuario/listar";';
			        echo '</script>';



			}else{
					echo '<script type="text/javascript">';
			        echo 	'alert("Acesso nao encontrado!");';
			        echo	'window.location="home.php?page=usuario/listar";';
			        echo '</script>';
		    }



        }else{
					echo '<script type="text/javascript">';
			        echo 	'alert("Preencha!");';
			        echo	'window.location="home.php?page=usuario/listar";';
			        echo '</script>';

		}


	?>