<?php

function contador_inc()
{
    $archivo = "contador.txt"; //el archivo que contiene en numero
    $f = fopen($archivo, "r"); //abrimos el archivo en modo de lectura
    if($f)
    {
        $contador = fread($f, filesize($archivo)); //leemos el archivo
        $contador = $contador + 1; //sumamos +1 al contador
        fclose($f);
    }
    $f = fopen($archivo, "w+");
    if($f)
    {
        fwrite($f, $contador);
        fclose($f);
    }
    return $contador;
}
function contador()
{
    $archivo = "contador.txt"; //el archivo que contiene en numero
    $f = fopen($archivo, "r"); //abrimos el archivo en modo de lectura
    if($f)
    {
        $contador = fread($f, filesize($archivo)); //leemos el archivo
        fclose($f);
    }
    return $contador;
}
?>