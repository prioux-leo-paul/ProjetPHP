<html> 
    <body>
        <div align="center">
                <h2>Produit</h2>
                <form method="POST" action="index.php?controller=produit&action=selectedproduitadmin">
               
                    <libellé>Quelle catégorie ?</libellé>
                    <select name="categorie">
                <?php
                    $list = ModelCategories::selectAll();
                    foreach($list as $cat){
                        ?>
                            <option value="<?php echo $cat->get("numCategorie"); ?>"><?php echo $cat->get("nomCategorie"); ?></option>
                    <?php
                    }
                ?>
                </select> 
          
                <libellé>Quelle prix ?</libellé>
                <input type="number" name="prix" min="10" max="100">
                <input type="submit" value="Rechercher" name="formfiltre">
                </form>
        </div>
    </body>
</html>