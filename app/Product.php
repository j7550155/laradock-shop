<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products', 'descr', 'photo','price','count','status','Tags',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];

   
}
