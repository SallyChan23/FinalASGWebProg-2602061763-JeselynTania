<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; 
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

    public function reverseWishlist()
    {
        return $this->hasMany(Wishlist::class, 'wishlist_user_id', 'id');
    }

    public function unreadNotificationsCount()
    {
        return Wishlist::where('wishlist_user_id', $this->id)
            ->whereDoesntHave('reverseWishlist', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->count();
    }
}


