<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Blog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blog';

     
    protected $fillable = [
         
        'title',
        'summery',
        'author',   
        'description', 
        'blog_category',
        'addedBy',
        ];

    protected static $logAttributes = [
        'title',
        'summery',
        'author',   
        'description', 
        'blog_category'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Blog';    

    public function getAdsCategory(){
        return $this->belongsTo(BlogCategory::class, 'blog_category', 'id');
    }    
}
