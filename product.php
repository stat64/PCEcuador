
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos</title>
    <?php include_once './inc/link.php'; ?>

</head>
<body id="container-page-product">
    <?php include_once './inc/navbar.php'; ?>

    <section id="store">
       <br>
        <div class="container">
            <div class="page-header">
              <h1>Tienda - <small class="tittles-pages-logo"><?php echo $n;?></small></h1>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <ul id="store-links" class="nav nav-tabs" role="tablist">
                      <li role="presentation"><a href="#all-product" role="tab" data-toggle="tab" aria-controls="all-product" aria-expanded="false">Todos los productos</a></li>
                      <li role="presentation" class="dropdown active">
                        <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Categorías <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                          <!-- ==================== Lista categorias =============== -->
                          <?php
                            $categorias=  ejecutarSQL::consultar("select * from categoria");
                            while($cate=mysql_fetch_array($categorias)){
                                echo '
                                    <li>
                                        <a href="#'.$cate['id_cat'].'" tabindex="-1" role="tab" id="'.$cate['id_cat'].'-tab" data-toggle="tab" aria-controls="'.$cate['id_cat'].'" aria-expanded="false">'.$cate['nombre_cat'].'
                                        </a>
                                    </li>';
                            }
                          ?>
                          <!-- ==================== Fin lista categorias =============== -->
                        </ul>
                      </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade" id="all-product" aria-labelledby="all-product-tab">
                          <br><br>
                        <div class="row">
                        <?php
                            $consulta=  ejecutarSQL::consultar("select * from producto, categoria where  categoria.id_cat=producto.id_cat and stock_pro > 0");
                            $totalproductos = mysql_num_rows($consulta);
                            if($totalproductos>0){
								$nums=1;
                                while($fila=mysql_fetch_array($consulta)){
                                   echo '
                                  <div class="col-xs-12 col-sm-6 col-md-3">
                                       <div class="thumbnail">
                                         <a href="infoProd.php?CodigoProd='.$fila['id_pro'].'"><img style="height: 190px" class="img-rounded" alt="Cinque Terre" src="assets/img-products/'.$fila['Imagen'].'" style="width:100%"></a>
                                         <div class="caption">
                                           <h3>'.$fila['nombre_cat'].'</h3>
                                           <p style="width: auto">'.$fila['desc_pro'].'</p>
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
                                echo '<h2>No hay productos en esta categoria</h2>';
                            }  
                        ?>
                        </div>
                      </div><!-- Fin del contenedor de todos los productos -->
                      
                      <!-- ==================== Contenedores de categorias =============== -->
                      <?php
                        $consultar_categorias= ejecutarSQL::consultar("select * from categoria");
                        $nums=1;
                      while($categ=mysql_fetch_array($consultar_categorias)){
                            echo '<div role="tabpanel" class="tab-pane fade active in" id="'.$categ['id_cat'].'" aria-labelledby="'.$categ['id_cat'].'-tab"><br>';
                                $consultar_productos= ejecutarSQL::consultar("select * from producto, categoria where  categoria.id_cat=producto.id_cat and stock_pro > 0 and  categoria.id_cat='".$categ['id_cat']."' and stock_pro > 0");

                                echo '<h1>'.$categ['nombre_cat'].'- <small class="tittles-pages-logo">'.$categ['desc_cat'].'</small></h1><br>';

                          $totalprod = mysql_num_rows($consultar_productos);
                          if($totalprod>0){
                                    $nums=1;
                                    while($prod=mysql_fetch_array($consultar_productos)){
                                        echo '
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <div class="thumbnail">
                                               <a href="infoProd.php?CodigoProd='.$prod['id_pro'].'"><img src="assets/img-products/'.$prod['id_pro'].'"></a>
                                               <div class="caption">
                                                 <h3>'.$prod['nombre_cat'].'</h3>
                                                 <p>'.$prod['desc_pro'].'</p>
                                                 <p>$'.$prod['precio_pro'].'</p>
                                                 <p class="text-center">
                                                     <a href="infoProd.php?CodigoProd='.$prod['id_pro'].'" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Detalles</a>&nbsp;&nbsp;
                                                     <button value="'.$prod['id_pro'].'" class="btn btn-success btn-sm botonCarrito"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir</button>
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
                                } else {
                                   echo '<h2>No hay productos en esta categoría</h2>'; 
                                }
                            echo '</div>'; 
                        }
                      ?>
                      <!-- ==================== Fin contenedores de categorias =============== -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>
    <script>
        $(document).ready(function() {
            $('#store-links a:first').tab('show');
        });
    </script>
</body>
</html>