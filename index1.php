<?php
$retval='
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    ';
    require_once ('inc/link.php');
    $retval.='
    <title>Document</title>
</head>
<body>'.contacto().'

        

</body>
</html>
';
echo $retval;
function contacto(){
    conecta();
    $sql = "SELECT `id_usu`,dir_face_usu,telefono_usu,negocio_usu,desc_neg_usu,telefono_usu, `nombres_usu`, `pass_usu`, `tipo_usu`, `email_usu`, `apellidos_usu` FROM `usuario` WHERE `tipo_usu`=3";
    $res = mysql_query($sql);
    $ret='';
    $c=0;
    while($item = mysql_fetch_array($res)){
        if ($c%3==0){
            $ret.='<div class="row">';
        }
        $ret.='<div class="col s12 m4">
          <div class="card">
            <div class="card-image">
              <img src="img/full_logo.jpg">
              <span class="card-title">PCE</span>
            </div>
            <div class="card-content">
              <p><b>Nombre:</b> <span>'.$item['nombres_usu'].' '.$item['apellidos_usu'].'</span></p>
              <p><b>Negocio:</b> <span>'.$item['negocio_usu'].'</span></p>
              <p><b>Te ofrece:</b> '.$item['desc_neg_usu'].'</p>
              <p><b>Telefono:</b> <span>'.$item['telefono_usu'].'</span></p>
              
              
            </div>
            <div class="card-action ">
              <a href="'.$item['dir_face_usu'].'" class="blue-grey-text">Facebook>></a>
            </div>
          </div>
        </div>';
        if ($c%3==0 && $c%3!=0){
            $ret.='</div>';
        }
        $c++;
    }
    $retval='
      <div class="row">
        <div class="col s12 m3">
          <div class="card">
            <div class="card-image">
              <img src="img/group.png">
              <span class="card-title">Card Title</span>
            </div>
            <div class="card-content">
              <p>I am a very simple card. I am good at containing small bits of information.
              I am convenient because I require little markup to use effectively.</p>
            </div>
            <div class="card-action">
              <a href="#">This is a link</a>
            </div>
          </div>
        </div>
      </div>
            ';

    return $ret;

}
function conecta(){
    $cn = mysql_connect("localhost","root","0502567654");
    mysql_select_db("plantascarnivorasec");
    mysql_set_charset("utf8",$cn);
}
?>