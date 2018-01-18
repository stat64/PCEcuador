<?php
    include './process/securityPanel.php';
    $v1 =$_GET['det'];
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle</title>
    <?php include_once ('./inc/link.php');
    ?>
    <script type="text/javascript" src="./js/admin.js"></script>
</head>
<body id="container-page-configAdmin">
    <?php include_once ('./inc/navbar.php'); ?>

    <section id="prove-product-cat-config">

        <div class="container">
            <div class="page-header">
              <h1>Detalle de la compra - <small class="tittles-pages-logo"><?php echo $n;?></small></h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation">
                  <a href="configAdmin.php" data-toggle="tab"> Atras</a>

              </li>
                <li role="presentation" class="active"><a href="#Pedido" role="tab" data-toggle="tab">Pedido# <?php echo $v1;?></a></li>

            </ul>
            <div class="tab-content">
                <!--==============================Panel DETALLES DE LA COMPRA===============================-->
                <div role="tabpanel" class="tab-pane fade in active" id="Pedido">
                    <div class="row">

                        <div class="col-xs-12">
                            <br>
                            <div class="table-responsive">
                                <?php
                                $productos=  ejecutarSQL::consultar("SELECT * FROM `venta` WHERE n_pedido_ven=$v1");
                                $prod=mysql_fetch_array($productos);
                                echo '
                                <br>
                                <p class="text-left">&emsp;<b>Fecha:</b> '.$prod['fecha_ven'].'</p>
                                ';?>
                            </div>
                            <br>
                            <div class="panel panel-info">

                                <div class="table-responsive" id="add-product">
                                <?php
                                $categoriac=  ejecutarSQL::consultar("SELECT * FROM `venta`, usuario WHERE venta.id_usu=usuario.id_usu and venta.n_pedido_ven=$v1");
                                while($catec=mysql_fetch_array($categoriac)) {
                                    echo '
                                <div class="panel-heading text-center"></i><h4>Datos del cliente</h4></div>

                              <div class="form-group">
                                <label>Nombres</label>
                                <input type="text" readonly class="form-control" value="'.$catec['nombres_usu'].' '.$catec['apellidos_usu'].'">
                              </div>

                              <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" readonly class="form-control"  value="'.$catec['dir_usu'].'">
                              </div>
                              <div class="form-group">
                                <label>Correo</label>
                                <input type="text" readonly class="form-control"  value="'.$catec['email_usu'].'">
                              </div>
                              
                              <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" readonly class="form-control"  value="'.$catec['telefono_usu'].'">
                              </div>
                              ';
                                }
                                ?>

                            </div>
                        </div>
                                <div class="panel-heading text-center"><h3>Detalle</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">Unidades</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Categoría</th>
                                            <th class="text-center">Precio</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $productos=  ejecutarSQL::consultar("SELECT producto.desc_pro,categoria.nombre_cat,producto.precio_pro, `cantidad_det` FROM `detalle`,producto,categoria WHERE producto.id_pro=detalle.id_pro and categoria.id_cat=producto.id_cat and n_pedido_ven=$v1");
                                        $upr=1;
                                        while($prod=mysql_fetch_array($productos)){
                                          $t=$prod['precio_pro']*$prod['cantidad_det'];  
                                          echo '
                                                <div id="update-product">
                                                    <tr>
                                                        <td><input readonly class="form-control" type="text-area" name="stock-prod" maxlength="30" required="" value="'.$prod['cantidad_det'].'"></td>

                                                        <td>
                                                        <input readonly class="form-control" type="hidden" name="code-old-prod" required="" value="'.$prod['id_pro'].'">
                                                        <input readonly class="form-control" type="text" name="prod-name" maxlength="30" required="" value="'.$prod['desc_pro'].'">
                                                        <input readonly class="form-control" type="hidden" name="id-usu"  required="" value="'.$prod['id_usu'].'"></td>
                                                        
                                                        <td><input readonly class="form-control" type="text-area" name="price-prod" required="" value="'.$prod['nombre_cat'].'"></td>                                                        
                                                        <td><input readonly class="form-control" type="text-area" name="price-prod" required="" value="'.$t.'"></td>
                                                        
                                                    </tr>
                                                </div>
                                                ';
                                            $upr=$upr+1;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            <br>
                            <div class="panel panel-info">
                            <div class="table-responsive">
                                <?php
                                $productos=  ejecutarSQL::consultar("SELECT * FROM `venta` WHERE n_pedido_ven=$v1");
                                $prod=mysql_fetch_array($productos);
                                echo '
                                <p class="text-right"><b>Estado:</b> '.$prod['Estado'].'</p>
                                <p class="text-right"><b>Total:</b> '.$prod['total_ven'].'</p>
                                ';?>
                                </div>
                            </div>
                            <div class="text-center"><input class="btn btn-primary" type="button" value="Imprimir"><input class="btn btn-link" type="button" value="Guardar PDF"></div>

                        </div>

            </div>
        </div>

    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>