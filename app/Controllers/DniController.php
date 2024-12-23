<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class DniController extends ResourceController
{
    /**
     * Lookup DNI information using the external API
     * @param string $dni
     * @return \CodeIgniter\HTTP\Response
     */
    public function lookup($dni)
    {
        // Validate that the DNI has exactly 8 digits
        if (!preg_match('/^\d{8}$/', $dni)) {
            return $this->respond([
                'success' => false,
                'message' => 'DNI inválido. Debe tener exactamente 8 dígitos.'
            ], 400);
        }

        // API configuration
        $apiUrl = "https://api.apis.net.pe/v2/reniec/dni";
        $apiToken = getenv('DNI_API_KEY'); // Retrieve the token from the .env file

        try {
            // Setup the HTTP headers
            $headers = [
                "Authorization: Bearer $apiToken",
                "Accept: application/json",
            ];

            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$apiUrl?numero=$dni");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Execute cURL request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Decode the JSON response
            $data = json_decode($response, true);

            // Handle different HTTP response codes
            if ($httpCode === 200 && isset($data['nombres'])) {
                return $this->respond([
                    'success' => true,
                    'data' => $data
                ]);
            } elseif ($httpCode === 404) {
                return $this->respond([
                    'success' => false,
                    'message' => 'No se encontró información para el DNI ingresado.'
                ], 404);
            } else {
                return $this->respond([
                    'success' => false,
                    'message' => 'Error al consultar la API externa.',
                    'details' => $data
                ], $httpCode);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return $this->respond([
                'success' => false,
                'message' => 'Error al conectar con la API externa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
