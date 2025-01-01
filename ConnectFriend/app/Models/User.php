<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // Ensure it uses the correct table
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'field_of_work',
        'linkedin_username',
        'mobile_number',
        'registration_fee',
        'profession', 
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}


