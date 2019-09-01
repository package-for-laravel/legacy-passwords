<?php
/**
 * Legacy Passwords
 *
 * Expect these to disappear as the users enter their new passwords
 */
declare(strict_types=1);

namespace PackageForLaravel\LegacyPasswords;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyPassword
 *
 * @package PackageForLaravel\LegacyPasswords
 * @property int $user_id
 * @property array $data
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
        'data'
    ];

    /**
     * Casting to native types
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];
}
