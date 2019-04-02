<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
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


    public function cities()
    {
        return $this->hasMany('App\City');
    }

}
