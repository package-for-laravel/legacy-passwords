<?php
/**
 * An event to indicate that a legacy authentication has happened
 * 
 * Note: we do not allow queuing here or serializing because credentials are sensitive
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class LegacyPasswordAuthenticationEvent
 * @package AaronSaray\LaravelLegacyPasswords
 */
class LegacyPasswordAuthenticationEvent
{
    /**
     * @var Authenticatable the user who authenticated
     */
    public $user;

    /**
     * @var array the credentials from the authentication
     */
    public $credentials;
    
    /**
     * LegacyPasswordAuthenticationEvent constructor.
     * @param Authenticatable $user
     * @param array $credentials
     */
    public function __construct(Authenticatable $user, array $credentials)
    {
        $this->user = $user;
        $this->credentials = $credentials;
    }
}