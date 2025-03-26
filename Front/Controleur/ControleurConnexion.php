<?php
// ControleurConnexion.php

namespace Controleur;

require_once 'Config.php';

use \Controleur\MethodesCurl;


class ControleurConnexion
{

    /**
     * Traite la demande de connexion.
     *
     * @param string $login    Identifiant.
     * @param string $password Mot de passe en clair.
     */
    public function processLogin(string $login, string $password): void
    {

        // Données à envoyer en POST
        $data = [
            'login'    => $login,
            'password' => $password,
        ];

        // URL de l'API de connexion
        $url = AUTHURL;

        // Appel de l'API via POST en utilisant la méthode callAPI
        $response = \Controleur\MethodesCurl::callAPI("POST", $url, $data);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);


        // Vérif si la réponse contient bien le token JWT
        if (isset($result['status_code'])) {

            if ($result['status_code'] == 400) {
                error_log("Connexion pas OK: ".$result['status_message']);
                $this->redirectWithError("".$result['status_message']);

            }
            // Stockez le token dans un cookie, valable 1 heure
            error_log("OK !:".$result['status_message']. "jwt :".$result['jwt_token']);
            $_SESSION['authentifie'] = true;
            $_SESSION['idco'] = $login;

            setcookie("jwt_token", $result['data'], time() + 600, "/");
            header("Location: Accueil.php");

        } else {
            // Gestion d'erreur : affichage du message retourné par l'API
            $this->redirectWithError("Impossible de joindre le server");
        }
    }

    /**
     * Redirige l'utilisateur vers la page de connexion avec un message d'erreur.
     *
     * @param string $messageErreur Message d'erreur à afficher.
     */
    private function redirectWithError(string $messageErreur): void
    {
        // On place le message d'erreur dans la session
        $_SESSION['messageErreur'] = $messageErreur;
        header("Location: page-connexion.php");
        exit;
    }

    public function getMessageErreur(): ? string
    {
        $message = $_SESSION['messageErreur'] ?? null;
        $_SESSION['messageErreur'] = null;
        return $message;

    }
}
