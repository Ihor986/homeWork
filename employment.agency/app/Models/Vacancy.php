<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;


    public function organizations()
    {
        return $this->hasOne(Organization::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
