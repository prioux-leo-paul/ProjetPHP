<html> 
    <body>
        <div align="center">
            <table>
                <tr><td><h2>Profil de <?php echo $_SESSION['pseudoMembre'] ?></h2></td></tr>
                <tr><td><a href="index.php?action=formediterprofile">Editer mon profil</a></td>
                <td><a href="index.php?action=supprofile">Supprimer moncompte</a></td></tr>
            </table>
            <br><br>
            <table>
               <tr><h2>Mes dernière commandes</h2></tr>
               
               <tr>
                <td>aperçu</td>
                <td>Quantité acheté</td>
                <td>Date de l'achat</td>
                <td>Voir commande</td></tr>
                <?php
                    $reqachat = ModelAchats::selectallbyclient($_SESSION['numMembre']);
                    $nb = count($reqachat);
                    if($nb >= 7 )
                        $nb = 7;
                        
                    for($i = $nb; $i > 0;$i--){
                        $produit_courant = ModelProduits::selectPrimary($reqachat[$i]['numProduit']);
                ?>
                <tr>
                <td><img style="width : 70px;" src="<?php echo $produit_courant->get("imgPath") ?>"></td>
                <td> <?php echo $reqachat[$i]['qteAchat']  ?></td>
                <td> <?php echo $reqachat[$i]['DateAchat'] ?> </td>
                <td><a href="index.php?controller=achat&action=showachats&param=<?php echo $reqachat[$i]['numAchat'] ?>">voir plus</a></td></tr>
                <?php
                    }
                ?>
                <tr><td><a href="index.php?controller=achat&action=allcommande">voir toute les commandes</td></tr>
            </table>

        </div>
    </body>
</html>