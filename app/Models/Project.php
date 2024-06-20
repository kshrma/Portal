<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   // Make sure the model points to the correct table

    protected $fillable = ['name']; // Define fillable attributes if needed
}
