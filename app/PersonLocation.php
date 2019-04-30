<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonLocation extends Model
{
    protected $fillable = ['person_id', 'latitude', 'longitude'];
//    protected $visible = ['id', 'person', 'latitude', 'longitude', 'created_at', 'updated_at'];

    public function person()
    {
        return $this->belongsTo('App\Person');
    }
}
