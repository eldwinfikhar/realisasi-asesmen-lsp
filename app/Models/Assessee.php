<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'band',
        'entity_id',
        'assessee_type', // Assuming this is a field to differentiate internal/external assessee
    ];
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
