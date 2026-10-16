<?php

namespace Wegewerk\Ai3Summary\Api;

use Wegewerk\Ai3Core\Api\AbstractZakAiEndpoint;

/**
 * Implements the API Endpoint related to page summary generation
 */
class ZakAiSummary extends AbstractZakAiEndpoint
{
    protected string $endpoint = 'bulletpoints';
    protected string $responseKey = 'bulletpoints';
    protected array $requiredOptions = ['text'];
    protected array $optionalOptions = ['language'];
}
