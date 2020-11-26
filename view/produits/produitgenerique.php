<?php

echo "
    <h2> My product ".$current_product->get("nomProduit")." de categorie ".$current_category->get("nomCategorie")."  </h2>
    <li>" . $current_product->get("descriptionProduit")."</li>
    <li>" . $current_product->get("prix")."</li>";
    ?>
    <form method="POST" action="index.php?controller=produit&action=showproduct&param=1 ">
    <label>Choisissez taille :</label>
    <select name="size">
    <?php
        $list_taille = ModelTailles::selectAllPrimary($current_product->get("numProduit"));
        foreach($list_taille as $taille){
            $taille_courante = $taille->get("taille");
            if($taille->get("stock")!=0)
                echo "<option value=\"$taille_courante\">$taille_courante</option>";
        }
    ?>
    </select> 
    <input type="submit" value="Ajouteur au panier" />
    </form> 
    <?php
        if(!empty($_POST['size'])){
            ControllerProduit::ajouterpanier($current_product,$_POST['size']);
        }
    ?>
