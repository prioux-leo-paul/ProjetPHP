<?php
if(isset($_SESSION['estadmin'])){
    if($_SESSION['estadmin'] == 1){

        
        echo "
            <h2>Fiche produit admin</h2>
            <form method=\"post\" action=\"index.php?controller=produit&action=showproductadmin&param=".$current_product->get("numProduit")."\">
            
            <table>
            <tr><td><label>nom du produit : </label></td><td><input type=\"text\"  name=\"nomp\" value=\"".htmlspecialchars($current_product->get("nomProduit"))."\"/></td></tr>
            <tr><td>Categorie : ".$current_category->get("nomCategorie")."</td></tr>
            <tr><td><label>prix du produit : </label></td><td><input type=\"number\"  name=\"prixp\" size=\"7\" value=\"".htmlspecialchars($current_product->get("prix"))."\"/></td></tr>
            <tr><td><label>description du produit : </label></td><td><textarea name=\"descrip\" rows=\"5\" cols=\"33\">".$current_product->get("descriptionProduit")."</textarea></td></tr>
            <tr><td><input type=\"submit\" name=\"envoyer\"></td></tr>
            </form>";
            
        echo "
            <form method=\"post\" action=\"index.php?controller=produit&action=showproductadmin&param=".$current_product->get("numProduit")."\">
            <table>

            <tr><td>taille</td><td>stock</td><td>supprimer taille</td></tr>
        ";
            $list_taille = ModelTailles::selectAllPrimary($current_product->get("numProduit"));
            if(!empty($list_taille)){
                foreach($list_taille as $taille){
                
                    echo "
                    <tr><td>".$taille->get("taille")."</td><td></label><input type=\"number\"  name=\"q[]\" value=\"".htmlspecialchars($taille->get("stock"))."\"/></td><td><a href=\"index.php?controller=produit&action=supptailleadmin&param=".$taille->get("numtaille")."\">supp</a></td></tr>
                    <input type=\"hidden\" name=\"t[]\" value=\"".$taille->get("taille")."\">
                    ";
                }
            }
            echo "<tr><td><input type=\"submit\" name=\"envoyer2\"></td></tr>
                </table>
                </form>
            ";

            echo "
            <table>
            <tr><td><h3>Suprimer article ". $current_product->get("nomProduit")."</h3></td></tr>
            <tr><td><a href=\"index.php?controller=produit&action=supprimerarticleadmin&param=".$current_product->get("numProduit")."\">supprimer</a></td></tr>
            </table>
            
            ";

            echo "
            <table>
            <tr><td><h3>Ajouter taille ". $current_product->get("nomProduit")."</h3></td></tr>
            <tr><td>taille : </td><td><input type=\"number\" name=\"newtaille\"</td></tr>
            <tr><td>stock : </td><td><input type=\"number\" name=\"newstock\"</td></tr>
            <tr><td><input type=\"submit\" name=\"envoyer3\"></td></tr>
            </table>
            
            ";

    }
}

?>
    