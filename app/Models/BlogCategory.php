<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blog_category';

    protected $fillable = ['name'];

    protected static $logAttributes = ['name'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'BlogCategory';
}
