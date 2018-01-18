<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(3);
$nameCateg= $_POST['categ-name'];
$descripCateg= $_POST['categ-descrip'];


if(!$nameCateg=="" && !$descripCateg==""){
    $verificar=  ejecutarSQL::consultar("select * from categoria where nombre_cat='".$nameCateg."'");
    $verificaltotal = mysql_num_rows($verificar);
    if($verificaltotal<=0){
        if(consultasSQL::InsertSQL("categoria", "nombre_cat, desc_cat", "'$nameCateg','$descripCateg'")){
            echo '<img src="assets/img/correcto.png" class="center-all-contens"><br><p class="lead text-center">Categoría añadida éxitosamente</p>
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
        echo '<img src="assets/img/incorrecto.png" class="center-all-contens"><br><p class="lead text-center">El nombre que ha ingresado ya existe.<br>Por favor ingrese otro</p>';
    }
}else {
    echo '<img src="assets/img/incorrecto.png" class="center-all-contens"><br><p class="lead text-center">Error los campos no deben de estar vacíos</p>';
}

