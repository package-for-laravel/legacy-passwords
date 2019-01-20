<?php
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords\Test;

use AaronSaray\LaravelLegacyPasswords\HasLegacyPasswordContract;
use AaronSaray\LaravelLegacyPasswords\LegacyPasswordAuthenticationEvent;
use AaronSaray\LaravelLegacyPasswords\LegacyPasswordConversionListener;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Hashing\Hasher;

/**
 * Class AuthenticationServiceTest
 * @package AaronSaray\LaravelLegacyPasswords\Test
 */
class LegacyPasswordConversionListenerTest extends TestCase
{
    public function testListenerSavesNewPassword(): void
    {
        $credentials = ['password' => 'my-password'];
        $hasOneMock = mock(HasOne::class);
        $hasOneMock->shouldReceive('delete')->once();
        $userMock = mock(HasLegacyPasswordContract::class);
        $userMock->shouldReceive('save')->once();
        $userMock->shouldReceive('legacyPassword')->once()->andReturn($hasOneMock);
        $hasherMock = mock(Hasher::class);
        $hasherMock->shouldReceive('make')->once()->with($credentials['password'])->andReturn('this is a hash');
        
        $event = new LegacyPasswordAuthenticationEvent($userMock, $credentials);       
        
        $listener = new LegacyPasswordConversionListener($hasherMock);
        $listener->handle($event);
        $this->assertEquals('this is a hash', $userMock->password);
    }
}
