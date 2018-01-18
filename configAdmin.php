<?php
    include './process/securityPanel.php';
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
                <li role="presentation" class="active"><a href="#Productos" role="tab" data-toggle="tab">Productos</a></li>

                <li role="presentation"><a href="#Categorias" role="tab" data-toggle="tab">Categorías</a></li>
                <li role="presentation"><a href="#Admins" role="tab" data-toggle="tab">Admin</a></li>
                <li role="presentation"><a href="#SitioWeb" role="tab" data-toggle="tab">SitioWeb</a></li>
                <li role="presentation"><a href="#Pedidos" role="tab" data-toggle="tab">Pedidos</a></li>
              <li role="presentation"><a href="#Abiertos" role="tab" data-toggle="tab">Pedidos Abiertos</a></li>
              <li role="presentation"><a href="#Cerrados" role="tab" data-toggle="tab">Pedidos Cerrados</a></li>

            </ul>
            <div class="tab-content">
                <!--==============================Panel productos===============================-->
                <div role="tabpanel" class="tab-pane fade in active" id="Productos">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <br><br>
                        <div id="add-product">
                            <h2 class="text-primary text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar un producto nuevo</h2>
                            <form role="form" action="process/regproduct.php" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                <label>Nombre de producto</label>
                                <input type="text" class="form-control  all-elements-tooltip"  placeholder="Nombre" required maxlength="30" name="prod-name">
                              </div>
                              <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-control" name="prod-categoria">
                                    <?php
                                        $categoriac=  ejecutarSQL::consultar("select * from categoria");
                                        while($catec=mysql_fetch_array($categoriac)){
                                            echo '<option value="'.$catec['id_cat'].'">'.$catec['nombre_cat'].'</option>';
                                        }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Precio</label>
                                <input type="number" class="form-control all-elements-tooltip" placeholder="Precio" required maxlength="20" pattern="[0-9]{1,20}" name="prod-price">
                              </div>
                              <div class="form-group">
                                <label>Unidades disponibles</label>
                                <input type="text" class="form-control all-elements-tooltip"  placeholder="Unidades" required maxlength="20" pattern="[0-9]{1,20}" name="prod-stock">
                              </div>
                              <div class="form-group">
                                <label>Imagen de producto</label>
                                <input type="file" name="img">
                                  <p class="help-block">Formato de imagenes admitido png, jpg, gif, jpeg</p>
                              </div>
                                <input type="hidden"  name="admin-name" value="<?php echo $_SESSION['nombreAdmin'] ?>">
                              <p class="text-center"><button type="submit" class="btn btn-primary">Agregar a la tienda</button></p>
                              <div id="res-form-add" style="width: 100%; text-align: center; margin: 0;"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <br><br>
                        <div id="del-prod-form">
                            <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar un producto</h2>
                             <form action="process/delprod.php" method="post" role="form">
                                 <div class="form-group">
                                     <label>Productos</label>
                                     <select class="form-control" name="prod-code">
                                         <?php
                                             $productoc=  ejecutarSQL::consultar("SELECT * FROM `producto`, usuario WHERE usuario.id_usu=producto.id_usu and usuario.email_usu='".$_SESSION['nombreAdmin']."'");
                                             while($prodc=mysql_fetch_array($productoc)){
                                                 echo '<option value="'.$prodc['id_pro'].'">'.$prodc['desc_pro'].'</option>';
                                             }
                                         ?>
                                     </select>
                                 </div>
                                 <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar</button></p>
                                 <br>
                                 <div id="res-form-del-prod" style="width: 100%; text-align: center; margin: 0;"></div>
                             </form>
                         </div>
                    </div>
                    <div class="col-xs-12">
                        <br><br>
                        <div class="panel panel-info">
                            <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar datos de producto</h3></div>
                          <div class="table-responsive">
                              <table class="table table-bordered">
                                  <thead class="">
                                      <tr>
                                          <th class="text-center">Nombre</th>
                                          <th class="text-center">Categoría</th>
                                          <th class="text-center">Foto Anterior</th>
                                          <th class="text-center">Cambiar de Foto</th>
                                          <th class="text-center">Precio</th>
                                          <th class="text-center">Unidades</th>
                                          <th class="text-center">Opciones</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        $productos=  ejecutarSQL::consultar("SELECT * FROM `producto`, usuario WHERE usuario.id_usu=producto.id_usu and usuario.email_usu='".$_SESSION['nombreAdmin']."'");
                                        $upr=1;
                                        while($prod=mysql_fetch_array($productos)){
                                            echo '
                                                <div id="update-product-'.$upr.'">
                                                  <form role="form" method="post" action="process/updateProduct.php" id="res-update-product-'.$upr.'"  enctype="multipart/form-data">
                                                    <tr>
                                                        <td>
                                                        <input class="form-control all-elements-tooltip" type="hidden" name="code-old-prod" required="" value="'.$prod['id_pro'].'">                
                                                        <input class="form-control all-elements-tooltip" type="hidden" name="prod-Prove" required="" value="'.$prod['id_usu'].'">
                                                        <input class="form-control all-elements-tooltip" type="text" name="prod-name" maxlength="30" required="" value="'.$prod['desc_pro'].'">
                                                        <input class="form-control all-elements-tooltip" type="hidden" name="id-usu"  required="" value="'.$prod['id_usu'].'"></td>
                                                        
                                                        <td>';
                                                            $categoriac3=  ejecutarSQL::consultar("select * from categoria where id_cat='".$prod['id_cat']."'");
                                                            while($catec3=mysql_fetch_array($categoriac3)){
                                                                $codeCat=$catec3['id_cat'];
                                                                $nameCat=$catec3['nombre_cat'];
                                                            }
                                                      echo '<select class="form-control" name="prod-category">';
                                                                echo '<option value="'.$codeCat.'">'.$nameCat.'</option>';
                                                                $categoriac2=  ejecutarSQL::consultar("select * from categoria");
                                                                while($catec2=mysql_fetch_array($categoriac2)){
                                                                    if($catec2['id_cat']==$codeCat){

                                                                    }else{
                                                                      echo '<option value="'.$catec2['id_cat'].'">'.$catec2['nombre_cat'].'</option>';
                                                                    }

                                                                }
                                                      echo '</select>
                                                        </td>
                                                        <td>
                                                        <img src="assets/img-products/'.$prod['Imagen'].'" width="100px" class="img-responsive">

                                                        </td>
                                                        <td>
                                                        <input id="img-product-'.$upr.'" type="file" name="img" value="Subir">
                                                        <p class="help-block">Formato de imagenes admitido png, jpg, gif, jpeg</p>
                                                        </td>
                                                        <td><input class="form-control all-elements-tooltip" type="number" name="price-prod" required="" value="'.$prod['precio_pro'].'"></td>
                                                        <td><input class="form-control all-elements-tooltip" type="text-area" name="stock-prod" maxlength="30" required="" value="'.$prod['stock_pro'].'"></td>
                                                        
                                                        <td class="text-center">
                                                            <button type="submit" class="btn btn-sm btn-primary button-UPR" value="res-update-product-'.$upr.'">Actualizar</button>
                                                            <div id="res-update-product-'.$upr.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                        </td>
                                                    </tr>
                                                  </form>
                                                </div>
                                                ';
                                            $upr=$upr+1;
                                        }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                    </div>
                </div>
                </div>
                <!--==============================Panel Categorias===============================-->
                <div role="tabpanel" class="tab-pane fade" id="Categorias">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <br><br>
                            <div id="add-categori">
                                <h2 class="text-info text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar categoría</h2>
                                <form action="process/regcategori.php" method="post" role="form">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input class="form-control all-elements-tooltip" type="text" name="categ-name" pl    aceholder="Nombre de categoria" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input class="form-control all-elements-tooltip" type="text" name="categ-descrip" placeholder="Descripcióne de categoria" required="">
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-primary">Agregar categoría</button></p>
                                    <br>
                                    <div id="res-form-add-categori" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <br><br>
                            <div id="del-categori">
                                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar una categoría</h2>
                                <form action="process/delcategori.php" method="post" role="form">
                                    <div class="form-group">
                                        <label>Categorías</label>
                                        <select class="form-control" name="categ-code">
                                            <?php
                                                $categoriav=  ejecutarSQL::consultar("select * from categoria");
                                                while($categv=mysql_fetch_array($categoriav)){
                                                    echo '<option value="'.$categv['id_cat'].'">'.$categv['id_cat'].' - '.$categv['nombre_cat'].'- '.$categv['desc_cat'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar categoría</button></p>
                                    <br>
                                    <div id="res-form-del-cat" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <br><br>
                            <div class="panel panel-info">
                                <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar categoría</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Descripción</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              $categorias=  ejecutarSQL::consultar("select * from categoria");
                                              $ui=1;
                                              while($cate=mysql_fetch_array($categorias)){
                                                  echo '
                                                      <div id="update-category">
                                                        <form method="post" action="process/updateCategory.php" id="res-update-category-'.$ui.'">
                                                          <tr>
                                                              <td>
                                                                <input class="form-control all-elements-tooltip" type="hidden" name="categ-code-old" maxlength="9" required="" value="'.$cate['id_cat'].'">
                                                                <input class="form-control all-elements-tooltip" type="text" name="categ-name" maxlength="30" required="" value="'.$cate['nombre_cat'].'"></td>
                                                              <td><input class="form-control all-elements-tooltip" type="text-area" name="categ-descrip" required="" value="'.$cate['desc_cat'].'"></td>
                                                              <td class="text-center">
                                                                  <button type="submit" class="btn btn-sm btn-primary button-UC" value="res-update-category-'.$ui.'">Actualizar</button>
                                                                  <div id="res-update-category-'.$ui.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                              </td>
                                                          </tr>
                                                        </form>
                                                      </div>
                                                      ';
                                                  $ui=$ui+1;
                                              }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <!--==============================Panel Admins===============================-->
                <div role="tabpanel" class="tab-pane fade" id="Admins">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <br><br>
                            <div id="add-admin" >
                                <h2 class="text-info text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar administrador</h2>
                                <form action="process/regAdmin.php" method="post" role="form">
                                    <br>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <input class="form-control all-elements-tooltip" type="text" placeholder="Ingrese los nombres" required name="clien-fullname" data-toggle="tooltip" data-placement="top" title="Ingrese los nombres(solamente letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <input class="form-control all-elements-tooltip" type="text" placeholder="Ingrese los apellidos" required name="clien-lastname" data-toggle="tooltip" data-placement="top" title="Ingrese los apellido(solamente letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-at"></i></div>
                                            <input class="form-control all-elements-tooltip" type="email" placeholder="Ingrese el Email" required name="clien-email" data-toggle="tooltip" data-placement="top" title="Ingrese la dirección Email" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <input class="form-control all-elements-tooltip" type="password" placeholder="Introdusca una contraseña" required name="clien-pass" data-toggle="tooltip" data-placement="top" title="Defina una contraseña para iniciar sesión">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-home"></i></div>
                                            <input class="form-control all-elements-tooltip" type="text" placeholder="Ingrese la dirección" required name="clien-dir" data-toggle="tooltip" data-placement="top" title="Ingrese la direción en la reside actualmente" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                            <input class="form-control all-elements-tooltip" type="tel" placeholder="Ingrese el número telefónico" required name="clien-phone" maxlength="11" pattern="[0-9]{8,11}" data-toggle="tooltip" data-placement="top" title="Ingrese el número telefónico. Mínimo 8 digitos máximo 11">
                                        </div>
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-primary">Agregar administrador</button></p>
                                    <br>
                                    <div id="res-form-add-admin" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <br><br>
                            <div id="del-admin">
                                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar administrador</h2>
                                <form action="process/deladmin.php" method="post" role="form">
                                    <div class="form-group">
                                        <label>Administradores</label>
                                        <select class="form-control" name="name-admin">
                                            <?php
                                                $adminCon=  ejecutarSQL::consultar("select * from usuario WHERE tipo_usu=1");
                                                while($AdminD=mysql_fetch_array($adminCon)){
                                                    echo '<option value="'.$AdminD['email_usu'].'">'.$AdminD['apellidos_usu'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar administrador</button></p>
                                    <br>
                                    <div id="res-form-del-admin" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12"></div>
                    </div>
                </div>
                <!-- panel sitio web -->
                <!--==============================Panel Admins===============================-->
                <div role="tabpanel" class="tab-pane fade" id="SitioWeb">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <br><br>
                            <div id="update-Sweb" >
                                <h2 class="text-info text-center"><small><i class="fa fa-cog"></i></small>&nbsp;&nbsp;Configuracion del SitioWeb</h2>
                                <form action="process/updateSitio.php" method="post" role="form">
                                    <br>
                                    <?php
                                    $dsweb=  ejecutarSQL::consultar("select * from datosWeb");
                                    while($d=mysql_fetch_array($dsweb)){
                                        echo '

                                    <div class="form-group col-xs-12 col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="text" placeholder="Nombre del SitioWeb" required name="clien-fullname" data-toggle="tooltip" data-placement="top" title="Ingrese el nombre(solamente 50 letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50" value="'.$d['nombreSitio'].'">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="text" placeholder="Ingrese el mensaje de bienvenida" required name="clien-lastname" data-toggle="tooltip" data-placement="top" title="Ingrese el mensaje de bienvenida(solamente 50 letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50" value="'.$d['SmsSitio'].'">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12">
                                    <label for="redes">Redes Sociales</label>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-facebook"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de facebook" required name="clien-fa" data-toggle="tooltip" data-placement="top" title="Ingrese la dirección de facebook" maxlength="50" value="'.$d['urlFacebook'].'">
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-google-plus" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de Google Plus" required name="clien-pass" data-toggle="tooltip" data-placement="top" title="Ingrese la url de Google Plus" value="'.$d['urlGPlus'].'">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-pinterest" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de Pinterest" required name="clien-dir" data-toggle="tooltip" data-placement="top" title="Ingrese la url de Pinterest" maxlength="100" value="'.$d['urlPinterest'].'">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de Twitter" required name="clien-phone" maxlength="11" pattern="[0-9]{8,11}" data-toggle="tooltip" data-placement="top" title="Ingrese la url de Twitter" value="'.$d['urlTwitter'].'">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de Linkedin" required name="clien-phone" maxlength="11" pattern="[0-9]{8,11}" data-toggle="tooltip" data-placement="top" title="Ingrese la url de linkedin" value="'.$d['urlLinkedin'].'">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                            <input class="form-control all-elements-tooltip" type="url" placeholder="Ingrese la url de la ubicacion de GoogleMap" required name="clien-phone" maxlength="11" pattern="[0-9]{8,11}" data-toggle="tooltip" data-placement="top" title="Ingrese la url de la ubicacion de google maps" value="'.$d['urlGlocaled'].'">
                                        </div>
                                    </div>';
                                    }
                                    ?>
                                    <br>
                                    <p class="text-center"><button type="submit" class="btn btn-primary">Actualizar datos del SitioWeb</button></p>
                                    <br>
                                    <div id="res-form-add-admin" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin panel sitio web -->
                <!--==============================Panel pedidos===============================-->
                <div role="tabpanel" class="tab-pane fade" id="Pedidos">
                    <div class="row">
                        <div class="col-xs-12">
                            <br><br>
                            <div id="del-pedido">
                                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar pedido</h2>
                                <form action="process/delPedido.php" method="post" role="form">
                                    <div class="form-group">
                                        <label>Pedidos</label>
                                        <select class="form-control" name="num-pedido">
                                            <?php
                                                $pedidoC=  ejecutarSQL::consultar("select * from venta");
                                                while($pedidoD=mysql_fetch_array($pedidoC)){
                                                    echo '<option value="'.$pedidoD['n_pedido_ven'].'">Pedido #'.$pedidoD['n_pedido_ven'].' - Estado('.$pedidoD['Estado'].') - Fecha('.$pedidoD['fecha_ven'].')</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar pedido</button></p>
                                    <br>
                                    <div id="res-form-del-pedido" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                            <br><br>
                             <div class="panel panel-info">
                               <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar estado de pedido</h3></div>
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead class="">
                                          <tr>
                                              <th class="text-center">#</th>
                                              <th class="text-center">Fecha</th>
                                              <th class="text-center">Cliente</th>
                                              <th class="text-center">Descuento</th>
                                              <th class="text-center">Total</th>
                                              <th class="text-center">Estado</th>
                                              <th class="text-center">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $pedidoU=  ejecutarSQL::consultar("select * from venta");
                                            $upp=1;
                                            while($peU=mysql_fetch_array($pedidoU)){
                                                echo '
                                                    <div id="update-pedido">
                                                      <form method="post" action="process/updatePedido.php" id="res-update-pedido-'.$upp.'">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'</td>
                                                            <td hidden><input type="text" name="num-pedido" value="'.$peU['n_pedido_ven'].'"</td>
                                                            <td>'.$peU['fecha_ven'].'
                                                            </td>
                                                            <td>';
                                                                $conUs= ejecutarSQL::consultar("select * from usuario where id_usu='".$peU['id_usu']."'");
                                                                while($UsP=mysql_fetch_array($conUs)){
                                                                    echo $UsP['apellidos_usu'];
                                                                }
                                                    echo   '</td>
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>
                                                                <select class="form-control" name="pedido-status">';
                                                                    if($peU['Estado']=="Pendiente"){
                                                                       echo '<option value="Pendiente">Pendiente</option>';
                                                                       echo '<option value="Entregado">Entregado</option>';
                                                                    }
                                                                    if($peU['Estado']=="Entregado"){
                                                                       echo '<option value="Entregado">Entregado</option>';
                                                                       echo '<option value="Pendiente">Pendiente</option>';
                                                                    }
                                                    echo        '</select>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-primary button-UPPE" value="res-update-pedido-'.$upp.'">Actualizar</button>
                                                                <div id="res-update-pedido-'.$upp.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                            </td>
                                                        </tr>
                                                      </form>
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
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Descuento</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center" colspan="2">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $pedidoU=  ejecutarSQL::consultar("select * from venta WHERE Estado='Pendiente'");
                                        $upp=1;
                                        while($peU=mysql_fetch_array($pedidoU)){
                                            echo '
                                                    <div id="update-pedido">
                                                      <form method="post" action="process/updatePedido.php" id="res-update-pedido2-'.$upp.'">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'<input type="hidden" name="num-pedido" value="'.$peU['n_pedido_ven'].'"></td>
                                                            <td>'.$peU['fecha_ven'].'</td>
                                                            <td>';
                                            $conUs= ejecutarSQL::consultar("select * from usuario where id_usu='".$peU['id_usu']."'");
                                            while($UsP=mysql_fetch_array($conUs)){
                                                echo $UsP['apellidos_usu'];
                                            }
                                            echo   '</td>
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>
                                                                <select class="form-control" name="pedido-status">';
                                            if($peU['Estado']=="Pendiente"){
                                                echo '<option value="Pendiente">Pendiente</option>';
                                                echo '<option value="Entregado">Entregado</option>';
                                            }
                                            if($peU['Estado']=="Entregado"){
                                                echo '<option value="Entregado">Entregado</option>';
                                                echo '<option value="Pendiente">Pendiente</option>';
                                            }
                                            echo        '</select>
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                            <a href="detalle.php?det='.$peU['n_pedido_ven'].'" class="btn btn-sm btn-primary button-UPPE">
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Detalle
                                                            </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-primary button-UPPE" value="res-update-pedido2-'.$upp.'">Actualizar</button>
                                                                <div id="res-update-pedido2-'.$upp.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                            </td>

                                                        </tr>
                                                      </form>
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
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Descuento</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center" colspan="2">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $pedidoU=  ejecutarSQL::consultar("select * from venta WHERE Estado='Entregado'");
                                        $upp=1;
                                        while($peU=mysql_fetch_array($pedidoU)){
                                            echo '
                                                    <div id="update-pedido">
                                                      <form method="post" action="process/updatePedido.php" id="res-update-pedido3-'.$upp.'">
                                                        <tr>
                                                            <td>'.$peU['n_pedido_ven'].'<input type="hidden" name="num-pedido" value="'.$peU['n_pedido_ven'].'"></td>
                                                            <td>'.$peU['fecha_ven'].'</td>
                                                            <td>';
                                            $conUs= ejecutarSQL::consultar("select * from usuario where id_usu='".$peU['id_usu']."'");
                                            while($UsP=mysql_fetch_array($conUs)){
                                                echo $UsP['apellidos_usu'];
                                            }
                                            echo   '</td>
                                                            <td>'.$peU['descu_ven'].'%</td>
                                                            <td>'.$peU['total_ven'].'</td>
                                                            <td>
                                                                <select class="form-control" name="pedido-status">';
                                            if($peU['Estado']=="Pendiente"){
                                                echo '<option value="Pendiente">Pendiente</option>';
                                                echo '<option value="Entregado">Entregado</option>';
                                            }
                                            if($peU['Estado']=="Entregado"){
                                                echo '<option value="Entregado">Entregado</option>';
                                                echo '<option value="Pendiente">Pendiente</option>';
                                            }
                                            echo        '</select>
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                            <a href="detalle.php?det='.$peU['n_pedido_ven'].'" class="btn btn-sm btn-primary button-UPPE">
                                                            <i class="fa fa-eye"></i>&nbsp;&nbsp;Detalle
                                                            </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-primary button-UPPE" value="res-update-pedido3-'.$upp.'">Actualizar</button>
                                                                <div id="res-update-pedido3-'.$upp.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                            </td>

                                                        </tr>
                                                      </form>
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