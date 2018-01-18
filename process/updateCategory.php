<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(2);

$codeOldCatUp=$_POST['categ-code-old'];
$nameCatUp=$_POST['categ-name'];
$descCatUp=$_POST['categ-descrip'];

if(consultasSQL::UpdateSQL("categoria", "nombre_cat='$nameCatUp',desc_cat='$descCatUp'", "id_cat='$codeOldCatUp'")){
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
}else{
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

