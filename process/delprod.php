<?php
 include '../library/configServer.php';
 include '../library/consulSQL.php';

 sleep(3);
 
 $codeProd= $_POST['prod-code'];
 $cons=  ejecutarSQL::consultar("select * from producto where id_pro='$codeProd'");
 $totalproductos = mysql_num_rows($cons);
 $tmp=  mysql_fetch_array($cons);
 $imagen=$tmp['Imagen'];
 if($totalproductos>0){
    if(consultasSQL::DeleteSQL('producto', "id_pro='".$codeProd."'")){
        $carpeta='../assets/img-products/';
        $directorio=$carpeta.$imagen;
        chmod($directorio, 0777);
        unlink($directorio);
        echo '<img src="assets/img/correcto.png" class="center-all-contens"><br><p class="lead text-center">El producto se elimino de la tienda con éxito</p>
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
     echo '<img src="assets/img/incorrecto.png" class="center-all-contens"><br><p class="lead text-center">El código del producto no existe</p>';
 }