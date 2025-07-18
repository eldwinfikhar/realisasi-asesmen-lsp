<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AssessmentTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'target_count',
        'entity_id',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
