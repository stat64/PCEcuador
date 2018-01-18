<?php
    include './process/securityPanelUsu.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Administrativo</title>
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
              <li role="presentation" class="active"><a href="#MIPERFIL" role="tab" data-toggle="tab">Mi Perfil</a></li>
                <li role="presentation"><a href="#SEGURIDAD" role="tab" data-toggle="tab">Seguridad</a></li>
                <li role="presentation"><a href="#DATOSDENVIO" role="tab" data-toggle="tab">Datos de Envio</a></li>

            </ul>
            <div class="tab-content">
                <!--==============================Panel MI perfil===============================-->
                <div role="tabpanel" class="tab-pane fade in active" id="MIPERFIL">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <br><br>
                        <div id="update-category">
                            <h2 class="text-primary text-center"><small><i class="fa fa-user fa-5x"></i></small></h2>
                            <table class="table table-bordered">
                                <thead class="">
                                <tr>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Telefono</th>
                                    <th class="text-center">Email (usaremos su email como usuario)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $dir=  ejecutarSQL::consultar("select * from usuario where email_usu='".$_SESSION['nombreUser']."'");
                                $ui=1;
                                while($d=mysql_fetch_array($dir)){
                                    echo '
                                                      <div id="update-category">
                                                        <form method="post" action="process/updateMIPERFIL.php" id="res-update-category-'.$ui.'">
                                                          <tr>
                                                              <td>
                                                                <input class="form-control  all-elements-tooltip" type="hidden" name="user-code-old" maxlength="9" required="" value="'.$d['id_usu'].'">
                                                                <input class="form-control  all-elements-tooltip" type="text" name="user-nom" maxlength="30" required="" value="'.$d['nombres_usu'].'"></td>
                                                              <td><input class="form-control  all-elements-tooltip" type="text" name="user-ape" required="" value="'.$d['apellidos_usu'].'"></td>
                                                              <td><input class="form-control  all-elements-tooltip" type="text-area" name="user-tel" required="" value="'.$d['telefono_usu'].'"></td>
                                                              <td><input class="form-control  all-elements-tooltip" type="text-area" name="user-email" required="" value="'.$d['email_usu'].'"></td>
                                                              
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

                    <!--==============================Panel Seguridad===============================-->
                    <div role="tabpanel" class="tab-pane" id="SEGURIDAD">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <br><br>
                                <div id="update-category">
                                    <h2 class="text-primary text-center"><small><i class="fa fa-lock fa-5x"></i></small></h2>
                                    <table class="table table-bordered">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">Password Actual</th>
                                            <th class="text-center">Password Nuevo</th>
                                            <th class="text-center">Repita el Password Nuevo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $dir=  ejecutarSQL::consultar("select * from usuario where email_usu='".$_SESSION['nombreUser']."'");
                                        $ui=1;
                                        while($d=mysql_fetch_array($dir)){
                                            echo '
                                                      <div id="update-product">
                                                        <form method="post" action="process/updatePASSWORD.php" id="res-update-product-'.$ui.'">
                                                          <tr>
                                                              <td>
                                                                <input class="form-control all-elements-tooltip" type="hidden" name="user-code-old" required="" value="'.$d['id_usu'].'">
                                                                <input class="form-control all-elements-tooltip" type="hidden" name="user-pass-old" required="" value="'.$d['pass_usu'].'">
                                                                <input class="form-control all-elements-tooltip" type="password" name="user-pass-old-insert" maxlength="30" required=""></td>
                                                              <td>
                                                                <input class="form-control all-elements-tooltip" type="password" name="user-pass-new-insert" maxlength="30" required="">
                                                              </td>
                                                              <td>
                                                              
                                                                <input class="form-control all-elements-tooltip" type="password" name="user-pass-new-r-insert" maxlength="30" required="" data-toggle="tooltip" data-placement="top">
                                                              </td>
                                                              
                                                              <td class="text-center">
                                                                  <button type="submit" class="btn btn-sm btn-primary button-UC" value="res-update-product-'.$ui.'">Actualizar</button>
                                                                  <div id="res-update-product-'.$ui.'" style="width: 100%; margin:0px; padding:0px;"></div>
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

                <!--==============================Panel DATOS DE ENVIO===============================-->
                <div role="tabpanel" class="tab-pane" id="DATOSDENVIO">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <br><br>
                            <div id="update-category">
                                <h2 class="text-primary text-center"><small><i class="fa fa-truck fa-5x"></i></small></h2>

                                <table class="table table-bordered">
                                    <thead class="">
                                    <tr>
                                        <th class="text-center">Provincia</th>
                                        <th class="text-center">Ciudad</th>
                                        <th class="text-center">Direccion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $dir=  ejecutarSQL::consultar("select * from usuario where email_usu='".$_SESSION['nombreUser']."'");
                                    $ui=1;
                                    while($d=mysql_fetch_array($dir)){
                                        echo '
                                                      <div id="update-categoryD">
                                                        <form method="post" action="process/updateDatosEnvio.php" id="res-update-categoryD-'.$ui.'">
                                                          <tr>
                                                              <td>
                                                                <input class="form-control all-elements-tooltip" type="hidden" name="user-code-old" maxlength="9" required="" value="'.$d['id_usu'].'">
                                                                <input class="form-control all-elements-tooltip" type="text" name="user-prov" maxlength="30" required="" value="'.$d['prov_usu'].'"></td>
                                                              <td><input class="form-control all-elements-tooltip" type="text" name="user-cit" required="" value="'.$d['ciudad_usu'].'"></td>
                                                              <td><input class="form-control all-elements-tooltip" type="text-area" name="user-dir" required="" value="'.$d['dir_usu'].'"></td>
                                                              
                                                              <td class="text-center">
                                                                  <button type="submit" class="btn btn-sm btn-primary button-UC" value="res-update-categoryD-'.$ui.'">Actualizar</button>
                                                                  <div id="res-update-categoryD-'.$ui.'" style="width: 100%; margin:0px; padding:0px;"></div>
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
        </div>

    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>