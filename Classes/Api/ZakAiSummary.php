<?php

namespace Wegewerk\Ai3Summary\Api;

use Wegewerk\Ai3Core\Api\ZakAiClient;
use Wegewerk\Ai3Core\Api\ZakAiEndpointInterface;

/**
 * Implemets the API Endpoint related to page summary generation
 */
class ZakAiSummary implements ZakAiEndpointInterface
{
    public function __construct(private ZakAiClient $client) {}

    public function generate(string $imagePath, string $description, string $language): string
    {
        $response = $this->client->postJson(
            'bulletpoints',
            [
                'text'     => $description,
                'language' => $language ?? 'de',
            ]
        );
        return $response['bulletpoints'] ?? '';
    }

}
