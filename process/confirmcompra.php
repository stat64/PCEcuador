<?php
session_start(); 

include '../library/configServer.php';
include '../library/consulSQL.php';
$num=$_POST['clien-number'];
if($num=='notlog'){
   $nameClien=$_POST['clien-name'];
   $passClien=  md5($_POST['clien-pass']); 
}
if($num=='log'){
   $nameClien=$_POST['clien-name'];
   $passClien=$_POST['clien-pass']; 
}
sleep(3);

$verdata=  ejecutarSQL::consultar("select * from usuario where pass_usu='".$passClien."' and email_usu='".$nameClien."'");
$num=  mysql_num_rows($verdata);
if($num>0){
  if($_SESSION['sumaTotal']>0){


  $data= mysql_fetch_array($verdata);
  $id_usu=$data['id_usu'];
  $StatusV="Pendiente";
  
  /*Insertando datos en tabla venta*/
  consultasSQL::InsertSQL("venta","fecha_ven, id_usu, descu_ven, total_ven, Estado", "'".date('d-m-Y')."','".$id_usu."','0','".$_SESSION['sumaTotal']."','".$StatusV."'");
  
  /*recuperando el número del pedido actual*/
  $verId=ejecutarSQL::consultar("select * from venta where id_usu='$id_usu' order by n_pedido_ven desc limit 1");

  /*obteniendo cantidad e id*/
      function limpiarArray($array){
          $retorno=null;
          if($array!=null){
              $retorno[0]=$array[0];
          }
          for($i=1;$i<count($array);$i++){
              $repetido=false;
              $elemento=$array[$i];
              for($j=0;$j<count($retorno) && !$repetido;$j++){
                  if($elemento==$retorno[$j]){
                      $repetido=true;
                  }
              }
              if(!$repetido){
                  $retorno[]=$elemento;
              }
          }
          return $retorno;
      }
      $new=limpiarArray($_SESSION['producto']);
      function encontrar($id){
          $c=0;
          foreach ($_SESSION['producto'] as $item) {
              if($id==$item){
                  $c++;
              }
          }


          return $c;
      }
  /*fin obteniendo*/


  while($fila=mysql_fetch_array($verId)){
     $Numpedido=$fila['n_pedido_ven'];
  }
  
  /*Insertando datos en detalle de la venta*/
  for($i = 0;$i< count($new);$i++){
      consultasSQL::InsertSQL("detalle", "n_pedido_ven, id_pro, cantidad_det", "'$Numpedido', '".$new[$i]."', '".encontrar($new[$i])."'");

      /*Restando un stock a cada producto seleccionado en el carrito*/
    $prodStock=ejecutarSQL::consultar("select * from producto where id_pro='".$new[$i]."'");
    while($fila = mysql_fetch_array($prodStock)) {
        $existencias = $fila['stock_pro'];
        consultasSQL::UpdateSQL("producto", "stock_pro=('$existencias'-".encontrar($fila['id_pro']).")", "id_pro='".$new[$i]."'");
    }
  }
    
    /*Vaciando el carrito*/
    unset($_SESSION['producto']);
    unset($_SESSION['contador']);
    unset($new);
    echo '<img src="assets/img/ok.png" class="center-all-contens"><br>El pedido se ha realizado con éxito';
    echo "<script> location.href='detallescompra.php'; </script>";

  }else{
    echo '<img src="assets/img/error.png" class="center-all-contens"><br>No has seleccionado ningún producto, revisa el carrito de compras';
  }

}else{
    echo '<img src="assets/img/error.png" class="center-all-contens"><br>El nombre o contraseña invalidos';
}
 


