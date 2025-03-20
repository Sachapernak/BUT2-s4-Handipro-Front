<?php
require_once 'autoload.php';
require 'Verif-Auth.php';
use Controleur\ControleurPageSaisieNote;

$controleur = new ControleurPageSaisieNote();

//Recuperer l'identifiant du match et du joueur 
$n_licence = $_GET['idJoueur'];
$idMatch = $_GET['idMatch'];

//Récupérer les informations du joueur
$joueur = $controleur->recupererInfosJoueur($n_licence);
$nom = $joueur->getNom();
$prenom = $joueur->getPrenom();	

//Récupérer les informations concernant la participation du joueur au match
$jouer = $controleur->recupererInfosJouer($idMatch, $n_licence);	
$note = $jouer->getNote();	

//Soumission du formulaire de  modification de la note du joueur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controleur->modifierJouer($idMatch, $n_licence);
}

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Saisie-Note-Style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>
  
    <div class="main">

        <!-- Formulaire de saisi de la note -->
        <div class="saisieNote">
            <h2> <?php echo  $nom ." ". $prenom ?></h2>
            <h3> Licence : <?php echo  $n_licence ?></h3>
            <form action="" method="POST">
                <div class="match-item">
                    <label for="note">Note</label>
                    <input type="number" name="note" min="0" max="5" step="1" placeholder="la note sur 5" value="<?php echo $note?>">
                </div>


                <div class="form-buttons">
                    <button type="submit" class="btn btn-valider">Valider</button>
                    <button type="button" class="btn btn-annuler"
                        onclick="window.location.href='Matchs.php'">Annuler</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>