# Laravel Legacy Passwords

```
ARCHIVED: This project is archived and no longer maintained.
```

This is a tool to migrate legacy passwords in your application to the standard Laravel install.
This is particularly useful when you're rewriting a project into Laravel, but you don't want to
have users have to reset their password.

## Install

This project requires Laravel 5.8+.

`composer require package-for-laravel/legacy-passwords`

Then, run your migrations (this package registers some)

`artisan migrate`

Next, find your user model (this package is configured that you use the
default setup of the `users` table - but it doesn't matter where your
user model is or what it's named) and use the `PackageForLaravel\LegacyPasswords\HasLegacyPassword` trait.
Also implement the `PackageForLaravel\LegacyPasswords\HasLegacyPasswordContract`.

```
use PackageForLaravel\LegacyPasswords\HasLegacyPasswordContract;
use PackageForLaravel\LegacyPasswords\HasLegacyPassword;

class User extends Authenticatable implements HasLegacyPasswordContract
{
  use HasLegacyPassword;
```

Create a Legacy Password Authentication Strategy, implement `PackageForLaravel\LegacyPasswords\LegacyPasswordAuthenticationStrategyContract`

Here's an example; Let's assume our old system was plain md5.

```php
use PackageForLaravel\LegacyPasswords\LegacyPasswordAuthenticationStrategyContract;

class MyLegacyPasswordAuthenticationStrategy implements LegacyPasswordAuthenticationStrategyContract
{
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $password = $credentials['password'];
        $hashed = md5($password);

        return $user->legacyPassword->data['md5'] === $hashed;
    }
}
```

Then, bind that into Laravel.  For example, you might do this in the `AuthServiceProvider`:

```
$this->app->bind(LegacyPasswordAuthenticationStrategyContract::class, function() {
    return new MyLegacyPasswordAuthenticationStrategy();
});
```

Remember, you can inject requirements into your strategy here if you need to.

Finally, modify your `config/auth.php` key `providers.users.driver` to be `laravel-legacy-passwords` so that
we can inject this authentication system instead of the standard one.

How do you create the legacy passwords? Easy.  Something like this:

```
$user = User::create(); // you created this with your legacy data
$user->legacyPassword()->create([
    'data' => [
        'md5' => $oldUser['md5']
    ]
]);
```

You can include anything you need for your strategy in the `data` key.

## Credits

This package is created and maintained by [Aaron Saray](https://github.com/aaronsaray) 
