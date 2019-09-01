<?php
/**
 * An event to indicate that a legacy authentication has happened
 *
 * Note: we do not allow queuing here or serializing because credentials are sensitive
 */
declare(strict_types=1);

namespace PackageForLaravel\LegacyPasswords;

/**
 * Class LegacyPasswordAuthenticationEvent
 * @package PackageForLaravel\LegacyPasswords
 */
class LegacyPasswordAuthenticationEvent
{
    /**
     * @var HasLegacyPasswordContract the user who authenticated
     */
    public $user;

    /**
     * @var array the credentials from the authentication
     */
    public $credentials;

    /**
     * LegacyPasswordAuthenticationEvent constructor.
     * @param HasLegacyPasswordContract $user
     * @param array $credentials
     */
    public function __construct(HasLegacyPasswordContract $user, array $credentials)
    {
        $this->user = $user;
        $this->credentials = $credentials;
    }
}
