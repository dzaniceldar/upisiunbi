<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faculty_id',
        'department_id',
        'status',
        'total_points',
        'submitted_at',
        'locked_at',
        'extraction_status',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'locked_at' => 'datetime',
        'total_points' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function grades()
    {
        return $this->hasMany(ApplicationGrade::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function adminNotes()
    {
        return $this->hasMany(AdminNote::class);
    }

    public function isEditable()
    {
        return in_array($this->status, ['Draft', 'Needs correction'], true);
    }
}
