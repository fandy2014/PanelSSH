<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
require_once("../../../pages/system/classe.ssh.php");

protegePagina("admin");


if(isset($_POST['anuncio'])){
$diretorio="../../home.php?page=apis/anuncios";
$codigo=$_POST['codanuncio'];
switch($_POST['anuncio']){
case 1:$atualiza=1;break;
case 2:$atualiza=2;break;
case 3:$atualiza=3;break;
case 4:$atualiza=4;break;
case 5:$atualiza=5;break;
case 6:$atualiza=6;break;
default:$atualiza=0;break;
}

if($atualiza==0){
echo '<script type="text/javascript">';
		       echo 	'alert("Anuncio inexistente!");';
		       echo	'window.location="'.$diretorio.'";';
		       echo '</script>';
		       exit;

}


if($atualiza==1){

$sqlbusca= "update anuncios set anuncio1='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();
echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}elseif($atualiza==2){

$sqlbusca= "update anuncios set anuncio2='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();

echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}elseif($atualiza==3){

$sqlbusca= "update anuncios set anuncio3='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();

echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}elseif($atualiza==4){

$sqlbusca= "update anuncios set anuncio4='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();

echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}elseif($atualiza==5){

$sqlbusca= "update anuncios set anuncio5='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();

echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}elseif($atualiza==6){

$sqlbusca= "update anuncios set anuncio6='".$codigo."'";
$sqlbusca = $conn->prepare($sqlbusca);
$sqlbusca->execute();

echo '<script type="text/javascript">';
echo 'alert("Anúncio Atualizado!");';
echo	'window.location="'.$diretorio.'";';
echo '</script>';


}




}

?>