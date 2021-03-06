<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
class Wishlist extends Authenticatable
{
    use  Notifiable, LogsActivity;

    protected $table = 'wishlist';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    protected static $logAttributes = ['user_id', 'product_id'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'AppUser';


}
