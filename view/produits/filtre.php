<html> 
    <body>
        <div align="center">
                <h2>Produit</h2>
                <form method="POST" action="index.php?controller=produit&action=">
               
                    <libellé>Quelle catégorie ?</libellé>
                    <select>
                    <option valeur="roue">Roues</option>
                    <option valeur="deck">Decks</option>
                    <option valeur="roulement">Roulements</option>
                    <option valeur="other">Autre</option>
                    </select>
          
                <libellé>Quelle prix ?</libellé>
                <input type="number" name="prix" min="10" max="100">
                </form>
        </div>
    </body>
</html>