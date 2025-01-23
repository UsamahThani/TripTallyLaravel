<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str class to generate UUIDs

class Trip extends Model
{
    use HasFactory;

    // Specify the custom primary key
    protected $primaryKey = 'trip_id';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the data type of the primary key
    protected $keyType = 'string'; // UUIDs are stored as strings

    // Make sure the trip_id is included in the fillable array
    protected $fillable = ['trip_id', 'user_id', 'from_location', 'dest_location', 'depart_date', 'return_date', 'person_num', 'budget'];

    // Define the relationship with places
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    // Define the relationship with the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Automatically generate a UUID when creating a new trip
    protected static function booted()
    {
        static::creating(function ($trip) {
            if (!$trip->trip_id) {
                $trip->trip_id = (string) Str::uuid(); // Generate a UUID
            }
        });
    }
}


?>