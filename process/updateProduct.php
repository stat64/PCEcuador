<?php
include ('../library/configServer.php');
include ('../library/consulSQL.php');

?>
<html>
<head>
    <title>Admin</title>
    <meta charset="UTF-8">
    <meta http-equiv="Refresh" content="12;url=../configAdmin.php">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="Shortcut Icon" type="image/x-icon" href="../assets/icons/logo.ico" />
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/autohidingnavbar.min.js"></script>
</head>
<body>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                <?php
                $id=$_POST['code-old-prod'];
                $nameProd= $_POST['prod-name'];
                $cateProd= $_POST['prod-category'];
                $priceProd= $_POST['price-prod'];
                $stockProd= $_POST['stock-prod'];
                $admin= $_POST['prod-Prove'];

                if(!$nameProd=="" && !$cateProd=="" && !$priceProd=="" && !$stockProd=="" && !$admin=="" && !$_FILES['img']['name']==""){
                    @$archivo = $_FILES['img'];//para la ruta de la imagen
                    $nombrefile = $_FILES['img']['name'];//extraernombre por default
                    $rutatmp = $_FILES['img']['tmp_name'];//ruta y nombre temporal
                    $rutanueva = "../assets/img-products/".strftime("%H%M%S").''.$_FILES['img']['size'].''.$_FILES['img']['name']; //ruta nueva
                    $nombrefileS=strftime("%H%M%S").''.$_FILES['img']['size'].''.$_FILES['img']['name']; //nf
                    if(is_uploaded_file($rutatmp)) {
                        if(copy($rutatmp, $rutanueva)){

                            echo "Se ha guardado correctamente,de click en actualizar mi imagen ";
//---------------------------------------------------------------------------------------------
                            $img_origen = imagecreatefromjpeg( $rutanueva );
                            $ancho_origen = imagesx( $img_origen );
                            $alto_origen = 3000;//TAMAÑO DESEADO A REDUCIR
                            $ancho_limite=2000;//TAMAÑO DESEADO A REDUCIR
                            if($ancho_origen>$alto_origen){

                                $ancho_origen=$ancho_limite;
                                $alto_origen=$ancho_limite*imagesy( $img_origen )/imagesx( $img_origen );

                            }else{
                                $alto_origen=$ancho_limite;
                                $ancho_origen=$ancho_limite*imagesx( $img_origen )/imagesy( $img_origen );
                            }
                            $img_destino = imagecreatetruecolor($ancho_origen ,$alto_origen );
                            imagecopyresized( $img_destino, $img_origen, 0, 0, 0, 0, $ancho_origen, $alto_origen, imagesx( $img_origen ), imagesy( $img_origen ) );
                            imagejpeg( $img_destino, $rutanueva );
                            echo " la imagen se redujo correctamente o";
//---           -----------------------------------------------------------------------------------------------------
                        } else {
                            echo "No se ha podido subir la imagen debe de ser jpg intentelo otravez";
                        }
                    }

                    //if(move_uploaded_file($_FILES['img']['tmp_name'],"../assets/img-products/".strftime("%H%M%S").''.$_FILES['img']['size'].''.$_FILES['img']['name'])){
                    if(consultasSQL::UpdateSQL("producto","desc_pro='$nameProd',id_cat='$cateProd',precio_pro='$priceProd',stock_pro='$stockProd',Imagen='$nombrefileS'", "id_pro='$id'")){
                        echo '
                       
                            <img src="../assets/img/correctofull.png" class="center-all-contens">
                            <br>
                            <h3>El producto actualizo con éxito</h3>
                            <p class="lead text-cente">
                                La pagina se redireccionara automaticamente. Si no es asi haga click en el siguiente boton.<br>
                                <a href="../configAdmin.php" class="btn btn-primary btn-lg">Volver a administración</a>
                            </p>';
                    }else{
                        echo '
                            <img src="../assets/img/incorrectofull.png" class="center-all-contens">
                            <br>
                            <h3>Ha ocurrido un error. Por favor intente nuevamente</h3>
                            <p class="lead text-cente">
                                La pagina se redireccionara automaticamente. Si no es asi haga click en el siguiente boton.<br>
                                <a href="../configAdmin.php" class="btn btn-primary btn-lg">Volver a administración</a>
                            </p>';
                    }


                }else {
                    echo '
                <img src="../assets/img/incorrectofull.png" class="center-all-contens">
                <br>
                <h3>Error los campos no deben de estar vacíos</h3>
                <p class="lead text-cente">
                    La pagina se redireccionara automaticamente. Si no es asi haga click en el siguiente boton.<br>
                    <a href="../configAdmin.php" class="btn btn-primary btn-lg">Volver a administración</a>
                </p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
</body>
</html>