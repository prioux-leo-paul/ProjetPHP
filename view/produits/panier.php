<html>
<body>

<?php
    if(isset($_POST['q'])){
       
        $q = $_POST['q'] ;
        if (is_array($q)){
            $QteArticle = array();
            $i=0;
            foreach ($q as $contenu){
               $QteArticle[$i++] = intval($contenu);
            }
         }
         else
             $q = intval($q);

        for ($i = 0 ; $i < count($QteArticle) ; $i++)
        {
            if(round($QteArticle[$i]) != $_SESSION['panier']['qteProduit'][$i]){
                
                ControllerProduit::modifierQTeArticle($_SESSION['panier']['tailleProduit'][$i],$_SESSION['panier']['numProduit'][$i],round($QteArticle[$i]));
            }
        }
            

        
        
}
    if(empty($_SESSION['panier']['libelleProduit']))
        echo "<p> Votre panier est vide </p>";
    else{
        ?>
        <form method="post" action="index.php?controller=produit&action=voirpanier">
        <table style="width: 400px">
        <tr>
        <td colspan="4"><h2>Votre panier</h2></td>
    </tr>
    <tr>
        <td>Libellé</td>
        <td>Prix unitaire</td>
        <td>Quantité</td>
        <td>Taille</td>
        <td>Action</td>
    </tr>
    <?php
        $nbArticles=count($_SESSION['panier']['numProduit']);
        for ($i=0 ;$i < $nbArticles ; $i++){
            ?>
            <tr>
            <?php
            echo "<td> ".$_SESSION['panier']['libelleProduit'][$i]."</td>";
            echo "<td> ".$_SESSION['panier']['prixProduit'][$i]."</td>";
            echo "<td><input type=\"number\"  name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."\"/></td>";
            echo "<td> ".$_SESSION['panier']['tailleProduit'][$i]."</td>";
            echo "<td> <a href=\"index.php?controller=produit&action=supprimerArticle&param=".$_SESSION['panier']['numProduit'][$i]."\">Supprimer</a></td>"
            ?>
            </tr>
            <?php
        }
        
        ?>
        <tr><td><input type="submit" value="mettre à jour "/></td></tr>
        <table style="width: 400px">
        </form>
        <table>
        <?php
        
    }
    echo " <td><tr>Montant global : ".ControllerProduit::MontantGlobal()."</tr>";
    if(!empty($_SESSION['panier']['libelleProduit']))
        echo "<td><a href=\"index.php?controller=achat&action=formcommander\">Commander</a></tr></td>";

    
?>
        </table>
</body>
</html>