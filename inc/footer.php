<footer>
    <h3 class="text-center">Siguenos en</h3><br>
    <ul class="list-unstyled text-center">
    <?php
     if ($f!=null){
         echo '<a href="'.$f.'" class="social-icon all-elements-tooltip" data-toggle="tooltip" data-placement="bottom" title="Facebook">
            <img src="assets/icons/social-facebook.png" alt="facebook-icon">
        </a>';
     }
    if ($gp!=null) {
        echo '<a href="'.$gp.'" class="social-icon all-elements-tooltip" data-toggle="tooltip" data-placement="bottom" title="Google +">
            <img src="assets/icons/social-googleplus.png" alt="googleplus-icon">
        </a>';
    }
    if ($l!=null) {
        echo '<a href="'.$l.'" class="social-icon all-elements-tooltip" data-toggle="tooltip" data-placement="bottom" title="Linkedin">
            <img src="assets/icons/social-linkedin.png" alt="linkedin-icon">
        </a>';
    }
    if ($p!=null) {
        echo '<a href="'.$p.'" class="social-icon all-elements-tooltip" data-toggle="tooltip" data-placement="bottom" title="Pinterest">
            <img src="assets/icons/social-pinterest.png" alt="pinterest-icon">
        </a>';
    }
    if ($t!=null) {
        echo '<a href="'.$t.'" class="social-icon all-elements-tooltip" data-toggle="tooltip" data-placement="bottom" title="Twitter">
            <img src="assets/icons/social-twitter.png" alt="twitter-icon">
        </a>';
    }





    ?>
    </ul>


    <br>
    <div class="row center">
        <p class="text-center">Contador de vistas</p>
        <p class="text-center"><?php include_once 'inc/contador.php'; $c=contador(); $cadena='';
        for ($i=strlen($cs);$i<8;$i++){
            $cadena.='0';
        }
        echo $cadena.=''.$c;
        ?></div>
    <h5 class="text-center tittles-pages-logo"><?php echo $n;?> &copy; <?php echo date("Y");?></h5>
</footer>
