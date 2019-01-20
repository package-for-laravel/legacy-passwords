<?php
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords\Test;

use AaronSaray\LaravelLegacyPasswords\AuthenticationService;
use AaronSaray\LaravelLegacyPasswords\HasLegacyPasswordContract;
use AaronSaray\LaravelLegacyPasswords\LegacyPasswordAuthenticationEvent;
use AaronSaray\LaravelLegacyPasswords\LegacyPasswordAuthenticationStrategyContract;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class AuthenticationServiceTest
 * @package AaronSaray\LaravelLegacyPasswords\Test
 */
class AuthenticationServiceTest extends TestCase
{
    /**
     * @var Dispatcher|MockInterface
     */
    protected $dispatcherMock;

    /**
     * @var Hasher|MockInterface
     */
    protected $hasherMock;

    /**
     * @var string
     */
    protected $model = 'my-model';

    /**
     * @var LegacyPasswordAuthenticationStrategyContract|MockInterface
     */
    protected $strategyMock;
    
    public function setUp()
    {
        parent::setUp();
        $this->dispatcherMock = mock(Dispatcher::class);
        $this->hasherMock = mock(Hasher::class);
        $this->strategyMock = mock(LegacyPasswordAuthenticationStrategyContract::class);
    }

    public function testValidateRegularUser(): void
    {
        $user = new User();
        $user->password = 'my-password-hash';
        $credentials = ['password' => 'my-password'];

        $this->hasherMock->shouldReceive('check')->once()->with($credentials['password'], $user->password)->andReturnTrue();
        
        $service = new AuthenticationService($this->dispatcherMock, $this->strategyMock, $this->hasherMock, $this->model);
        $this->assertTrue($service->validateCredentials($user, $credentials));
    }
    
    public function testValidateLegacyUserFails(): void
    {
        $user = new User();
        $credentials = ['password' => 'my-password'];
        
        $this->strategyMock->shouldReceive('validateCredentials')->once()->with($user, $credentials)->andReturnFalse();

        $service = new AuthenticationService($this->dispatcherMock, $this->strategyMock, $this->hasherMock, $this->model);
        $this->assertFalse($service->validateCredentials($user, $credentials));
    }

    public function testValidateLegacyUserSucceeds(): void
    {
        $user = new class extends User implements HasLegacyPasswordContract {
            public function legacyPassword(): HasOne
            {
            }
        };

        $credentials = ['password' => 'my-password'];

        $this->strategyMock->shouldReceive('validateCredentials')->once()->with($user, $credentials)->andReturnTrue();
        $this->dispatcherMock->shouldReceive('dispatch')->once()
            ->with(\Mockery::on(function (LegacyPasswordAuthenticationEvent $event) use ($user, $credentials) {
                $this->assertEquals($user, $event->user);
                $this->assertEquals($credentials, $event->credentials);
                return true;
            }));

        $service = new AuthenticationService($this->dispatcherMock, $this->strategyMock, $this->hasherMock, $this->model);
        $this->assertTrue($service->validateCredentials($user, $credentials));
    }
}
