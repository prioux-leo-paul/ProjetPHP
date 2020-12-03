<?php
require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle
if(isset($_SESSION['estadmin'])){
    if($_SESSION['estadmin'] == 1){
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="view/view2.css">
	<meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $pagetitle ;?></title>
</head>
<body>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <div class="container">
            <div class="box">
                <div class="title">
                    <h2>Slide-Shop admin</h2>
                </div>
                <div class="first-box">
                    <ul>
                        <li><a href="index.php?action=Home">Retour site classic</a></li>
                        
                        <li><a href="index.php?action=Home2">Home admin</a></li>
                        
                        
                        <li><a href="index.php?controller=produit&action=allproduitadmin">Produits admin</a></li>
                        <li><a href="index.php?controller=produit&action=ajouterproduit">Ajouter un produit</a></li>
                        <li><a href="index.php?action=logout">Deconnexion</a></li>
                       
                    </ul>
                    
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
<?php 
    }
    else
        echo "Vous n'avez pas les droits d'acces a cette page ";
}
else
    echo "Vous n'avez pas les droits d'acces a cette page ";