<html> 
    <body>
        <div align="center">
            <table>
                <tr><td><h2> Toutes mes commandes</h2></td></tr>
                
            </table>
            
            <table>
               <tr><td><h2>Mes <?php echo ModelAchats::nbrachatsclient($_SESSION['numMembre']) ?> commandes</h2></td></tr>
               
               <tr>
                <td>aperçu</td>
                <td>Quantité acheté</td>
                <td>Date de l'achat</td>
                <td>Voir commande</td></tr>
                <?php
                    $reqachat = ModelAchats::selectallbyclient($_SESSION['numMembre']);
                    
                        
                    foreach($reqachat as $u ){
                        $produit_courant = ModelProduits::selectPrimary($u['numProduit']);
                ?>
                <tr>
                <td><img style="width : 70px;" src="<?php echo $produit_courant->get("imgPath"); ?>"></td>
                <td> <?php echo $u['qteAchat'];  ?></td>
                <td> <?php echo $u['DateAchat']; ?> </td>
                <td><a href="index.php?controller=achat&action=showachats&param=<?php echo $u['numAchat']; ?>">voir plus</a></td></tr>
                
                <?php
                    }
                ?>
            </table>

        </div>
    </body>
</html>