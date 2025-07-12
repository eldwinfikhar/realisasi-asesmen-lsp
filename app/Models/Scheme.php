<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'scheme_id');
    }
}
