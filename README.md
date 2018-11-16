# Laravel Legacy Passwords

This is a tool to migrate legacy passwords in your application to the standard Laravel install.
This is particularly useful when you're rewriting a project into Laravel, but you don't want to
have users have to reset their password.

## Install

`composer require aaronsaray/laravel-legacy-passwords`

Then, run your migrations (this package registers some)

`artisan migrate`

Next, find your user model (this package is configured that you use the
default setup of the `users` table - but it doesn't matter where your
user model is or what it's named) and use the `AaronSaray\LaravelLegacyPasswords\HasLegacyPassword` trait.
Also implement the `AaronSaray\LaravelLegacyPasswords\HasLegacyPasswordContract`.

```
class User extends Authenticatable implements AaronSaray\LaravelLegacyPasswords\HasLegacyPasswordContract
{
  use AaronSaray\LaravelLegacyPasswords\HasLegacyPassword;
```

Create a Legacy Password Authentication Strategy, implement `AaronSaray\LaravelLegacyPasswords\LegacyPasswordAuthenticationStrategyContract`

Here's an example; Let's assume our old system was plain md5.

```php
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

## Todo

- unit tests!! (right now this is being tested mechanically in the projects I'm using them in)
