<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Authenticatable
{
    use  Notifiable , LogsActivity;

    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    
    protected $fillable = [ 'category_name', 'description', 'digital', 'banner', 'data_brands', 'data_vendors', 'data_subdets'
    ];

    protected static $logAttributes = ['category_name', 'description', 'digital', 'banner', 'data_brands', 'data_vendors', 'data_subdets'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Category';

	public function getSubCategory(){
      return $this->hasMany(SubCategory::class, 'category', 'id');   
    }

}
