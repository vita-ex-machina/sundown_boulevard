<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reservation_date',
        'start_time',
        'end_time',
        'number_people',
        'drink_name',
        'dish_name'
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the tables that belongs to the reservation.
     */
    public function tables()
    {
        return $this->belongsToMany('App\Models\Table');
    }
}
