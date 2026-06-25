<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'status',
    ];

    public function availabilities()
    {
        return $this->hasMany(StaffAvailability::class);
    }
}
