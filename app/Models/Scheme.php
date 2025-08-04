<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheme extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'scope'];
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'scheme_id');
    }
}
