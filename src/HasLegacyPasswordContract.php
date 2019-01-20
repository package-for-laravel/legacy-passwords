<?php
/**
 * The has legacy password contract
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Interface HasLegacyPasswordContract
 * @package AaronSaray\LaravelLegacyPasswords
 */
interface HasLegacyPasswordContract
{
    /**
     * Has a legacy password
     * @return HasOne
     */
    public function legacyPassword(): HasOne;
}
