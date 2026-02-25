<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'name',
        'slug',
        'description',
        'instructions',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
