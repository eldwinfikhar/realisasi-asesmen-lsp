<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessee_id',
        'assessor_id',
        'scheme_id',
        'pre_assessment_date',
        'pre_assessment_venue',
        'assessment_date',
        'assessment_venue',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pre_assessment_date' => 'date',
        'assessment_date' => 'date',
    ];
    public function assessee()
    {
        return $this->belongsTo(Assessee::class, 'assessee_id');
    }

    public function assessor()
    {
        return $this->belongsTo(Assessor::class, 'assessor_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
