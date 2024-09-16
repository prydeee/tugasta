<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateGenre($text)
    {
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tentukan genre dari review berikut dalam bahasa Indonesia:',
                    ],
                    [
                        'role' => 'user',
                        'content' => $text,
                    ]
                ],
                'max_tokens' => 50,
                'temperature' => 0.7,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = json_decode((string) $response->getBody(), true);

        return trim($body['choices'][0]['message']['content']);
    }
}
