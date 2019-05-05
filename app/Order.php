<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Orderlog;

class Order extends Model
{
    protected $fillable = [
        'net_amount','gross_amount','state','delivery_address', 'user_id'
    ];

    public function books() : BelongsToMany {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }

    public function orderlogs() : HasMany {
        return $this->hasMany(Orderlog::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

}
