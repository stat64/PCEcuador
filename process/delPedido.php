<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);
$NumPedidoDel= $_POST['num-pedido'];
$consP=  ejecutarSQL::consultar("select * from venta where n_pedido_ven='$NumPedidoDel'");
$totalP= mysql_num_rows($consP);

if($totalP>0){
    if(consultasSQL::DeleteSQL('venta', "n_pedido_ven='".$NumPedidoDel."'")){
        consultasSQL::DeleteSQL("detalle", "n_pedido_ven='".$NumPedidoDel."'");
        echo '<img src="assets/img/correcto.png" class="center-all-contens"><br><p class="lead text-center">Pedido eliminado éxitosamente</p>
        <p class="text-center">
        Recargando<br>
        en 3 segundos
        </p>
        <script>
        setTimeout(function(){
            url ="configAdmin.php";
            $(location).attr("href",url);
        },3000);
    </script>';
    }else{
       echo '<img src="assets/img/incorrecto.png" class="center-all-contens"><br><p class="lead text-center">Ha ocurrido un error.<br>Por favor intente nuevamente</p>'; 
    }
}else{
    echo '<img src="assets/img/incorrecto.png" class="center-all-contens"><br><p class="lead text-center">El pedido no existe</p>';
}
