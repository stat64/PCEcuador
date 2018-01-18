<?php
    include './process/securityPanelUsu.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin</title>
    <?php include_once ('./inc/link.php'); ?>
    <script type="text/javascript" src="./js/admin.js"></script>
</head>
<body id="container-page-configAdmin">
    <?php include_once ('./inc/navbar.php'); ?>
    <section id="prove-product-cat-config">
        <div class="container">
            <div class="page-header">
              <h1>Panel de administración - <small class="tittles-pages-logo"><?php echo $n;?></small></h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#Pedidos" role="tab" data-toggle="tab">Pedidos</a></li>
              <li role="presentation"><a href="#Abiertos" role="tab" data-toggle="tab">Pedidos Abiertos</a></li>
              <li role="presentation"><a href="#Cerrados" role="tab" data-toggle="tab">Pedidos Cerrados</a></li>

            </ul>
            <div class="tab-content">
                <!--==============================Panel pedidos===============================-->
                <div role="tabpanel" class="tab-pane fade in active" id="Pedidos">
                    <div class="row">
                        <div class="col-xs-12">
                            <br><br>
                             <div class="panel panel-info">
                               <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Estado de las Compras</h3></div>
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead class="">
                                          <tr>
                                              <th class="text-center">#</th>
                                              <th class="text-center">Fecha</th>
                                              <th class="text-center">Descuento</th>
                                              <th class="text-center">Total</th>
                                              <th class="text-center">Estado</th>
                                              <th class="text-center">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $pedidoU=  ejecutarSQL::consultar("select * from venta, usuario WHERE venta.id_usu=usuario.id_usu and usuario.email_usu='".$_SESSION['nombreUser']."'");
                                            $upp=1;
                                            while($peU=mysql_fetch_array($pedidoU)){
                                                echo '
                                                    <div id="update-pedido">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'</td>
                                                            <td hidden><input type="text" name="num-pedido" value="'.$peU['n_pedido_ven'].'"</td>
                                                            <td>'.$peU['fecha_ven'].'
                                                            </td>
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>'.$peU['Estado'].'</td>
                                                            <td class="text-center">
                                                            <a href="detalleUsu.php?det='.$peU['n_pedido_ven'].'" class="btn btn-sm btn-primary button-UPPE">
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Detalle
                                                            </a>
                                                            </td>
                                                        </tr>
                                                    </div>
                                                    ';
                                                $upp=$upp+1;
                                            }
                                          ?>
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--==============================Panel pedidos abiertos===============================-->
                <div role="tabpanel" class="tab-pane fade" id="Abiertos">
                    <div class="row">
                        <div class="col-xs-12">
                            <br><br>
                            <div class="panel panel-info">
                                <div class="panel-heading text-center"><i class="fa fa-eye fa-2x"></i><h3>Detalle de Pedidos Abiertos</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Descuento</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center" colspan="2">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $pedidoU=  ejecutarSQL::consultar("select * from venta, usuario WHERE venta.id_usu=usuario.id_usu and usuario.email_usu='".$_SESSION['nombreUser']."' and Estado='Pendiente'");
                                        $upp=1;
                                        while($peU=mysql_fetch_array($pedidoU)){
                                            echo '
                                                    <div id="update-pedido">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'<input type="hidden" name="num-pedido" value="'.$peU['n_pedido_ven'].'"></td>
                                                            <td>'.$peU['fecha_ven'].'</td>
                                                  
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>'.$peU['Estado'].'
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                            <a href="detalleUsu.php?det='.$peU['n_pedido_ven'].'" class="btn btn-sm btn-primary button-UPPE">
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Detalle
                                                            </a>
                                                            </td>

                                                        </tr>
                                                      </div>
                                                    ';
                                            $upp=$upp+1;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--==============================Panel pedidos abiertos===============================-->
                <div role="tabpanel" class="tab-pane fade" id="Cerrados">
                    <div class="row">
                        <div class="col-xs-12">
                            <br><br>
                            <div class="panel panel-info">
                                <div class="panel-heading text-center"><i class="fa fa-check fa-2x"></i><h3>Detalle de Pedidos Entregados</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Descuento</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center" colspan="2">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $pedidoU=  ejecutarSQL::consultar("select * from venta, usuario WHERE venta.id_usu=usuario.id_usu and usuario.email_usu='".$_SESSION['nombreUser']."' and Estado='Entregado'");
                                        $upp=1;
                                        while($peU=mysql_fetch_array($pedidoU)){
                                            echo '
                                                    <div id="update-pedido">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'<input type="hidden" name="num-pedido" value="'.$peU['n_pedido_ven'].'"></td>
                                                            <td>'.$peU['fecha_ven'].'</td>
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>
                                                            '.$peU['Estado'].'
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                            <a href="detalleUsu.php?det='.$peU['n_pedido_ven'].'" class="btn btn-sm btn-primary button-UPPE">
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Detalle
                                                            </a>
                                                            </td>
                                                      
                                                        </tr>
                                                      
                                                    </div>
                                                    ';
                                            $upp=$upp+1;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>