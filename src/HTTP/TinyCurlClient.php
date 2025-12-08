<?php

declare(strict_types=1);

/**
 * Class TinyCurlClient
 *
 * @filesource   TinyCurlClient.php
 * @created      14.03.2017
 * @package      Webfleet\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet\HTTP;

use Webfleet\{WebfleetException, WebfleetResponse};
use chillerlan\TinyCurl\{Request, RequestOptions, URL, URLException};

/**
 * HTTP client implementation using TinyCurl library.
 */
class TinyCurlClient extends HTTPClientAbstract
{
    protected Request $request;

    /**
     * TinyCurlClient constructor.
     */
    public function __construct(RequestOptions $requestOptions)
    {
        $this->request = new Request($requestOptions);
    }

    /**
     * Send an HTTP request to the Webfleet API.
     *
     * @param array<string, mixed> $params
     * @param array<string, string> $headers
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
        
        // Add Basic Auth header if credentials are provided
        if (!empty($username) && !empty($password)) {
            $headers['Authorization'] = 'Basic ' . base64_encode($username . ':' . $password);
        }
        
        try {
            $url = new URL(
                self::API_BASE,
                $params,
                $method,
                $body,
                $this->normalizeHeaders($headers),
            );
        } catch (URLException $e) {
            throw new WebfleetException("invalid URL: " . $e->getMessage());
        }

        $response = $this->request->fetch($url);

        return new WebfleetResponse([
            "headers" => $response->headers,
            "body" => $response->body->content,
        ]);
    }
}
