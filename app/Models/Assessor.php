<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'registration_number'];
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'assessor_id');
    }
}
