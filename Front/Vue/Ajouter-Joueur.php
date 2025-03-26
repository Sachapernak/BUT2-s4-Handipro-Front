<?php

require_once 'autoload.php';
require 'Verif-Auth.php';

use Controleur\ControleurPageAjouterJoueur;

//Permet l'ajout du joueur lorsque le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controleur = new ControleurPageAjouterJoueur();
    $controleur->ajouterJoueur();
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/Ajouter-Joueur-Style.css">
    <title>Handi-Team Manager</title>
</head>

<body>

    <?php include "barre-navigation.php" ?>

    <div class="main">

        <!-- Formulaire d'ajout d'un locataire-->
        <div class="form-container">
            <h2>Nouveau Joueur</h2>
            <form action="Ajouter-Joueur.php" method="POST">
                <label for="licence">N° licence :</label>
                <input type="text" id="licence" name="licence" placeholder="Licence" required>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>

                <label for="statut" >Statut :</label>
                <select id="statut" name="statut">
                    <option value="Act">Actif</option>
                    <option value="Abs">Absent</option>
                    <option value="Ble">Blessé</option>
                    <option value="Sus">Suspendu</option>
                </select>

                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>

                <label for="taille">Taille (cm) :</label>
                <input type="number" id="taille" name="taille" placeholder="cm" min="0" required>

                <label for="poids" >Poids (kg) :</label>
                <input type="number" id="poids" name="poids" placeholder="kg" min="0" required>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-valider">Valider</button>
                    <button type="button" class="btn btn-annuler" onclick="window.location.href='Joueurs.php'">Annuler</button>
                </div>
            </form>
        </div>



    </div>
</body>

</html>