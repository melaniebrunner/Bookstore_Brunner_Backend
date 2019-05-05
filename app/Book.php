<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Image;
use App\User;


class Book extends Model
{
    //ich muss hier beschreiben welche Properties befüllbar sind
    // alle beschreibaren Properties
    protected $fillable = [
        'isbn','title','subtitle','published', 'rating', 'description', 'price', 'user_id'
    ];
    //
    public function isFavourite() : bool {
        return $this->rating > 5;
    }

    public function images() : HasMany {
        return $this->hasMany(Image::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function authors() : BelongsToMany {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    public function orders() : BelongsToMany {
        return $this->belongsToMany(Order::class)->withPivot('price')->withTimestamps();
    }
}
