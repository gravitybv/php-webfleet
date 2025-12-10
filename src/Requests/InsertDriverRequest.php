<?php

declare(strict_types=1);

namespace Webfleet\Requests;

/**
 * Class InsertDriverRequest
 *
 * Represents the parameters required for the insertDriverExtern endpoint.
 */
class InsertDriverRequest
{
    /** @var string|null Additional driver name. */
    public ?string $name2 = null;

    /** @var string|null Additional driver name. */
    public ?string $name3 = null;

    /** @var string|null Company name. */
    public ?string $company = null;

    /** @var string|null Description. */
    public ?string $description = null;

    /** @var string|null Address number. */
    public ?string $addrno = null;

    /** @var string|null Country code (ISO 3166-1 alpha-2). */
    public ?string $country = null;

    /** @var string|null ZIP code. */
    public ?string $zip = null;

    /** @var string|null City name. */
    public ?string $city = null;

    /** @var string|null Street name. */
    public ?string $street = null;

    /** @var string|null Mobile phone number. */
    public ?string $telmobile = null;

    /** @var string|null Private phone number. */
    public ?string $telprivate = null;

    /** @var int|null Driver PIN. */
    public ?int $pin = null;

    /** @var string|null Email address. */
    public ?string $email = null;

    /** @var string|null Driver card ID. */
    public ?string $dt_cardid = null;

    /** @var string|null Driver card country (ISO 3166-1 alpha-2). */
    public ?string $dt_cardcountry = null;

    /** @var string|null Remote LINK/ID key identifier. */
    public ?string $rll_buttonid = null;

    /** @var string|null Driver key identifier. */
    public ?string $driver_key = null;

    /** @var string|null Driving license number. */
    public ?string $license_number = null;

    /** @var string|null Driving license country (ISO 3166-1 alpha-2). */
    public ?string $license_country = null;

    /** @var string|null Driving license issuing state. */
    public ?string $license_state = null;

    /** @var string|null Driving license issue date. */
    public ?string $license_issue_date = null;

    /** @var string|null Driving license expiry date. */
    public ?string $license_expiry_date = null;

    /** @var string|null Driving license type. */
    public ?string $license_type = null;

    /**
     * Constructor to initialize required fields.
     *
     * @param string $driverno Account-unique driver number, case-sensitive.
     * @param string $name Driver name.
     */
    public function __construct(
        public string $driverno,
        public string $name
    ) {}
}