<!DOCTYPE html>
<html lang="fr">

<?php
    session_start();
    require("param.inc.php") ;

    $bdd =new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS) ;
    
	if(isset($_SESSION["id"])){
        $requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
        $requser->execute(array($_SESSION['id']));
        $user = $requser->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
    if(isset($_POST["save"])){
        if(isset($_FILES['pdp']) AND !empty($_FILES['pdp']['name']))
        {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'png');
        if($_FILES['pdp']['size'] <= $tailleMax)
        {
            $extensionUpload = strtolower(substr(strrchr($_FILES['pdp']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides))
            {
                $chemin = "pdp/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['pdp']['tmp_name'], $chemin);
                if($resultat)
                {
                    $updatePdp = $bdd->prepare('UPDATE membre SET pdp = ? WHERE id = ?');
                    $updatePdp->execute(array($_SESSION['id'].".".$extensionUpload, $_SESSION['id'] ));
                    $msg = "Photo de profil bien importé";
                }
                else
                {
                    $msg = "Erreur durant l'importation de votre photo de profil";
                }
            }
            else
            {
                $msg = "Votre photo de profil doit être au format jpg, jpeg ou png";
            }
        }
        else
        {
            $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
        }
    }
    }
        
        $pdo = null ;
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
                <a href="compte.php" class="page active">Mon Compte</a>
            </li>
        </ul>
    </header>
    <main>
        <?php
       if(isset($_POST['deco'])){
           session_destroy();
           header('Location: compte.php');
       }
        ?>

        <?php
        if(isset($_SESSION["id"])){
        ?>

        <div id="photoProfil">
            <img src="images/profil.png" alt="profil-earthly" />
            <div class="editionImg">
               <label for="pdp">Photo de profil</label>
                <input type="file" id="pdp" value="Photo de profil"/>
            </div>
        </div>
        <div class="sousPartie" id="compte">
            <h2>Pseudo : <?php echo($user["pseudo"]) ?></h2>
            <h2>Nom / Prénom : <?php echo($user["nom"]." / ".$user["prenom"]) ?></h2>
            <h2>Age : <?php echo($user["age"]) ?></h2>
            <h2>Statut : <?php echo($user["Statut"]) ?></h2>
            <form action="compte.php" method="post">
                <input type="submit" name="save" value="Save User" />
            </form>
        </div>



        <form action="compte.php" method="post">
            <input type="submit" name="deco" value="deconnexion" />
        </form>

        <?php
        }else{
        ?>

        <div class="sousPartie" id="inscriptionConnexion">
            <p>Pas encore inscrit ?</p>
            <a href="inscription.php">Inscrivez-vous</a>
            <p>Déjà inscrit ?</p>
            <a href="connexion.php">Connectez-vous</a>
        </div>

        <?php
        }
        ?>

    </main>
    <footer>

    </footer>
</body>

</html>
