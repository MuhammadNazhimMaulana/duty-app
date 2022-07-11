<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Relationship
    public function onlineClasses()
    {
        return $this->belongsToMany(OnlineClass::class);
    }
}
