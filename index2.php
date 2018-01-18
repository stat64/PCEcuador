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
<body>'.productoMusgo().'

        

</body>
</html>
';
echo $retval;
function productoMusgo(){
    conecta();
    $sql = "SELECT `id_pro`,fecha_ing ,`desc_pro`, `id_img_pro`, `stock_pro`, `precio_pro`, `id_usu`, `id_cat` FROM `producto` WHERE id_cat=1";
    $res = mysql_query($sql);
    $ret='';
    $c=0;
    while($item = mysql_fetch_array($res)){
        if ($c%3==0){
            $ret.='<div class="row">';
        }
        $ret.='<div class="col s12 m3">
          <div class="card">
            <div class="card-image">
              <img src="img/group.png">
              <span class="card-title">PCE</span>
            </div>
            <div class="card-content">
              <p><b>$ '.$item['precio_pro'].'</b> </p>
              <p>'.$item['fecha_ing'].'</p>
              <p><b><span>'.$item['desc_pro'].'</span></p>
              <p><b>Vendedor: <span>'.$item['id_usu'].'</span></p>
              <p><b>Disponibles:</b> <span>'.$item['stock_pro'].'</span></p>
              
              
            </div>
            <div class="card-action ">
              <a href="'.$item['id_pro'].'" class="blue-grey-text">Anadir al carrito>></a>
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