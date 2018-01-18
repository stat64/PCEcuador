<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);

$passoldinsert=md5($_POST['user-pass-old-insert']);
$passnew=md5($_POST['user-pass-new-insert']);
$passrnew=md5($_POST['user-pass-new-r-insert']);
$idUsu=$_POST['user-code-old'];
$verUser=ejecutarSQL::consultar("select COUNT(*) as num from usuario where id_usu='$idUsu' and pass_usu='$passoldinsert'");
$usu=mysql_fetch_array($verUser);
if($passnew!=$passrnew){
    echo '
    <br>
    <img class="center-all-contens" src="assets/img/cancel.png">
    <p><strong>Error</strong></p>
    <p class="text-center">
        El Password<br> 
        no coincide.
    </p>
    ';
}

elseif($usu['num']==0){


        echo '
    <br>
    <img class="center-all-contens" src="assets/img/cancel.png">
    <p><strong>Error</strong></p>
    <p class="text-center">
        El Password<br> 
        anterior es incorrecto.
        
    </p>
    ';
}

elseif(consultasSQL::UpdateSQL("usuario","pass_usu='$passrnew'", "id_usu='$idUsu' and pass_usu='$passoldinsert'")){
    echo '
       <br>
    <img class="center-all-contens" src="assets/img/Check.png">
    <p><strong>Hecho</strong></p>
    <p class="text-center">
        Se actualizado<br>
        El password Recargando <br>
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

 ';
}