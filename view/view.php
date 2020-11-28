<?php
require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle

?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="view/view.css">
	<meta name="viewport" content="width=device-width,initial-scale=1">
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
                        if(isset($_SESSION['estadmin'])){
                        if($_SESSION['estadmin'] == 1){
                        ?>
                        <li><a href="index.php?action=Home2">Admin page</a></li>
                        <?php
                        }
                        }
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
                        <li><a href="index.php?action=contact">Contact</a></li>
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
       
                $filepath = File::buildpath(array("view", static::$object, "$view.php"));
                require $filepath;
                
            ?>
            </div>
        </div>

</body>


</html>