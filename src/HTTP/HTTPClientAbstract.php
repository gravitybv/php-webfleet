<?php

declare(strict_types=1);

/**
 * Class HTTPClientAbstract
 *
 * @filesource   HTTPClientAbstract.php
 * @created      14.03.2017
 * @package      Webfleet\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet\HTTP;

/**
 * Abstract HTTP client with common functionality.
 */
abstract class HTTPClientAbstract implements HTTPClientInterface
{
    /**
     * Normalize HTTP headers to a consistent format.
     *
     * @param array<string, string> $headers
     * @return array<string, string>
     */
    public function normalizeHeaders(array $headers): array
    {
        $normalized_headers = [];

        foreach ($headers as $key => $val) {
            if (is_numeric($key)) {
                $header = explode(":", $val, 2);

                if (count($header) === 2) {
                    $key = $header[0];
                    $val = $header[1];
                } else {
                    continue;
                }
            }

            $key = ucfirst(strtolower($key));

            $normalized_headers[$key] = trim($key) . ": " . trim($val);
        }

        return $normalized_headers;
    }
}
