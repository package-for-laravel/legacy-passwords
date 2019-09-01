<?php
/**
 * The has legacy password contract
 */
declare(strict_types=1);

namespace PackageForLaravel\LegacyPasswords;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Interface HasLegacyPasswordContract
 * @package PackageForLaravel\LegacyPasswords
 */
interface HasLegacyPasswordContract
{
    /**
     * Has a legacy password
     * @return HasOne
     */
    public function legacyPassword(): HasOne;
}
