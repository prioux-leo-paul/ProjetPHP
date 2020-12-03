<html> 
    <body>
        <div align="center">
                <h2>Editer profile</h2>
                <form method="POST" action="index.php?action=editerprofile">
                <table>
						
						<tr>
							<td align="right">
								<label for="newpseudo">Pseudo :</label>
							</td>
							<td>
								<input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $_SESSION['pseudoMembre']?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="newmail">Mail :</label>
							</td>
							<td >
								<input type="email" name="newmail" placeholder="Mail" value="<?php echo $_SESSION['mailMembre']?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="newmdp1">Mot de passe</label>
							</td>
							<td >
								<input type="password" name="newmdp1" placeholder="Mot de passe" >
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="newmdp2">Confirmation du mot de passe :</label>
							</td>
							<td >
								<input type="password" name="newmdp2" placeholder="Confirmation du mot de passe">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" value="Mettre à jour">
							</td>
						</tr>
					</table>
                </form>
               
        </div>
    </body>
</html>