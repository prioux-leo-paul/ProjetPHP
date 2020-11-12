<html> 
    <body>
        <div align="center">
                <h2>Connexion</h2>
                <form method="POST" action="index.php?action=login">
                    <input type="mail" name="mailconnect" placeholder="Mail">
                    <input type="password" name="mdpconnect" placeholder="Mot de passe">
                    <br>
                    <input type="checkbox" name="rememberme" id="remembercheckbox"><label for="remembercheckbox">Se souvenir de moi</label><br>
                    <input type="submit" value="Connexion" name="formconnexion">
                </form>
                <br>
                Pas encore de compte ?<a href="index.php?action=formregister">S'inscrire</a>
        </div>
    </body>
</html>