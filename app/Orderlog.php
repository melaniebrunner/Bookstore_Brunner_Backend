<?php

namespace App;
use App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orderlog extends Model
{
    protected $fillable = [
        'comment','comment_admin','state','username', 'order_id'
    ];

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }

}
