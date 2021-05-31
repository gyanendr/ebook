<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Offers extends Authenticatable
{
    use  Notifiable;
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


}
