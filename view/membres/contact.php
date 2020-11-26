<html>
<body>
<?php
    if(isset($_POST['email']) && isset($_POST['objet']) && isset($_POST['message'])){
        $header="MIME-Version: 1.0\r\n";
        $header.='From: "site.com"<lp.prioux@gmail.com>'."\n";
        $header.='Content-Type:text/html; cherset="uft_8"'."\n";
        $header.='Content-Transfert-Encoding: 8bit';
        $message = '<html>
        <body>
        <div align="centerr">
        '.$_POST['message'].'
        </div>
        </body>
        </hmtl>';

        mail($_POST['email'],$_POST['objet'],$message,$header);
        header("Location: index.php?action=Home");
       
    }
    else {
        if(isset($_POST['email']))
            echo "<p> Veuillez remplir tous les chmaps !</p>";
    }
    ?>
    
    <form method="post" action="index.php?action=contact">
        <ul>
            <li><h2> Nous contactez</h2><li>
            <li><label>Votre mail : </label></li>
            <li><input type="mail" name="email"></li>
            <li><label>Votre objet : </label></li>
            <li><input type="text" name="objet"></li>
            <li><label>Votre message : </label></li>
            <li><textarea  name="message"rows="5" cols="33">Votre message...</textarea></li>
            <li><input type="submit" name="envoyer" value="envoyer"></li>
        </ul>
    </form>
    

</body>
</html>