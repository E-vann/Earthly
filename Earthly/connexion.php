<!DOCTYPE html>
<html lang="fr">

<?php
    session_start();
    require("param.inc.php") ;

    ?>

<head>
    <meta charset="UTF-8">
    <title>Earthly</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <header>
        <ul>
            <li>
                <img src="images/logo.png" alt="logo-earthly" />
            </li>
            <li>
                <a href="index.html" class="page">Acceuil</a>
            </li>
            <li>
                <a class="page">Nos Réseaux</a>
            </li>
            <li>
                <a href="compte.php" class="page">Mon Compte</a>
            </li>
        </ul>
    </header>
    <main>

        <?php
        
        $bdd =new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS) ;
	 
	if(isset($_POST['connecte'])) {
		$pseudoconnect = htmlspecialchars($_POST['pseudo']);
		$mdpconnect = sha1($_POST['mdp']);
		if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
			$requser = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?");
			$requser->execute(array($pseudoconnect, $mdpconnect));
			$userexist = $requser->rowCount();
			if($userexist == 1) {
				$userinfo = $requser->fetch(PDO::FETCH_ASSOC);
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				header("Location: compte.php");
			} else {
				$erreur = "Mauvais mail ou mot de passe !";
			}
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}
	
	$bdd = null ;
        
        ?>

        <div class="sousPartie">
            <div id="inscription">
                <h2>Inscription :</h2>
                <form method="post">

                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" />
                    
                    <label for="mdp">Mot de passe</label>
                    <input type="password" name="mdp" />

                        </select>
                    </div>
                    <div id="sub">
                        <input type="submit" name="connecte" />
                    </div>
                </form>
            </div>
            <?php
	if(isset($erreur)) {
		echo ("<font color=\"red\">".$erreur."</font>");
	}
?>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>
