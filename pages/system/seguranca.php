<?php
require_once("funcoes.php");
require_once('pass.php');

$_SG['conectaServidor'] = true;
// Abre uma conexÃ£o com o servidor MySQL?
$_SG['abreSessao'] = true;
// Inicia a sessÃ£o com um session_start()?
$_SG['caseSensitive'] = true;
// Usar case-sensitive?
$_SG['validaSempre'] = true;
// Deseja validar o usuÃ¡rio e a senha a cada carregamento de pÃ¡gina?

// Evita que, ao mudar os dados do usuÃ¡rio no banco de dado o mesmo contiue logado.
$_SG['servidor'] = 'localhost';
// Servidor MySQL
$_SG['usuario'] = 'root';
// UsuÃ¡rio MySQL
$_SG['senha'] = $pass;
// Senha MySQL
$_SG['banco'] = 'ssh';
// Banco de dados MySQL
$_SG['paginaLogin'] = 'login.php';
// PÃ¡gina de login
$_SG['paginaBloquear'] = 'tela-bloqueada.php';
//PÃ¡gina de Bloqueio

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {

	try {
    $conn = new PDO('mysql:host='.$_SG['servidor'].';dbname='.$_SG['banco'].';charset=utf8', $_SG['usuario'], $_SG['senha'],
	array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ));
	} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
	}


}

// ======================================
//  Anti SQL Injector
// ======================================

function sql_injector($sql)
    {
    $seg = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql); //remove palavras que          contenham a sintaxe sql
    $seg = trim($seg); //limpa espaços vazios
    $seg = strip_tags($seg); // tira tags html e php
    $seg = addslashes($seg); //adiciona barras invertidas a uma string
    return $seg;
    }

// ======================================
//  Pegar IP
// ======================================

function pega_ip() {
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress;
}


function validaUsuario($usuario, $senha,$tipo) {

  global $_SG;
  /* Inicia a sessão */
   	session_start();

  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
  // Usa a função addslashes para escapar as aspas
  $login_usuario = addslashes($usuario);
  $senha_usuario = addslashes($senha);

  if($tipo=="admin"){
	 // Monta uma consulta SQL (query) para procurar um usuário
    $sql = "SELECT * FROM admin WHERE login = '".$login_usuario."' AND senha = '".$senha_usuario."' LIMIT 1";

  }else{
	 // Monta uma consulta SQL (query) para procurar um usuário
     $sql = "SELECT * FROM usuario WHERE login = '".$login_usuario."' AND senha = '".$senha_usuario."' LIMIT 1";
  }


  global $conn;
  $sql = $conn->prepare($sql);
  $sql->execute();
  $resultado = $sql->fetch();

  // Verifica se encontrou algum registro
  if (empty($resultado)) {
    // Nenhum registro foi encontrado => o usuário é inválido
    return false;
  } else {



	if($tipo=="admin"){
	   // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioID'] = $resultado['id_administrador']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['tipo'] = 'admin';
    $_SESSION['usuarioLogin'] = $resultado['login'];
	$_SESSION['usuarioSenha'] = $resultado['senha'];

  }else{
	   // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioID'] = $resultado['id_usuario']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['usuarioLogin'] = $resultado['login'];
	$_SESSION['usuarioSenha'] = $resultado['senha'];
	$_SESSION['tipo'] = 'user'; // Pega o valor da coluna 'id do registro encontrado no MySQL

  }


    return true;
  }
}


function protegePagina($tipo) {
  global $_SG;

  /* Inicia a sessão */
   	session_start();
  if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {



    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {

		if($_SESSION['tipo']=="admin"){
	       // Verifica se os dados salvos na sessão batem com os dados do banco de dados
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'], "admin")) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }

        }else{
	         // Verifica se os dados salvos na sessão batem com os dados do banco de dados
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'], "user")) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
        }



    }
  }
}





function expulsaVisitante() {
  global $_SG;
  /* Inicia a sessão */
   	session_start();
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  // Manda pra tela de login
  header("Location: index.php");
}

function expulsaSair() {
   session_start();

   global $_SG;



  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);

	// Finally, destroy the session.
	session_destroy();

  // Manda pra tela de login
  header("Location: ../index.php");
}
?>
