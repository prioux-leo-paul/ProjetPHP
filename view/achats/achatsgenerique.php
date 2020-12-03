<?php

echo "<h2> Ma commande </h2>";
echo "<div class =\"containerProduit\">";
echo "<img src=\"" . $img. "\">";
echo "<div class=\"nomProduit\">" . $poduct_achat->get("nomProduit"). "</div>";
echo "<div class=\"descriptionProduit\">" . $poduct_achat->get("descriptionProduit") . "</div>";
echo "<div class=\"prixProduit\">" . $poduct_achat->get("prix") . " EUR</div>";
echo "<div>Taille : ".$current_achat->get("taille")."</div>";
echo "<div>Quantité : ".$current_achat->get("qteAchat")."</div>";
echo "<div>Date de l'achat : ".$current_achat->get("DateAchat")."</div>";
echo "</div>";
echo "<h2> Ma livraison </h2>";
echo "<div>Adresse de livraison : ".$livraison_achat['adresseLivraison']."</div>";
echo "<div>Date de livraison : ".$livraison_achat['dateLivraison']."</div>";
        
    ?>
