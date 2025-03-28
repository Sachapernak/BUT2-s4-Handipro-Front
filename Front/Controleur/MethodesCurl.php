<?php

namespace Controleur;

class MethodesCurl
{

    public static function callAPI($method, $url, $data = null) {
        // Initialize the cURL session

        if (isset($_COOKIE['jwt_token'])) {
            $jwtToken = $_COOKIE['jwt_token'];
        } else {
            $jwtToken = "";
        }



        $curl = curl_init();

        // Set URL and return transfer as string
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        // Set HTTP method and attach data if provided
        switch (strtoupper($method)) {
            case "POST":
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                if ($data != null) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data != null) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "DELETE":
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data != null) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "GET":
            default:
                // If data exists for GET, append it to the URL as a query string
                if ($data != null) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                    curl_setopt($curl, CURLOPT_URL, $url);
                }
                break;
        }

        $headers = [
            "Authorization: Bearer " . $jwtToken,
            "Content-Type: application/json"
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the request
        $result = curl_exec($curl);

        // Error handling
        if($result === false) {
            $error = curl_error($curl);
            curl_close($curl);
        }

        // Close cURL session
        curl_close($curl);

        return $result;
    }
}