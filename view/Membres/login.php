<html> 
	<body>
		<div align="center">
				<h2>Connexion</h2>
				<form method="GET" action="../controller/router.php?action=login">
					<input type="mail" name="mailconnect" placeholder="Mail">
					<input type="password" name="mdpconnect" placeholder="Mot de passe">
					<br>
					<input type="checkbox" name="rememberme" id="remembercheckbox"><label for="remembercheckbox">Se souvenir de moi</label><br>
					<input type="submit" value="Connexion" name="formconnexion">
				</form>
				<?php
				if (isset($erreur)) {
					echo '<font color="red">'.$erreur."</font>";
				}
				?>
				<br>
				Pas encore de compte ?<a href="../controller/router.php?action=formregister">S'inscrire</a>
		</div>
	</body>
</html>