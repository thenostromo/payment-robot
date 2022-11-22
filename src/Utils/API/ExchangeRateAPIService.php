<?php

namespace App\Utils\API;

use JetBrains\PhpStorm\Pure;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateAPIService extends BaseAPIService
{
    public const API_SERVICE_PREFIX = 'exchangerates_data';

    /**
     * @param LoggerInterface $logger
     * @param HttpClientInterface $exchangeRateApiClient
     */
    #[Pure]
    public function __construct(LoggerInterface $logger, HttpClientInterface $exchangeRateApiClient)
    {
        parent::__construct($logger, $exchangeRateApiClient);
    }

    /**
     * @return array
     */
    public function getItemList(): array
    {
        $response = $this->executeRequest('GET', self::API_SERVICE_PREFIX.'/latest');

        if (!$response || (Response::HTTP_OK !== $response->getStatusCode())) {
            return [];
        }

        return json_decode($response->getContent(), true);
    }
}
