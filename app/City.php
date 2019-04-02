<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * All attributed are mass assignable
     *
     * @var array
     */
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

}
