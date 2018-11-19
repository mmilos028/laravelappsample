<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * App\AuthUser
 *
 * @mixin \Eloquent
 */
class AuthUser extends Model implements AuthenticatableContract
{
    use Authenticatable;
    //protected $table = 'users';
    protected $primaryKey = 'user_id';
    private $sessionId;
    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    /*public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }*/

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    /*public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
        return null;
    }*/

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
        return 'user_ud';
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
   /* public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
        return null;
    }*/

    /**
     * Get the password for the user.
     *
     * @return string
     */
    /*public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
        return null;
    }*/

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    /*public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
        return null;
    }*/


}
