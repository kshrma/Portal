<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'role', 'environments'];

    // If 'environments' is stored as JSON in the database, you can cast it to an array
    protected $casts = [
        'environments' => 'array',
    ];
}
