<?php
/**
 * The contract that indicates that we can authenticate our legacy password
 */
declare(strict_types=1);

namespace PackageForLaravel\LegacyPasswords;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Interface LegacyPasswordAuthenticationStrategyContract
 * @package PackageForLaravel\LegacyPasswords
 */
interface LegacyPasswordAuthenticationStrategyContract
{
    /**
     * Are these credentials valid or not
     *
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool;
}
