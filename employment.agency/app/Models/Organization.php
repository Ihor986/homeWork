<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'title',
        'country',
        'city',
        'user_id'
    ];



    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vacancy()
    {
        return $this->hasMany(Vacancy::class);
    }
}
