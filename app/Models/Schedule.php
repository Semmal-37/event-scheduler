<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Event;
use App\Models\Schedule;

class Schedule extends Model
{
   protected $fillable = [
        'event_id','start_time','end_time'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function event()
    {

    return $this->belongsTo(Event::class, 'event_id','id');

     }
}
