<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);

$ciudad=$_POST['user-cit'];
$provincia=$_POST['user-prov'];
$direccion=$_POST['user-dir'];
$idUsu=$_POST['user-code-old'];

if(consultasSQL::UpdateSQL("usuario","dir_usu='$direccion',ciudad_usu='$ciudad',prov_usu='$provincia'", "id_usu='$idUsu'")){
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
        url ="configUser.php";
        $(location).attr("href",url);
        },3000);
    </script>
 ';
}else{
    echo '
    <br>
    <img class="center-all-contens" src="assets/img/cancel.png">
    <p><strong>Error</strong></p>
    <p class="text-center">
        Recargando<br>
        en 3 segundos
    </p>
    <script>
        setTimeout(function(){
        url ="configUser.php";
        $(location).attr("href",url);
        },3000);
    </script>
 ';
}