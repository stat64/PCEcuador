<!doctype html>
<html lang="es">
<head>
  <title>Bienvenidos a nuestra Tienda</title>
</head>
<body>
<?php
include('inc/link.php');
include('inc/navbar.php');
?>
<div class="jumbotron" id="jumbotron-index">
    <h1><span class="tittles-pages-logo"><?php echo $tt;?></span> <small style="color: #fff;"><?php echo $st;?></small></h1>
    <p>
          <?php echo $m;?>
      </p>
    </div>
    <section id="new-cat-prod-index">
         <div class="container" id="new-prod-index">
            <div class="page-header">
                <h1>Novedades - <small>Productos</small></h1>
            </div>
            <div class="row">
              <?php
                      $consulta= ejecutarSQL::consultar("select * from producto where stock_pro > 0 and fecha_ing limit 8");
                  $totalproductos = mysql_num_rows($consulta);
                  if($totalproductos>0){
                      $nums=1;
					  while($fila=mysql_fetch_array($consulta)){
                         echo '
                                                          <div class="col-xs-12 col-sm-6 col-md-3">
                                       <div class="thumbnail">
                                         <a href="infoProd.php?CodigoProd='.$fila['id_pro'].'"><img style="height: 190px" class="img-rounded" alt="Cinque Terre" src="assets/img-products/'.$fila['Imagen'].'" style="width:100%"></a>
                                         <div class="caption">
                                           <h4>'.$fila['desc_pro'].'</h4>
                                           <p>$'.$fila['precio_pro'].'</p>
                                           <p class="text-center">
                                               
                                               <a href="infoProd.php?CodigoProd='.$fila['id_pro'].'" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Detalles</a>&nbsp;&nbsp;
                                               <button value="'.$fila['id_pro'].'" class="btn btn-success btn-sm botonCarrito"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir</button>
                                           </p>

                                         </div>
                                       </div>
                                   </div> 

                         ';
						 
						  if ($nums%4==0){
								 echo '<div class="clearfix"></div>';
							}
							$nums++;
                     }   
                  }else{
                      echo '<h2>No hay productos registrados en la tienda</h2>';
                  }  
              ?>  
            </div>
         </div>
  </section>
    <section id="reg-info-index">
        <div class="container" id="inf-emp-index">
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center">
                   <article style="margin-top:10%;">
                        <p><i class="fa fa-facebook-square fa-4x"></i></p>
                        <h3>Siguenos en Facebook</h3>
                        <p> <span class="tittles-pages-logo">Plantas Carnivoras Ecuador</span></p>

                       <p><a href="<?php echo $f;?>" class="btn btn-info btn-block">Ir</a></p>
                   </article>
                    <article >
                        <p><img src="img/logo_st.png" alt=""></p>
                        <h3>Visita Nuestra tienda</h3>
                        <?php
                        if ($gl==null){
                        echo '<p><a href="'.$f.'" class="btn btn-info btn-block">Como llegar</a></p>';
                        }else{
                            echo '<p><a href="'.$gl.'" class="btn btn-info btn-block">Como llegar</a></p>';

                        }
                        ?>
                    </article>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <img src="assets/img/img-registration.png" class="img-responsive">
                </div>
            </div>
        </div>
    </section>

<script>
    $(document).ready(function() {
        $('#store-links a:first').tab('show');
    });
</script>
<?php
include './inc/contador.php';
contador_inc();
include './inc/footer.php';
?>
</body>
</html>
        


