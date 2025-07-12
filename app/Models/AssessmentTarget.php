<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentTarget extends Model
{
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
