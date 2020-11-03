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
        
        if(isset($_POST['inscrit'])) {
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$nom = htmlspecialchars($_POST['nom']);
		$prenom = htmlspecialchars($_POST['prenom']);
		$mdp = sha1($_POST['mdp']);
		$mdp2 = sha1($_POST['confirmMdp']);
        $age = ceil($_POST['age']);
		if(!empty($_POST['pseudo']) AND !empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mdp']) AND !empty($_POST['confirmMdp'])) {
			$pseudolength = strlen($pseudo);
			if($pseudolength <= 255) {
                            if(strlen($_POST["mdp"]) >= 4){
                                if($mdp == $mdp2) {
								    $insertmbr = $bdd->prepare("INSERT INTO membre (pseudo, nom, prenom, mdp, age, Statut) VALUES(?, ?, ?, ?, ?, ?)");
								    $insertmbr->execute(array($pseudo, $nom, $prenom, $mdp, $age, "Inscrit"));
                                    
                                    $requser = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?");
                                    $requser->execute(array($pseudo, $mdp));
                                    $userinfo = $requser->fetch(PDO::FETCH_ASSOC);
                                    $_SESSION['id'] = $userinfo['id'];
                                    
                                    header("Location: compte.php");
                                    
							     } else {
								    $erreur = "Vos mots de passes ne correspondent pas !";
							     }
                            } else {
                                $erreur = "Votre mot de passe doit posséder au moins 4 caractères !";
                            }
			} else {
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
			}
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}
	
	$pdo = null ;
        
        ?>

        <div class="sousPartie">
            <div id="inscription">
                <h2>Inscription :</h2>
                <form method="post">

                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" id="pseudo"/>
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom"/>
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom"/>

                    <label for="mdp">Mot de passe</label>
                    <input type="password" name="mdp" id="mdp"/>
                    <label for="confirmMdp">Confirmation du mot de passe</label>
                    <input type="password" name="confirmMdp" id="confirmMdp"/>

                    <label for="age">Age</label>
                    <div class="select">
                        <select class="age" name="age">
                            <?php
                            for($i=1;$i<=99;$i++){
                                echo '<option value="$i">'.$i.'</option>';
                            }
                       ?>
                        </select>
                    </div>
                    <div id="sub">
                        <input type="submit" name="inscrit" value="Confirmer inscription"/>
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
