<html> 
    <body>
        <div align="center">
            <table>
                <tr><td><h2>Profil de <?php echo $_SESSION['pseudoMembre'] ?></h2></td></tr>
                <tr><td><a href="index.php?action=formediterprofile">Editer mon profil</a></td>
                <td><a href="index.php?action=supprofile">Supprimer moncompte</a></td></tr>
            </table>
            
            <table>
               <tr><td><h2>Mes <?php echo ModelAchats::nbrachatsclient($_SESSION['numMembre']) ?> commandes</h2></td></tr>
               
               <tr><td>Quantité acheté</td>
                <td>Date de l'achat</td>
                <td>Voir commande</td></tr>
                <?php
                    $reqachat = ModelAchats::selectallbyclient($_SESSION['numMembre']);
                    foreach($reqachat as $u){
                ?>
                <tr><td> <?php echo $u['qteAchat']  ?></td>
                <td> <?php echo $u['DateAchat'] ?> </td>
                <td><a href="index.php?controller=achat&action=showachats&param=<?php echo $u['numAchat'] ?>">voir plus</a></td></tr>
                <?php
                    }
                ?>
            </table>

        </div>
    </body>
</html>