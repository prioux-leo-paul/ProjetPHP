
	<body>
		<div align="center">
				<h2>Inscription</h2>
				<form method="GET" action="../controller/router.php?action=register">
					<table>
						<tr>
							<td align="right">
								<label for="pseudo">Pseudo :</label>
							</td>
							<td>
								<input type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; }?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail">Mail :</label>
							</td>
							<td >
								<input type="email" name="mail" placeholder="Votre mail" id="mail" value="<?php if(isset($mail)) { echo $mail; }?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail2">Confirmation du mail :</label>
							</td>
							<td >
								<input type="email" name="mail2" placeholder="Confirmez votre mail" id="mail2" value="<?php if(isset($mail2)) { echo $mail2; }?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp">Mot de passe</label>
							</td>
							<td >
								<input type="password" name="mdp" placeholder="Votre mot de passe" id="mdp">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp2">Confirmation du mot de passe :</label>
							</td>
							<td >
								<input type="password" name="mdp2" placeholder="Confirmez votre mot de passe" id="mdp2">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" value="je m'inscris" name="forminscription">
							</td>
						</tr>
					</table>

				</form>
                <?php
				if (isset($erreur)) {
					echo '<font color="red">'.$erreur."</font>";
				}
				?>
				<br>
				Déjà un compte ? <a href="../controller/router.php?action=formlogin">Connexion</a>
		</div>
	</body>
</html>