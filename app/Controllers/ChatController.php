<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        // Configura tu clave API de OpenAI aquí
        $this->apiKey = getenv('OPENAI_API_KEY');
    }

    /**
     * Maneja el envío de mensajes al API de OpenAI y retorna una respuesta.
     */
    public function sendMessage()
    {
        // Recibir el JSON del cliente
        $input = $this->request->getJSON();
    
        // Verificar si el mensaje existe en el JSON
        if (!isset($input->message) || empty(trim($input->message))) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'El mensaje no puede estar vacío.',
            ]);
        }
    
        $userMessage = trim($input->message); // Obtener el mensaje del usuario
    
        // Depuración: registrar el mensaje recibido
        log_message('debug', 'Mensaje recibido: ' . $userMessage);
    
        try {
            // Configurar la llamada a la API de OpenAI
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $userMessage]
                    ],
                    'max_tokens' => 150,
                    'temperature' => 0.7,
                ],
            ]);
    
            // Procesar la respuesta de OpenAI
            $responseData = json_decode($response->getBody(), true);
            $chatResponse = $responseData['choices'][0]['message']['content'] ?? 'No se recibió una respuesta.';
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $chatResponse,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Manejo de errores específicos de cliente
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            if ($statusCode === 429) {
                // Límite de solicitudes excedido
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Se ha excedido el límite de solicitudes a la API de OpenAI. Por favor, inténtalo más tarde.',
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al conectar con la API de OpenAI: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error inesperado: ' . $e->getMessage(),
            ]);
        }
    }
}
