<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;


use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , LogsActivity;



    protected $table = 'user';

     protected $guard = 'customer';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'username',
        'surname',
        'email',
        'address',
        'phone',
        'password',
        'address1',
        'user_otp',
        'address2',
        'city',
        'zip',
        'langlat',
        'state',
        'country',
        'wishlist',
        'profile_pic'
        
    ];

    protected static $logAttributes = [
        'username',
        'surname',
        'email',
        'address',
        'phone',
        'password',
        'address1',
        'user_otp',
        'address2',
        'city',
        'zip',
        'langlat',
        'state',
        'country',
        'wishlist',
        'profile_pic'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'MobileApp';


}
