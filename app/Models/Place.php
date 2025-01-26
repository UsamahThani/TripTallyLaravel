<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Place extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['trip_id', 'place_id', 'place_name', 'place_location', 'price', 'place_type'];
    // Disable automatic timestamp handling
    public $timestamps = false;

    // Relationship with Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Ensure cart_id is automatically generated
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->cart_id)) {
                $model->cart_id = (string) Str::uuid();
            }
        });
    }



}
