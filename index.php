<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="whidth=device-width,initial-scale=1">
</head>
<body>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <div class="wrapper">
        <div class="sidebar">
            <h2>Slide-Shop</h2>
            <ul>
                <li><a href="../controller/router.php?action=Home">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="../controller/router.php?action=formlogin">Connexion</a></li>
                <li><a href="../controller/router.php?action=logout">Deconnexion</a></li>
                <li><a href="../controller/router.php?action=formregister">S'inscrire</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Map</a></li>
            </ul> 
            <div class="social_media">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="main_content">
            <?php
                require_once 'lib/File.php';
                require build_path(array('controller','routeur.php'));
            ?>
            
        </div>
    </div>

</body>


</html>
