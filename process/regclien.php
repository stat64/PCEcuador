<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(3);
$fullnameCliente= $_POST['clien-fullname'];
$apeCliente= $_POST['clien-lastname'];
$passCliente= md5($_POST['clien-pass']);
$dirCliente= $_POST['clien-dir'];
$phoneCliente= $_POST['clien-phone'];
$emailCliente= $_POST['clien-email'];

if(!$apeCliente=="" && !$dirCliente=="" && !$phoneCliente=="" && !$emailCliente=="" && !$fullnameCliente==""){
    $verificar=  ejecutarSQL::consultar("select * from usuario where email_usu='".$emailCliente."'");
    $verificaltotal = mysql_num_rows($verificar);
    if($verificaltotal<=0){
        if(consultasSQL::InsertSQL("usuario", "nombres_usu,apellidos_usu,dir_usu,  pass_usu,telefono_usu, tipo_usu, email_usu",
            "'$fullnameCliente','$apeCliente','$dirCliente', '$passCliente','$phoneCliente',2,'$emailCliente'")){
            echo '<img src="assets/img/ok.png" class="center-all-contens"><br>El registro se completo con éxito';
        }else{
           echo '<img src="assets/img/error.png" class="center-all-contens"><br>Ha ocurrido un error.<br>Por favor intente nuevamente'; 
        }
    }else{
        echo '<img src="assets/img/error.png" class="center-all-contens"><br>El email que ha ingresado ya esta registrado.<br>Por favor ingrese otro número de email';
    }
}else {
    echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error los campos no deben de estar vacíos';
}


