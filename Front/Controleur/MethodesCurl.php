<?php

namespace Controleur;

class MethodesCurl
{
    /**
     * Envoie une requête HTTP à une API externe avec prise en charge du token JWT.
     *
     * @param string $method Méthode HTTP (GET, POST, PUT, DELETE, etc.)
     * @param string $url URL cible
     * @param array|null $data Données à envoyer (si applicable)
     * @return string Réponse brute JSON de l'API
     * @throws \Exception En cas d'échec de la requête cURL
     */
    public static function callAPI(string $method, string $url, array $data = null): string
    {
        $curl = curl_init();

        // Préparation du token JWT s'il existe
        $jwtToken = $_COOKIE['jwt_token'] ?? null;

        // Méthodes avec payload JSON
        $method = strtoupper($method);
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $jsonData = json_encode($data);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

            if ($jsonData !== null) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
            }

        } elseif ($method === 'GET' && $data !== null) {
            // Ajouter les données à l'URL pour GET
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Configuration générale cURL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Préparation des en-têtes
        $headers = ["Content-Type: application/json"];
        if (!empty($jwtToken)) {
            $headers[] = "Authorization: Bearer $jwtToken";
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Exécution de la requête
        $result = curl_exec($curl);

        // Gestion d'erreur cURL
        if ($result === false) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Erreur cURL : $error");
        }

        curl_close($curl);
        return $result;
    }
}
