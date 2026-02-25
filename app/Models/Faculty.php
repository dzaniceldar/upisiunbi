<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'contact_email',
        'contact_phone',
        'website',
        'instructions',
        'document_instructions',
        'image_path',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
