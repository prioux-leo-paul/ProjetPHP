<html> 
    <body>
        <div align="center">
                <h2>Produit</h2>
                <form method="POST" action="index.php?controller=produit&action=selectedproduit">
               
                    <libellé>Quelle catégorie ?</libellé>
                    <select name="categorie">
                    <option value="1">Roues</option>
                    <option value="2">Decks</option>
                    <option value="3">Roulements</option>
                    <option value="4">Autre</option>
                    </select>
          
                <libellé>Quelle prix ?</libellé>
                <input type="number" name="prix" min="10" max="100">
                <input type="submit" value="Rechercher" name="formfiltre">
                </form>
        </div>
    </body>
</html>