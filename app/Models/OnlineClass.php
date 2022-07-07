<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineClass extends Model
{
    use HasFactory;

    // Relationship
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
