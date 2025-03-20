<?php
require_once 'autoload.php';
require 'Verif-Auth.php';
use Controleur\ControleurPageModifierMatch;

$controleur = new ControleurPageModifierMatch();

//Recuperer l'identifiant du match 
$idMatch = $_GET['idMatch'];

//Si le formulaire est soumis on modifie le match
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controleur->modifierMatch($idMatch);
}

//Vaiables permettant le pré-remplissage des champs du formulaire
$match = $controleur->recupererInfosMatch($idMatch);
$date = $match->getDate();
$heure = $match->getHeure();
$adversaire = $match->getAdversaire();
$lieu = $match->getlieu();

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./CSS/Modifier-Match-Style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>
  
    <div class="main">


        <div class="infos-match-container">
            <h2>Le match</h2>
            <!-- Formulaire d'ajout d'un match -->
            <form action="Modifier-Un-Match.php?idMatch=<?php echo urlencode($idMatch); ?>" method="POST">
                <div class="match-item">
                    <label for="date-et-heure">Date et heure </label>
                    <input type="date" id="date" name="date" required value="<?php echo $date; ?>">
                    <input type="time" id="heure" name="heure" required value="<?php echo $heure; ?>">
                </div>

                <div class="match-item">
                    <label for="adversaire">Adversaire :</label>
                    <input type="text" id="adversaire" name="adversaire" placeholder="Adversaire" required value="<?php echo $adversaire; ?>">

                    <label for="lieu">Lieu :</label>
                    <select id="lieu" name="lieu" value="<?php echo $lieu; ?>">
                        <option value="dom">A domicile</option>
                        <option value="ext">Extérieur</option>
                    </select>
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