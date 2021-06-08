<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

     protected $table = 'advertisement';

    protected $fillable = ['image', 'status','price','product_id'];


    public function getProduct(){
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }   
}
