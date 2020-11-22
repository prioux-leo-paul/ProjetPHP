<?php
require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle

?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="view/view2.css">
	<meta name="viewport" content="whidth=device-width,initial-scale=1">
    <title><?php echo $pagetitle ;?></title>
</head>
<body>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <div class="container">
            <div class="box">
                <div class="title">
                    <h2>Slide-Shop</h2>
                </div>
                <div class="first-box">
                    <ul>
                        <li><a href="index.php?action=Home">Home</a></li>
                        <?php
                        if(isset($_SESSION['numMembre'])){
                        ?>
                        <li><a href="index.php?action=profile">Profile</a></li>
                        <li><a href="index.php?action=logout">Deconnexion</a></li>
                        <?php
                        }
                        else{
                        ?>
                        <li><a href="index.php?action=formlogin">Connexion</a></li>
                        <li><a href="index.php?action=formregister">S'inscrire</a></li>
                        <?php } ?>
                        <li><a href="index.php?controller=produit&action=allproduit">Produit</a></li>
                        <li><a href="index.php?controller=produit&action=voirpanier">Panier</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <div class="social_media">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="full-page" align="center">
                <?php
<<<<<<< HEAD
                        $filepath = File::buildpath(array("view", $controller, "$view.php"));
                        require $filepath;
                        
                    ?>
            </div>
=======
                if(isset($_SESSION['numMembre'])){
                ?>
                <li><a href="index.php?action=profile">Profile</a></li>
                <li><a href="index.php?action=logout">Deconnexion</a></li>
                <?php
                }
                else{
                ?>
                <li><a href="index.php?action=formlogin">Connexion</a></li>
                <li><a href="index.php?action=formregister">S'inscrire</a></li>
                <?php } ?>
                <li><a href="index.php?controller=produit&action=allproduit">Produit</a></li>
                <li><a href="index.php?controller=produit&action=voirpanier">Panier</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Map</a></li>
            </ul> 
            <div class="social_media">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="main_content" align="center">
            <?php
                $filepath = File::buildpath(array("view", static::$object, "$view.php"));
                require $filepath;
                
            ?>
            
>>>>>>> b7b5afd3d307aa72f51dcb2dfde021f9802bb244
        </div>

</body>


</html>