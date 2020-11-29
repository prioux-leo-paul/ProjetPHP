<html>
	<body>
		<div align="center">
				<h2><?php if($current_action == "register"){echo "S'enregistrer";}else{echo "Modifier mes informations ";}?></h2>
				<form method="POST" action="index.php?action=<?php if($current_action == "register"){echo "register";}else{echo "editerprofile";}?>">
					<table>
						<tr>
							<td align="right">
								<label for="pseudo">Pseudo :</label>
							</td>
							<td>
								<input type="text" value="<?php echo $pseudoMembreHTML; ?>" name="pseudo" placeholder="Votre pseudo" id="pseudo" required>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail">Mail :</label>
							</td>
							<td >
								<input type="email" value="<?php echo $mailMembreHTML; ?>" name="mail" placeholder="Votre mail" id="mail" <?php echo $primary_proprety?>>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail2">Confirmation du mail :</label>
							</td>
							<td >
								<input type="email" value="<?php echo $mailMembreHTML; ?>" name="mail2" placeholder="Confirmez votre mail" id="mail2" <?php echo $primary_proprety?>>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp">Mot de passe</label>
							</td>
							<td >
								<input type="password" value="<?php echo $mdpMembreHTML; ?>" name="mdp" placeholder="Votre mot de passe" id="mdp" required>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp2">Confirmation du mot de passe :</label>
							</td>
							<td >
								<input type="password" value="<?php echo $mdpMembreHTML; ?>" name="mdp2" placeholder="Confirmez votre mot de passe" id="mdp2" required>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
                            
								<input type="submit" <?php if($current_action == "register"){echo "value=\"je m'inscris\" name=\"forminscription\"";}else{echo "value=\"Modifier mes informations\"";}?>>
							</td>
						</tr>
					</table>

				</form>
				<br>
                <?php 
                if($current_action =="register"){
                echo "Déjà un compte ? <a href=\"index.php?action=formlogin\">Connexion</a>";
                }
                ?>
		</div>
	</body>
</html>
