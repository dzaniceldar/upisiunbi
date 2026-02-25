<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'code',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class);
    }

    public function applicationGrades()
    {
        return $this->hasMany(ApplicationGrade::class);
    }
}
