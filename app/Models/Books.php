<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Books extends Authenticatable{

    protected $table = 'books';

    protected $fillable = ['book_name', 'book_status','book_image','book_price','categories_id'];

   
}
