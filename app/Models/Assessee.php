<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessee extends Model
{
    /**
     * Get the entity that owns the assessee.
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Get the assessments for the assessee.
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
