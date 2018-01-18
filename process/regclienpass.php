<?php

$usuario = 'edison carrillo';
$correo = 'djsat.ec@gmail.com';
//...

//<-- Tus rutinas para validar los datos, si están completos etc...

if(empty($usuario)){
    echo "Debes poner algo como usuario";
    exit;
}

//-->

$aleatorio = uniqid(); //Genera un id único para identificar la cuenta a traves del correo.
$contrasena = rand(1999, 9999); //Devuelve un número aleatorio entre los dos rangos. Lo usuaremos como
//Contraseña temporal.

$sql = "Insert Into tabla (usuario, contrasena, correo, codigo, activo) Values ('$usuario', '$contrasena', '$correo', '$aleatorio', 0)";

//Tus rutinas para insertar en la base de datos.

$mensaje = "Registro en tuweb.com\n\n";
$mensaje .= "Estos son tus datos de registro:\n";
$mensaje .= "Usuario: $usuario.\n";
$mensaje .= "Contraseña: $contrasena.\n\n";
$mensaje .= "Debes activar tu cuenta pulsando este enlace: http://www.tuweb.com/activacion.php?id=$aleatorio";

$asunto = "Activación de tu cuenta en tuweb.com";

if(mail($correo,$asunto,$mensaje)){
    echo "Se ha enviado un mensaje a tu correo electronico con el código de activación";
}else{
    echo "Ha ocurrido un error y no se puede enviar el correo";
}

?>