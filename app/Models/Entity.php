<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'entity_id');
    }

    public function assessmentTargets()
    {
        return $this->hasMany(AssessmentTarget::class, 'entity_id');
    }
}
