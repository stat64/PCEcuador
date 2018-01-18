 <?php
session_start();
//datos para establecer la conexion con la base de mysql.
$conexion=mysql_connect('localhost','Tu_user','Tu_password')or die ('Ha fallado la conexión: '.mysql_error());
mysql_select_db('registro')or die ('Error al seleccionar la Base de Datos: '.mysql_error());


//añadimos la funcion que se encargara de generar un numero aleatorio
function genera_random($longitud){ 
    $exp_reg="[^A-Z0-9]"; 
    return substr(eregi_replace($exp_reg, "", md5(rand())) . 
       eregi_replace($exp_reg, "", md5(rand())) . 
       eregi_replace($exp_reg, "", md5(rand())), 
       0, $longitud); 
}



// verificamos si se han enviado ya las variables necesarias, las que tenemos en nuestro form cambialo, como sea el tuyo.
if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    // Hay campos en blanco
    if($username==NULL|$password==NULL|$password2==NULL|$email==NULL) {
        echo "un campo está vacio.";
        formRegistro();
    }else{
        // ¿Coinciden las contraseñas?
        if($password!=$password2) {
            echo "Las contraseñas no coinciden";
            
        }else{
            // Comprobamos si el nombre de usuario o la cuenta de correo ya existían
            $checkuser = mysql_query("SELECT usuario FROM usuarios WHERE usuario='$username'");
            $username_exist = mysql_num_rows($checkuser);
            $checkemail = mysql_query("SELECT email FROM usuarios WHERE email='$email'");
            $email_exist = mysql_num_rows($checkemail);
            if ($email_exist>0) {
                echo "La cuenta de correo estan ya en uso";
                
        }else{
                if ($username_exist>0) {
                echo "El nombre de usuario  esta ya en uso";
                
                
                
            }else{
            
                  //agregamos la variable $activate que es un numero aleatorio de 
                  //20 digitos crado con la funcion genera_random de mas arriba
                  
                  $activate = genera_random(20);  
                  
                  //aqui es donde insertamos los nuevos valosres en la BD  activate y el valor 1 que es desactivado
                  
                $query = 'INSERT INTO usuarios (usuario, password, email, fecha, activate, estado)
                VALUES ('.$username.','.$password.','.$email.','.date("Y-m-d").','.$activate.', 1)';
                mysql_query($query) or die(mysql_error());
                
                
                
                echo "<table width=70%><tr bgcolor= #61e877 class= estilo30><div align=center>";
                echo 'Ha sido registrado en Cevit como: <b>'.$username.' </b>de manera satisfactoria.<br />';
                echo ' Gracias. Le enviaremos ahora un email<br />';
                echo 'para activar su cuenta, al correo que nos facilito.<br />';
                echo "</div></tr>";
                echo "</table>";
                
                
                
                $query   = "SELECT * FROM usuarios WHERE usuario='$username'";
         $result = mysql_query($query , $conexion) or die ( mysql_error() );
         $row   = mysql_fetch_array($result);
         
         $path="http://www.tuboolar-web.com/cevit/"; //creamos nuestra direccion, con las carpetas que sean si hay
         //armamos nuestro link para enviar por mail en la variable $activateLink
$activateLink=$path."activar_registro.php?id=".$row['id']."&activateKey=".$activate."";
                
                          // Datos del email

$nombre_origen    = "Tuboolar Web";
$email_origen     = "aaaaaaa@aa.com";
$email_copia      = "aaaaaaa@aa.com";
$email_ocultos    = "aaaaaaa@aa.com";
$email_destino    = "".$row['email']."";  



$asunto           = "".$row['usuario']." Datos de registro en Cevit, guarde este email.";

$mensaje          = '<table width="629" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="623" align="left"></td>
  </tr>
  <tr>
    <td bgcolor="#2EA354"><div style="color:#FFFFFF; font-size:14px; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;"><strong>     Estos son sus datos de registro, '.$row['usuario'].'</strong></div></td>
  </tr>
  <tr>
    <td height="95" align="left" valign="top"><div style=" color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;"> USUARIO: '.$row['usuario'].'</strong><br><br><br>
          <strong>SU CLAVE : </strong>'.$row['password'].'</strong><br><br><br>
          <strong>SU EMAIL : </strong>'.$row['email'].'</strong><br><br><br>
          <strong>SU LINK DE ACTIVACION:<br><a href="'.$activateLink.'">'.$activateLink.' </strong></a><br><br><br>
          <strong>POR FAVOR HAGA CLICK EN LINK DE ARRIBA PARA ACTIVAR SU CUENRA Y ACCEDER A LA PAGINA SIN RESTRICCIONES</strong><br><br><br>
          <strong>SI EL LINK NO FUNCIONA ALA PRIMERA INTENTELO UNA SEGUNDA, EL SERVIDOR A VECES TARDA EN PROCESAR LA PRIMERA ORDEN</strong><br><br><br>
          
          <strong>GRACIAS POR REGISTRARSE EN CEVIT.</strong><br><br><br>
    </div>
    </td>
  </tr>
</table>';



$formato          = "html";

//*****************************************************************//
$headers  = "From: $nombre_origen <$email_origen> \r\n";
$headers .= "Return-Path: <$email_origen> \r\n";
$headers .= "Reply-To: $email_origen \r\n";


$headers .= "X-Sender: $email_origen \r\n";

$headers .= "X-Priority: 3 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$headers .= "Content-Transfer-Encoding: 7bit \r\n";

//*****************************************************************//
 
if($formato == "html")
 { $headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  }
   else
    { $headers .= "Content-Type: text/plain; charset=iso-8859-1 \r\n";  }

@mail($email_destino, $asunto, $mensaje, $headers);
    
     
                
                
                
                
                
                }
            }
        }
    }
}else{
    
}

?> 