<html>
    <body>
    <?php
    if(isset($_SESSION['estadmin'])){
        if($_SESSION['estadmin']==1){
    ?>
            <form method="post" action="index.php?controller=produit&action=ajouterproduit" enctype="multipart/form-data">
            <h2>Ajouter un produit</h2>
            <table>
            <tr>
            <td>
            <label>image :</label>
            </td>
            <td>
            <input type="file" name="photo">
            </td>
            </tr>
            <tr>
            <td>
            <label>nom du produit :</label>
            </td>
            <td>
            <input type="text" name="nom">
            </td>
            </tr>
            <tr>
            <td>
            <label>prix :</label>
            </td>
            <td>
            <input type="number" name="prix">
            </td>
            </tr>
            <tr>
            <td>
            <label>votre description :</label>
            </td>
            <td>
            <textarea name="des" ></textarea>
            </td>
            </tr>
            <tr>
            <td>
            <label>Choisissez catégorie :</label>
            </td>
            <td>
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
            </td>
            </tr>
            <tr>
            <td>
            <input type="submit" name="envoyer">
            </td>
            </tr>
            </table>
            </form>
    <?php
        if(isset($erreur))
            echo $erreur;

        echo $_POST['nom']."/".$_POST['prix']."/".$_POST['des'];
    }
    }
    ?>
    </body>
</html>