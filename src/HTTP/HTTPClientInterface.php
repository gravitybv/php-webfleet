<?php

declare(strict_types=1);

/**
 * Interface HTTPClientInterface
 *
 * @filesource   HTTPClientInterface.php
 * @created      14.03.2017
 * @package      Webfleet\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet\HTTP;

use Webfleet\WebfleetResponse;

/**
 * HTTP client interface for Webfleet API requests.
 */
interface HTTPClientInterface
{
    public const API_BASE = "https://csv.webfleet.com/extern/";

    /**
     * Send an HTTP request to the Webfleet API.
     *
     * @param array<string, mixed> $params
     * @param array<string, string> $headers
     */
    public function request(
        array $params = [],
        string $method = "GET",
        mixed $body = null,
        array $headers = [],
    ): WebfleetResponse;

    /**
     * Normalize HTTP headers to a consistent format.
     *
     * @param array<string, string> $headers
     * @return array<string, string>
     */
    public function normalizeHeaders(array $headers): array;
}
