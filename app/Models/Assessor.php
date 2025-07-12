<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessor extends Model
{
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'assessor_id');
    }
}
