<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Category extends Authenticatable
{
    use  Notifiable;
    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'category_name', 'description', 'digital', 'banner', 'data_brands', 'data_vendors', 'data_subdets'
    ];

    	public function getSubCategory(){
          return $this->hasMany(SubCategory::class, 'category', 'id');   
        }

}
