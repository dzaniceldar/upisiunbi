<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'subject_id',
        'grade',
        'source',
        'confidence',
        'suggested_line',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
        'confidence' => 'decimal:2',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
