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
if($conta==0){echo '<script type="text/javascript">';
		echo 	'alert("Fatura não encontrada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}
$fatu=$SQLUPUser->fetch();

                       //Datas

                     $datacriado=$fatu['data'];
					 $dataconvcriado = substr($datacriado, 0, 10);
					 $partes = explode("-", $dataconvcriado);
                     $ano = $partes[0];
                     $mes = $partes[1];
                     $dia = $partes[2];

                     $datavenc=$fatu['datavencimento'];
					 $datanv = substr($datavenc, 0, 10);
					 $partes2 = explode("-", $datanv);
                     $anov = $partes2[0];
                     $mesv = $partes2[1];
                     $diav = $partes2[2];

// Busca usuario
$user= "SELECT * FROM usuario where id_usuario='".$fatu['usuario_id']."'";
$user = $conn->prepare($user);
$user->execute();
$usufatu=$user->fetch();

// busca servidor

$server= "SELECT * FROM servidor where id_servidor='".$fatu['servidor_id']."'";
$server = $conn->prepare($server);
$server->execute();
$servidor=$server->fetch();

// busca conta
if($fatu['tipo']=='vpn'){
$acc= "SELECT * FROM usuario_ssh where id_usuario_ssh='".$fatu['conta_id']."'";
$acc = $conn->prepare($acc);
$acc->execute();
$conta=$acc->fetch();

}

//valores
$desconto1=$fatu['desconto'];
$desconto=number_format($fatu['desconto'], 2, ',', '.');
$valor=number_format($fatu['valor'], 2, ',', '.');
$total=ceil(($fatu['valor']*$fatu['qtd'])-$desconto1);
$valorfinal=$fatu['valor'];
$total=number_format($total, 2, ',', '.');


switch($fatu['tipo']){
					  case 'vpn':$tipo='Acesso VPN';break;
					  case 'revenda':$tipo='Revenda';break;
					  default:$tipo='Outros';break;
	                  }

}else{
	    echo '<script type="text/javascript">';
		echo 	'alert("Fatura Inexistente!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
        exit;
}

// Sistema dos botões
if(isset($_GET['act'])){
switch($_GET['act']){case '1':$vai='comfirma';break;
case '2':$vai='cancela';break;
case '3':$vai='deleta';break;
default:$vai='erro';break;
}

if($vai=='erro'){        echo '<script type="text/javascript">';
		echo 	'alert("Erro na comfirmação!");';
		echo	'window.location="home.php?page=faturas/verfatura&id='.$fatu['id'].'";';
		echo '</script>';
        exit;
}elseif($vai=='comfirma'){//confirmando fatura
$verifica= "SELECT * FROM fatura where id='".$fatura_id."'";
$verifica = $conn->prepare($verifica);
$verifica->execute();
$verificado=$verifica->fetch();

if($verificado['status']<>'pendente'){        echo '<script type="text/javascript">';
		echo 	'alert("Essa fatura não pode ser aceita!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
        exit;
}
//Verifica se tem comprovante
$verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
$verificacp = $conn->prepare($verificacp);
$verificacp->execute();
$cpconta=$verificacp->rowCount();
if($cpconta>0){$comprovante=$verifica->fetch();
$mudacp= "UPDATE fatura_comprovantes set status='fechado' where fatura_id='".$fatura_id."'";
$mudacp = $conn->prepare($mudacp);
$mudacp->execute();
}
//fim


//modifica fatura
$modificafatura= "UPDATE fatura SET status='pago' where id='".$fatura_id."'";
$modificafatura = $conn->prepare($modificafatura);
$modificafatura->execute();
//insere notificacao
$usuarion=$fatu['usuario_id'];
$data=date('Y-m-d H:i:s');
$msg="A Fatura <b><small>#".$fatu['id']."</small></b> foi aprovada com sucesso!";
$notificacao= "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem) values ('".$usuarion."','".$data."','fatura','faturas/pagas','".$msg."')";
$notificacao = $conn->prepare($notificacao);
$notificacao->execute();

        echo '<script type="text/javascript">';
		echo 	'alert("Fatura Aprovada com sucesso!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}elseif($vai=='cancela'){
//Cancelando
$verifica= "SELECT * FROM fatura where id='".$fatura_id."'";
$verifica = $conn->prepare($verifica);
$verifica->execute();
$verificado=$verifica->fetch();

if($verificado['status']<>'pendente'){
        echo '<script type="text/javascript">';
		echo 	'alert("Essa fatura não pode ser cancelada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
        exit;
}
//Verifica se tem comprovante
$verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
$verificacp = $conn->prepare($verificacp);
$verificacp->execute();
$cpconta=$verificacp->rowCount();
if($cpconta>0){
$comprovante=$verifica->fetch();
$mudacp= "UPDATE fatura_comprovantes set status='fechado' where fatura_id='".$fatura_id."'";
$mudacp = $conn->prepare($mudacp);
$mudacp->execute();
}
//fim
//modifica fatura
$modificafatura= "UPDATE fatura SET status='cancelado' where id='".$fatura_id."'";
$modificafatura = $conn->prepare($modificafatura);
$modificafatura->execute();
//insere notificacao
$usuarion=$fatu['usuario_id'];
$data=date('Y-m-d H:i:s');
$msg="A Fatura <small><b>#".$fatu['id']."</b></small> foi cancelada!";
$notificacao= "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem) values ('".$usuarion."','".$data."','fatura','faturas/canceladas','".$msg."')";
$notificacao = $conn->prepare($notificacao);
$notificacao->execute();

        echo '<script type="text/javascript">';
		echo 	'alert("Fatura Cancelada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}elseif($vai=='deleta'){

//Verifica se tem comprovante
$verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
$verificacp = $conn->prepare($verificacp);
$verificacp->execute();
$cpconta=$verificacp->rowCount();
if($cpconta>0){
$comprovante=$verificacp->fetch();
$arquivo = "../../painelssh/admin/pages/faturas/comprovantes/".$comprovante['imagem']."";
if (!unlink($arquivo)){       echo '<script type="text/javascript">';
		echo 	'alert("Arquivo não encontrado!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
		exit;

}else{
//Deleta
$modificafatura= "DELETE FROM fatura where id='".$fatura_id."'";
$modificafatura = $conn->prepare($modificafatura);
$modificafatura->execute();
$mudacp= "DELETE FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
$mudacp = $conn->prepare($mudacp);
$mudacp->execute();
        echo '<script type="text/javascript">';
		echo 	'alert("Fatura Deletada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
}
}else{
//fim
//Deleta
$modificafatura= "DELETE FROM fatura where id='".$fatura_id."'";
$modificafatura = $conn->prepare($modificafatura);
$modificafatura->execute();

 echo '<script type="text/javascript">';
		echo 	'alert("Fatura Deletada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}

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
        <li><a href="#">Faturas Abertas</a></li>
        <li class="active">Ver</li>
      </ol>
    </section>

    <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Nota:</h4>
        Esta página foi aprimorada para impressão. Clique no botão de impressão na parte inferior da fatura para testar.
      </div>
    </div>

    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Pservers, Inc.
            <small class="pull-right">Data: <?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          De
          <address>
            <strong>Pservers, Inc.</strong><br>
            Salvador, Bahia<br>
            Telefone: (71) 99205-8007<br>
            Email: suportepservers@gmail.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Para
          <address>
            <strong><?php echo $usufatu['nome'];?></strong><br>
            ND, Não definido<br>
            Telefone: <?php echo formataTelefone($usufatu['celular']);?><br>
            Email: <?php echo $usufatu['email'];?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Fatura #<?php echo $fatu['id']; ?></b><br>
          <br>
         <!-- <b>Order ID:</b> 4F3S8J<br> -->
          <b>Vencimento:</b>  <?php echo $diav;?>/<?php echo $mesv;?>/<?php echo $anov;?><br>
          <b>Servidor:</b> <?php echo $servidor['ip_servidor'];?> (<?php echo $servidor['nome'];?>)
          <?php if($fatu['tipo']=='vpn'){ ?>
          <br /><b>Conta:</b> <?php echo $conta['login'];?>
          <?php } ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qtd</th>
              <th>Produto</th>
              <th>Tipo</th>
              <th>Descrição</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><?php echo $fatu['qtd'];?></td>
              <td>Contas SSH</td>
              <td><?php echo $tipo;?></td>
              <td><?php echo $fatu['descrição'];?></td>
              <td>R$<?php echo $total;?></td>
            </tr>
             </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Formas de Pagamento:</p>
          <img src="../../painelssh/dist/img/credit/visa.png" alt="Visa">
          <img src="../../painelssh/dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../painelssh/dist/img/credit/american-express.png" alt="American Express">
          <img src="../../painelssh/dist/img/credit/hipercard.png" alt="Hipercard">
          <img src="../../painelssh/dist/img/credit/caixa.png" alt="Caixa">
          <img src="../../painelssh/dist/img/credit/mp.png" alt="Mercado Pago">
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
           Aceitamos Depósito e Transfêrencia Bancaria na Conta Abaixo:<br />
           Conta: 8002-5 AG:3617 OP:013 Nome: Carlos Rios e enviar a confirmação com a print do comprovante.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Vencimento da Fatura <?php echo $diav;?>/<?php echo $mesv;?>/<?php echo $anov;?></p>

          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Subtotal:</th>
                <td>R$<?php echo $total;?></td>
              </tr>
              <tr>
                <th>Taxas:</th>
                <td>R$0,00</td>
              </tr>
              <tr>
                <th>Desconto:</th>
                <td>R$<?php echo $desconto;?></td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>R$<?php echo $total;?></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a onclick="window.print();"  class="btn btn-default"><i class="fa fa-print"></i> Print</a>

<script type="text/javascript">
function excluir_fatura(){
decisao = confirm("Tem certeza que vai excluir?!");
if (decisao){
   window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=3'
} else {

}


}
</script>
          <button type="button" onclick="excluir_fatura()" class="btn btn-success pull-right"><i class="fa fa-trash-o"></i> Excluir
          </button>
          <?php if($fatu['status']=='pendente'){ ?>
          <button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=1'" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Confirmar
          </button>
          <button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=2'" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-times-circle"></i> Cancelar
          </button>
          <?php }elseif($fatu['status']=='pago'){ ?>
          <h3 class="pull-right" style="margin-right: 5px;">Fatura Paga</h3>
          <?php }elseif($fatu['status']=='cancelado'){ ?>
          <h4 class="pull-right" style="margin-right: 5px;">Fatura Cancelada</h4>
          <?php } ?>
        </div>
      </div>
    </section>