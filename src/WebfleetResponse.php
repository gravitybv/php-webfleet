<?php

declare(strict_types=1);

/**
 * Class WebfleetResponse
 *
 * @filesource   WebfleetResponse.php
 * @created      14.03.2017
 * @package      Webfleet
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet;

use stdClass;

/**
 * @property array<string, mixed> $headers
 * @property string $body
 * @property stdClass|array<mixed>|null $json
 * @property float|null $request_time
 * @property float|null $response_time
 */
class WebfleetResponse extends Container
{
    /**
     * @var array<string, mixed>
     */
    protected array $headers = [];

    protected float|null $request_time = null;
    protected float|null $response_time = null;

    protected string $body = '';

    public function __get(string $property): mixed
    {
        if ($property === 'json') {
            return json_decode($this->body, false);
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return false;
    }
}
