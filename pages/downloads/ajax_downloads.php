<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/tooltipsy.min.js"></script>
<script type="text/javascript">
$('.descricao').tooltipsy({
    offset: [0, 10],
    css: {
        'padding': '10px',
        'max-width': '200px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none'
    }
});
</script>
<?php
require_once('../../pages/system/seguranca.php');
require_once('../../pages/system/config.php');
require_once('../../pages/system/funcoes.php');
require_once('../../pages/system/classe.ssh.php');

protegePagina("user");

if(isset($_GET['tipo'])){$tipo=$_GET['tipo'];
}else{$tipo=1;
}

switch($tipo){
case 0:$tip='todos';break;case 1:$tip='ehi';break;
case 2:$tip='apk';break;
case 3:$tip='outros';break;
default:$tip='todos';break;
}

$SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
$SQLUsuario = $conn->prepare($SQLUsuario);
$SQLUsuario->execute();
$usuario = $SQLUsuario->fetch();

if($tip=='todos'){$SQLSubSSH = "SELECT * FROM arquivo_download where cliente_tipo='".$usuario['tipo']."' or cliente_tipo='todos'  ORDER BY id desc";
}else{$SQLSubSSH = "SELECT * FROM arquivo_download where cliente_tipo='".$usuario['tipo']."' or cliente_tipo='todos' and tipo='".$tip."'  ORDER BY id desc";
}


                 $SQLSubSSH = $conn->prepare($SQLSubSSH);
                 $SQLSubSSH->execute();

                 if(($SQLSubSSH->rowCount()) > 0){
                 while($row = $SQLSubSSH->fetch()){


                 $dataatual=$row['data'];
                 $dataconv = substr($dataatual, 0, 10);

                 $partes = explode("-", $dataconv);
                 $ano = $partes[0];
                 $mes = $partes[1];
                 $dia = $partes[2];

                 switch($row['operadora']){
                 case 'vivo':$bg='bg-blue';break;
                 case 'claro':$bg='bg-red';break;
                 case 'tim':$bg='bg-black';break;
                 case 'oi':$bg='bg-orange';break;
                 default:$bg='bg-teal';break;
                 }

                 switch($row['tipo']){
                 case 'ehi':$ion='ion ion-android-document';break;
                 case 'apk':$ion='ion ion-social-android';break;
                 case 'outros':$ion='ion-shuffle';break;
                 default:$ion='ion-shuffle';break;
                 }

                 ?>
               <div class="col-lg-3 col-xs-6 descricao" title="<?php echo $row['detalhes'];?>">
          <!-- small box -->
          <div class="small-box <?php echo $bg;?>">
            <div class="inner">
              <h3><?php echo $row['nome'];?></h3>

             <?php if($row['status']=='funcionando'){?>
             <span class="label label-success">Funcionando</span>
             <?php }elseif($row['status']=='testes'){ ?>
             <span class="label label-warning">Em Testes</span>
             <?php } ?>
            </div>
            <div class="icon">
              <i class="<?php echo $ion;?>"></i>
            </div>
            <a href="pages/downloads/baixar.php?id=<?php echo $row['id'];?>" class="small-box-footer">
              Fazer Download <i class="fa fa-arrow-circle-down"></i>
            </a>
          </div>
        </div>


                 <!--
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo ucfirst($row['tipo']);?></td>
                  <td><?php echo ucfirst($row['operadora']);?></td>
                  <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                  <td><?php echo $row['detalhes'];?></td>
                  <td><a href="pages/downloads/baixar.php?id=<?php echo $row['id'];?>" class="btn btn-primary">Baixar</a></td>
                -->

                  <?php
                }

                  }else{ ?>                 <center><small>Infelizmente nada foi encontrado !</small></center>
                 <?php }


                  ?>
