<?php
/**
 * Legacy Passwords
 *
 * Expect these to disappear as the users enter their new passwords
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyPassword
 *
 * @package AaronSaray\LaravelLegacyPasswords
 * @property int $user_id
 */
class LegacyPassword extends Model
{
    /**
     * @var string the table name
     */
    protected $table = 'user_legacy_passwords';

    /**
     * @var string The primary ID of this item
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'passwordData'
    ];
}
