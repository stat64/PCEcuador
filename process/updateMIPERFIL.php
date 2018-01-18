<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);

$nom=$_POST['user-nom'];
$ape=$_POST['user-ape'];
$tel=$_POST['user-tel'];
$email=$_POST['user-email'];
$idUsu=$_POST['user-code-old'];

if(consultasSQL::UpdateSQL("usuario","nombres_usu='$nom',apellidos_usu='$ape',telefono_usu='$tel',email_usu='$email'", "id_usu='$idUsu'")){
    echo '
       <br>
    <img class="center-all-contens" src="assets/img/Check.png">
    <p><strong>Hecho</strong></p>
    <p class="text-center">
        Se cerrara la sesión<br>
        en 3 segundos
    </p>
    <script>
        setTimeout(function(){
            
        url ="process/logout.php";
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