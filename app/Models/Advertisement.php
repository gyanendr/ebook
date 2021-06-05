<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $table = 'blog';

     
    protected $fillable = [
         
        'title',
        'summery',
        'author',   
        'description', 
        'blog_category',
        'addedBy',
        ];

    public function getAdsCategory(){
        return $this->belongsTo(AdsCategory::class, 'blog_category', 'id');
    }    
}
