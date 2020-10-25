<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'title',
        'country',
        'city'
    ];



    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function vacancy()
    // {
    //     return $this->hasMany(Vacancy::class, 'foreign_key');
    // }
}
