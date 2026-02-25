<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'admin_user_id',
        'note',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
