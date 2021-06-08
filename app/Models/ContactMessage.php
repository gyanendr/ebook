<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class ContactMessage extends Authenticatable
{
    use  Notifiable;

    protected $table = 'contact_message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'subject',
        'email',
        'timestamp',
        'message',
        'view',
        'reply',
        'other',
    ];

}
