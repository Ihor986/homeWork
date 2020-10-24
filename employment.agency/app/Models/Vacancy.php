<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Vacancy extends Model
{
    use HasFactory, Notifiable, SoftDeletes;


    protected $fillable = [
        'vacancy_name',
        'workers_amount',
        'organization_id',
        'salary'
    ];


    // public function organizations()
    // {
    //     return $this->hasOne(Organization::class);
    // }

    // public function users()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
