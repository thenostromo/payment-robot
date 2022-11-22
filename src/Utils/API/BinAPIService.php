<?php

namespace App\Utils\API;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinAPIService extends BaseAPIService
{
    /**
     * @param LoggerInterface $logger
     * @param HttpClientInterface $binApiClient
     */
    public function __construct(LoggerInterface $logger, HttpClientInterface $binApiClient)
    {
        parent::__construct($logger, $binApiClient);
    }

    /**
     * @param int $bin
     * @return array
     */
    public function getItem(int $bin): array
    {
        $response = $this->executeRequest('GET', $bin);

        if (!$response || (Response::HTTP_OK !== $response->getStatusCode())) {
            return [];
        }

        return json_decode($response->getContent(), true);
    }
}
