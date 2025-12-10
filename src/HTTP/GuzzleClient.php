<?php

declare(strict_types=1);

/**
 * Class GuzzleClient
 *
 * @filesource   GuzzleClient.php
 * @created      08.12.2025
 * @package      Webfleet\HTTP
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\HTTP;

use Webfleet\{WebfleetException, WebfleetResponse};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;

/**
 * HTTP client implementation using Guzzle HTTP library.
 */
class GuzzleClient extends HTTPClientAbstract
{
    protected Client $client;

    /**
     * GuzzleClient constructor.
     *
     * @param array<string, mixed> $config Guzzle client configuration
     */
    public function __construct(array $config = [])
    {
        $defaultConfig = [
            'timeout' => 30,
            'connect_timeout' => 10,
            'http_errors' => false,
            'verify' => true,
        ];

        $this->client = new Client(array_merge($defaultConfig, $config));
    }

    /**
     * Send an HTTP request to the Webfleet API.
     *
     * @param array<string, mixed> $params Query parameters
     * @param array<string, string> $headers Request headers
     * @throws WebfleetException
     */
    public function request(
        array $params = [],
        string $method = "GET",
        mixed $body = null,
        array $headers = [],
    ): WebfleetResponse {
        // Extract username and password for Basic Auth
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';
        
        // Remove username and password from URL params
        unset($params['username'], $params['password']);
        
        $options = [
            GuzzleRequestOptions::QUERY => $params,
            GuzzleRequestOptions::HEADERS => $this->normalizeHeaders($headers),
        ];

        // Add Basic Auth if credentials are provided
        if (!empty($username) && !empty($password)) {
            $options[GuzzleRequestOptions::AUTH] = [$username, $password];
        }

        // Add body if provided
        if ($body !== null) {
            if (is_array($body)) {
                $options[GuzzleRequestOptions::JSON] = $body;
            } else {
                $options[GuzzleRequestOptions::BODY] = $body;
            }
        }

        try {
            $response = $this->client->request($method, self::API_BASE, $options);

            return new WebfleetResponse([
                'headers' => $response->getHeaders(),
                'body' => (string) $response->getBody(),
            ]);
        } catch (GuzzleException $e) {
            throw new WebfleetException(
                'HTTP request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
