<?php

namespace App\Utils\API;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BaseAPIService
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    /**
     * @param LoggerInterface $logger
     * @param HttpClientInterface $client
     */
    public function __construct(LoggerInterface $logger, HttpClientInterface $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface|null
     */
    protected function executeRequest(string $method, string $url, array $options = []): ?ResponseInterface
    {
        try {
            return $this->client->request($method, $url, $options);
        } catch (TransportExceptionInterface|ServerExceptionInterface
            |RedirectionExceptionInterface|ClientExceptionInterface $exception
        ) {
            $this->logger->critical($exception->getTraceAsString());
        }

        return null;
    }
}
