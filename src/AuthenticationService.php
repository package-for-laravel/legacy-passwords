<?php
/**
 * This is our authentication service provider
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class AuthenticationService
 * @package AaronSaray\LaravelLegacyPasswords
 */
class AuthenticationService extends EloquentUserProvider
{
    /**
     * @var LegacyPasswordAuthenticationStrategyContract
     */
    protected $strategy;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * AuthenticationService constructor.
     * @param Dispatcher $dispatcher
     * @param LegacyPasswordAuthenticationStrategyContract $strategy
     * @param HasherContract $hasher
     * @param string $model
     */
    public function __construct(
        Dispatcher $dispatcher,
        LegacyPasswordAuthenticationStrategyContract $strategy,
        HasherContract $hasher,
        string $model
    ) {
        $this->dispatcher = $dispatcher;
        $this->strategy = $strategy;
        parent::__construct($hasher, $model);
    }

    /**
     * Validate our credentials
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        /** if empty old password, that means this will be a legacy password model */
        if (empty($user->getAuthPassword())) {
            if ($result = $this->strategy->validateCredentials($user, $credentials)) {
                $this->dispatcher->dispatch(new LegacyPasswordAuthenticationEvent($user, $credentials));
            }
        } else {
            $result = parent::validateCredentials($user, $credentials);
        }

        return $result;
    }
}
