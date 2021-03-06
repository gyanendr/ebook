<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
class SubCategory extends Authenticatable
{
    use  Notifiable , LogsActivity;
    protected $table = 'sub_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sub_category_name','category','brand','digital','banner','affiliation','affiliation_points'
    ];

    public function getCategory(){
    	return $this->hasOne(Category::class, 'id', 'category');
    } 

    public function subcategory(){
        return $this->belongsTo(Category::class);
    }

    protected static $logAttributes = ['sub_category_name','category','brand','digital','banner','affiliation','affiliation_points'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'SubCategory';


}
