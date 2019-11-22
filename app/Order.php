<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table='orders';

    protected $promaryKey='id';

    protected $fillable=[
        'uid',
        'products',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','uid');
    }
}
