<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table='posts';

    protected $promaryKey='id';

    protected $fillable=[
        'uid',
        'title',
        'Tags',
        'content',
    ];

   
}
