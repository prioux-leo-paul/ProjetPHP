<html> 
    <body>
        <div align="center">
            <?php

            foreach($tab as $u){}
                echo  "Produit : ".$u["nomProduit"]."\n";
                echo  "Prix : ".$u["prixProduit"]."\n";
                echo "Taille : ".$u["tailleProduit"]."\n";
                echo  "Description : ".$u["descriptionProduit"]."\n";
            }

            ?>
        </div>
    </body>
</html>