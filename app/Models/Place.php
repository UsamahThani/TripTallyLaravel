<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id', 'place_name', 'address', 'rating', 'price', 'user_rating_total', 'photo_url'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

}
