<?php
    session_start();
    include '../library/configServer.php';
    include '../library/consulSQL.php';
    sleep(2);
    $nombre=$_POST['nombre-login'];
    $clave=md5($_POST['clave-login']);
    if(!$nombre==""&&!$clave==""){
        $verUser=ejecutarSQL::consultar("select * from usuario where email_usu='$nombre' and pass_usu='$clave'");
        $verUserHay=ejecutarSQL::consultar("select count(*) as num from usuario where email_usu='$nombre' and pass_usu='$clave'");
        while($User=mysql_fetch_array($verUser)) {


            if ($User['tipo_usu'] == 1) {
                $_SESSION['nombreAdmin'] = $nombre;
                $_SESSION['claveAdmin'] = $clave;
                echo "<script> location.href='index.php'; </script>";
            } elseif ($User['tipo_usu'] == 2) {
                $_SESSION['nombreUser'] = $nombre;
                $_SESSION['claveUser'] = $clave;
                echo "<script> location.href='index.php'; </script>";
            } else {
                echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error nombre o contraseña invalido';
            }


        }
        while($Userh=mysql_fetch_array($verUserHay)) {


            if ($Userh['num'] == 0) {
                echo '<img src="assets/img/error.png" class="center-all-constens"><br>Error nombre o contraseña invalido';
            }


        }

    }else{
        echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error campo vacío<br>Intente nuevamente';
    }