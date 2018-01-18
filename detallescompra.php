<?php
session_start();
unset($_SESSION['producto']);
unset($_SESSION['contador']);
unset($_SESSION['sumaTotal']);
include_once('inc/link.php');
include_once('inc/navbar.php');

$retval= '
<!doctype html>
<html lang="es">
<head >
</head>
<body >
<br>
<br>
<br>
<br>
<br>
    <div class="page-header">
      <h1>
        <p align="center">
      Tienda - <small class="tittles-pages-logo"><?php echo $n;?></small>
        </p>
      </h1>
    </div>
      <h1>
        <p align="center">
      Te agradece tu compra
        </p>
      </h1>
<br>
<br>
<p align="center"><img class="img-responsive center-all-contens" align="center" src="assets/img/ok.png" class="center-all-contens"><br>
<br>
El pedido se ha realizado con éxito
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>

</html>
        
';
echo $retval;
require_once ('inc/footer.php');
?>
