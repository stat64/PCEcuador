<!--====================================
     Designer and developers
 -Ismael López Mejía: Developer
 -Luis Alfredo Hernández: Developer
 -Carlos Eduardo Alfaro: Designer
 -Obed Alvarado: Developer 
************CopyRight 2014 - 2016****************
=======================================-->

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos</title>
    <?php include './inc/link.php'; ?>
</head>
<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="infoproduct">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>Tienda - <small class="tittles-pages-logo"><?php echo $n;?></small></h1>
                </div>
                <?php
                $CodigoProducto=$_GET['CodigoProd'];
                    $productoinfo=  ejecutarSQL::consultar("select * from producto, usuario where producto.id_usu=usuario.id_usu and producto.id_pro='".$CodigoProducto."'");
                    while($fila=mysql_fetch_array($productoinfo)){
                      # <h4><strong>Vendedor: </strong>'.$fila['nombres_usu'].' '.$fila['apellidos_usu'].'</h4><br>  
                      echo '
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="text-center">Información de producto</h3>
                                <br><br>
                                <h4><strong>Nombre: </strong>'.$fila['desc_pro'].'</h4><br>
                                <h4><strong>Publicado: </strong>'.$fila['fecha_ing'].'</h4><br>
                                                                
                                <h4><strong>Disponibles: </strong>'.$fila['stock_pro'].'</h4><br>
                                <h4><strong>Precio: </strong>$'.$fila['precio_pro'].'</h4>

                            </div>
                            <br><br><br>
                            <div class="thumbnail col-xs-12 col-sm-6">
                                
                                <img class="img-rounded" alt="Cinque Terre" src="assets/img-products/'.$fila['Imagen'].'">
                            </div>
                            
                            <div class="col-xs-12 text-center">
                                <br><br>
                                <a href="product.php" class="btn btn-lg btn-primary"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;Regresar a la tienda</a> &nbsp;&nbsp;&nbsp; 
                                <button value="'.$fila['id_pro'].'" class="btn btn-lg btn-success botonCarrito"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>