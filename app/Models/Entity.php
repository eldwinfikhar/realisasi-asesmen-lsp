<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function users()
    {
        return $this->hasMany(User::class, 'entity_id');
    }

    public function assessmentTargets()
    {
        return $this->hasMany(AssessmentTarget::class, 'entity_id');
    }

    public function assessees()
    {
        return $this->hasMany(Assessee::class, 'entity_id');
    }
}
