<?php

declare(strict_types=1);

namespace Inisiatif\Package\Tracking;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Inisiatif\Package\Tracking\ObjectValue\Tracking;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Inisiatif\Package\Tracking\Input\CreateEventInput;
use Inisiatif\Package\Tracking\Input\CreateTrackingInput;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

final class TrackingClient
{
    public const API_VERSION = 'v1';

    private Credentials $credentials;

    private HttpClientInterface $httpClient;

    public function __construct(Credentials $credentials, ?HttpClientInterface $httpClient = null)
    {
        $this->credentials = $credentials;
        $this->httpClient = $httpClient === null ? HttpClient::createForBaseUri('https://trackingapi.inisiatif.id', [
            'auth_basic' => [$this->credentials->getKey(), $this->credentials->getSecret()],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]) : $httpClient;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function createTracking(CreateTrackingInput $input): Tracking
    {
        $response = $this->executeRequest($input->request());

        $data = $response->toArray();

        return Tracking::fromArray($data['data']);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function createEvent(CreateEventInput $input): void
    {
        $this->executeRequest($input->request());
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function executeRequest(Request $request): ResponseInterface
    {
        return $this->httpClient->request($request->getMethod(), $this->getEndPoint($request), [
            'json' => $request->getParams(),
            'query' => $request->getQuery(),
        ]);
    }

    private function getEndPoint(Request $request): string
    {
        $endPoint = '/api/' . self::API_VERSION . '/' . $request->getEndPoint();

        return \str_replace('//', '/', $endPoint);
    }
}
