<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTracker extends Model
{
    use HasFactory;

    public function workouts() {
        return $this->hasMany('App\Models\WorkoutDone');
    }

}
