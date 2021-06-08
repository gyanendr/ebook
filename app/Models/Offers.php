<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
class Offers extends Authenticatable
{
    use  Notifiable, LogsActivity;

    protected $table = 'coupon';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'spec',
        'added_by',
        'till',
        'code',
        'status'
    ];

    protected static $logAttributes = [
        'title',
        'spec',
        'added_by',
        'till',
        'code',
        'status'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Coupon';


}
