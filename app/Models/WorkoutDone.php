<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutDone extends Model
{
    use HasFactory;

    public function trackers() {
        return $this->belongsTo('App\Models\UserTracker');
    }

}
