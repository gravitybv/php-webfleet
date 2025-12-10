<?php

declare(strict_types=1);

/**
 * Class WebfleetOptions
 *
 * @filesource   WebfleetOptions.php
 * @created      14.03.2017
 * @package      Webfleet
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet;

/**
 * @property string|null $cacert
 * @property string|null $user_agent
 * @property string|null $account
 * @property string|null $username
 * @property string|null $password
 * @property string|null $apikey
 * @property string|null $sessiontoken
 * @property string $lang
 * @property bool $useISO8601
 * @property bool $useUTF8
 * @property string $outputformat
 * @property string|null $separator
 */
class WebfleetOptions extends Container
{
    /**
     * A valid account name.
     */
    protected string|null $account = null;

    /**
     * User name within the account that is allowed to access the service.
     */
    protected string|null $username = null;

    /**
     * Password for the user name.
     */
    protected string|null $password = null;

    /**
     * This value is optional.
     */
    protected string|null $apikey = null;

    /**
     * A session identifier, that has been fetched from the server using createSession.
     * sessiontoken can be used as an alternative to account, username or password
     * to authorise further requests for a limited time (see session lifetime).
     */
    protected string|null $sessiontoken = null;

    /**
     * Language to be used for output formatting. Expressed as a two-letter language code.
     * The list of available languages is subject to change.
     *
     * Possible values: de, en, nl
     */
    protected string $lang = 'en';

    /**
     * If set to true, all date/time-relevant parameters are expected to be ISO8601-formatted
     * and all date/time result fields will be ISO8601-formatted.
     *
     * The preferred ISO 8601 compliant notation for strings that represent dates which are to be passed
     * to WEBFLEET.connect is the compact full notation with dashes and colons, optional milliseconds and time zone.
     *
     * If set to true the result will return date time values in UTC.
     * If set to false the result returns the time zone configured in the specific WEBFLEET account.
     */
    protected bool $useISO8601 = true;

    /**
     * Controls how WF.connect interprets the character encoding of URL request parameters.
     * If set to true all parameters are expected to be UTF-8 encoded.
     * If set to false all parameters are interpreted as ISO-8859-1.
     */
    protected bool $useUTF8 = true;

    /**
     * Defines the response format to be used by WEBFLEET.connect.
     *
     * Possible values: csv, json
     */
    protected string $outputformat = 'json';

    /**
     * A delimiter character identifier that indicates the
     * delimiter to be used for the output columns:
     *
     *   1 - a tab character
     *   2 - a space character
     *   3 - a comma character
     *
     * If no value is specified, a semicolon is used as
     * the delimiter for the output columns.
     *
     * This parameter is optional.
     */
    protected string|null $separator = null;
}
