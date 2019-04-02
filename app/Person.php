<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $fillable = ['city_id', 'last_name', 'first_name', 'second_name', 'email', 'phone'];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function personLocations()
    {
        return $this->hasMany('App\PersonLocation');
    }

    public function getFullNameAttribute()
    {

        return implode([$this->last_name, $this->first_name, $this->second_name], ' ');
    }

}
