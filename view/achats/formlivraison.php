<html>
<body>
<form method="post" action="index.php?controller=achat&action=commander">
    <ul>
        <li><label>Votre adresse : </label></li>
        <li><input type="text" name="adr"></li>
        <li><label>Votre mode de livraison : </label></li>
        <li><input type="radio"  id="clasic" name="liv" value="1" checked><label for="clasic">Livraison standard</label></li>
        <li><input type="radio"  id="rap" name="liv" value="2" checked><label for="rap">Livraison 48h</label></li>
        <li><input type="submit" ></li>

    </ul>
</form>
</body>
</html>