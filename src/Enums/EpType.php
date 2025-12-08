<?php

declare(strict_types=1);

/**
 * EpType Enumeration
 *
 * @filesource   EpType.php
 * @created      27.10.2025
 * @package      Webfleet\Enums
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Eco Periphery (OBDII dongle) type enumeration.
 *
 * Valid values for ep_type field.
 */
enum EpType: int
{
    case ECO_PLUS = 1;
    case LINK_105 = 2;

    /**
     * Get the human-readable label for the EP type.
     */
    public function label(): string
    {
        return match($this) {
            self::ECO_PLUS => 'ecoPLUS',
            self::LINK_105 => 'LINK 105',
        };
    }

    /**
     * Get all EP type cases.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        return self::cases();
    }
}
