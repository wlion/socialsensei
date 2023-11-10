<?php

class OpenAIApiClient {
    private $apiKey;
    private $apiUrl = 'https://api.openai.com/v1/';
    private $temperature = 0.5;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Sends API call to chat completions endpoint and returns
     * 
     * @param array $messages
     * @param float $temperature
     * @param string $model
     * 
     * @return object
     */
    public function generateChatCompletion($messages, $temperature = null, $model = 'gpt-3.5-turbo') {
        $endpoint = 'chat/completions';
        $data     = [
            'model'    => $model,
            'messages' => $messages,
            'temperature' => empty($temperature) ? $this->temperature : $temperature,
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];

        $ch = curl_init($this->apiUrl . $endpoint);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->logError($endpoint, $data, $headers, curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Log errors for debugging
     * 
     * @param string $endpoint
     * @param array|object $data
     * @param array|object $headers
     * @param string $error
     * 
     * @return void
     */
    private function logError($endpoint, $data, $headers, $error) {
        $upload_dir = wp_upload_dir();
        $logFileName = 'opai-' . date('Y-m-d') . '.log';
        $logFilePath = $upload_dir['basedir'] . '/' . $logFileName;

        $logMessage = '[' . date('Y-m-d H:i:s') . '] Endpoint: ' . $endpoint . PHP_EOL;
        $logMessage .= 'Request Data: ' . json_encode($data) . PHP_EOL;
        $logMessage .= 'Request Headers: ' . json_encode($headers) . PHP_EOL;
        $logMessage .= 'Error: ' . $error . PHP_EOL;
        $logMessage .= '----------------------------------------' . PHP_EOL;

        file_put_contents($logFilePath, $logMessage, FILE_APPEND | LOCK_EX);
    }
}
