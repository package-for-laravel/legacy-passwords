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

```
class User extends Authenticatable
{
  use AaronSaray\LaravelLegacyPasswords\HasLegacyPassword;
```

