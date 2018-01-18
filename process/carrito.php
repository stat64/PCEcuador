<?php
error_reporting(E_PARSE);
include '../library/configServer.php';
include '../library/consulSQL.php';
session_start();
$suma = 0;

if(isset($_GET['precio'])){
    $_SESSION['producto'][$_SESSION['contador']] = $_GET['precio'];

    $_SESSION['contador']++;



}
function limpiarArray($array){
    $retorno=null;
    if($array!=null){
        $retorno[0]=$array[0];
    }
    for($i=1;$i<count($array);$i++){
        $repetido=false;
        $elemento=$array[$i];
        for($j=0;$j<count($retorno) && !$repetido;$j++){
            if($elemento==$retorno[$j]){
                $repetido=true;
            }
        }
        if(!$repetido){
            $retorno[]=$elemento;
        }
    }
    return $retorno;
}
$new=limpiarArray($_SESSION['producto']);
function encontrar($id){
    $c=0;
    foreach ($_SESSION['producto'] as $item) {
        if($id==$item){
            $c++;
        }
    }
    return $c;
}

echo '<br><table class="table table-bordered">';
echo "<tr><td>Cant.</td><td>Desc.</td><td>Prec.</td></tr>";
if(count($new)==0){
    echo "<tr><td>&emsp;</td><td></td><td></td></tr>";

}
for($i = 0;$i< count($new);$i++){
        $consulta=ejecutarSQL::consultar("select * from producto where id_pro='".$new[$i]."' order by id_pro");
    while($fila = mysql_fetch_array($consulta)) {
            $pu=$fila['precio_pro']*encontrar($fila['id_pro']);
            echo "<tr><td>".encontrar($fila['id_pro'])."</td><td>".$fila['desc_pro']."</td><td> $".number_format($pu,2)."</td></td></tr>";
    $suma += $pu;
    }
}


echo "<tr><td style='border-top: inherit; border-bottom: hidden; border-left: hidden'></td> <td>Subtotal</td><td>$".number_format($suma,2)."</td></tr>";
echo "</table>";
$_SESSION['sumaTotal']=$suma;