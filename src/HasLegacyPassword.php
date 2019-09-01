<?php
/**
 * This trait is required for adding the relationships to the legacy password
 */
declare(strict_types=1);

namespace PackageForLaravel\LegacyPasswords;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait HasLegacyPassword
 * @package PackageForLaravel\LegacyPasswords
 */
trait HasLegacyPassword
{
    /**
     * Has a legacy password
     * @return HasOne
     */
    public function legacyPassword(): HasOne
    {
        return $this->hasOne(LegacyPassword::class);
    }
}
