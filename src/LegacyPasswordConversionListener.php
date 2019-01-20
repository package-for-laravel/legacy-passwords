<?php
/**
 * Convert the legacy password into the new laravel way
 * Deletes the old record as well
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Contracts\Hashing\Hasher;

/**
 * Class LegacyPasswordConversionListener
 * @package AaronSaray\LaravelLegacyPasswords
 */
class LegacyPasswordConversionListener
{
    /**
     * @var Hasher the hasher service
     */
    protected $hasher;

    /**
     * V1PasswordConvert constructor.
     * @param Hasher $hasher
     */
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Handle the event.
     *
     * We'll update the regular password
     *
     * @param LegacyPasswordAuthenticationEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(LegacyPasswordAuthenticationEvent $event): void
    {
        $password = $event->credentials['password'];
        $event->user->password = $this->hasher->make($password);
        $event->user->save();

        $event->user->legacyPassword()->delete();
    }
}
