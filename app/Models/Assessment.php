<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
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
