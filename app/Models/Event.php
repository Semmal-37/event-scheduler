<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Schedule;

class Event extends Model
{
   protected $fillable = [
        'user_id','name','description','day_of_week','start_date','end_date'
    ];

    protected $hidden = ['created_at', 'updated_at'];


public function shedules()
    {
       return $this->hasMany(Schedule::class,'event_id','id');
    }
}
