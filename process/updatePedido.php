<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);

$numPediUp=$_POST['num-pedido'];
$estadPediUp=$_POST['pedido-status'];
echo $estadPediUp;

if(consultasSQL::UpdateSQL("venta", "Estado='$estadPediUp'", "n_pedido_ven='$numPediUp'")){
    echo '
    <br>
    <img class="center-all-contens" src="assets/img/Check.png">
    <p><strong>Hecho</strong></p>
    <p class="text-center">
        Recargando<br>
        en 3 segundos
    </p>
    <script>
        setTimeout(function(){
        url ="configAdmin.php";
        $(location).attr("href",url);
        },3000);
    </script>
 ';
}
else{
    echo '
    <br>
    <img class="center-all-contens" src="assets/img/cancel.png">
    <p><strong>Error</strong></p>
    <p class="text-center">
        Recargando<br>
        en 7 segundos
    </p>
    <script>
        setTimeout(function(){
        url ="configAdmin.php";
        $(location).attr("href",url);
        },7000);
    </script>
 ';
}