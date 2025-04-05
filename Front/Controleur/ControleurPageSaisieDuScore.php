<?php

namespace Controleur;
require_once 'Config.php';

class ControleurPageSaisieDuScore
{
    /**
     * Constructeur de la classe.
     */
    public function __construct() {}

    /**
     * Enregistre le score d'un match dans la base de données après qu'il ait été soumis via un formulaire.
     *
     * @param int $id_match L'identifiant du match dont le score doit être saisi.
     * @return void
     */
    public function saisirScore($id_match): void
    {
        $score = $_POST['resultat'];

        $scoreArray = [
            "resultat" => $score,
        ];

        $url = BACKURL . "matchs/$id_match/score";
        \Controleur\MethodesCurl::callAPI("PATCH", $url, $scoreArray);
        header('Location: Matchs.php');
        exit;
    }

    /**
     * Récupère les informations d'un match selon son identifiant.
     *
     * @param int $idMatch Identifiant du match.
     * @return array|null Détails du match ou null si non trouvé.
     */
    public function recupererInfosMatch($idMatch): ?array
    {
        $url = BACKURL . "matchs/$idMatch";
        $response = \Controleur\MethodesCurl::callAPI("GET", $url);
        $result = json_decode($response, true);
        return $result["data"] ?? null;
    }

    /**
     * Affiche une description du lieu du match en fonction de sa valeur.
     *
     * @param string $lieu Le lieu du match ('ext' pour extérieur, 'dom' pour domicile).
     * @return string Le texte décrivant le lieu du match.
     */
    public function afficherLieu(?string $lieu): string
    {
        return match ($lieu) {
            'ext' => 'Extérieur',
            'dom' => 'A domicile',
            default => '',
        };
    }
}
