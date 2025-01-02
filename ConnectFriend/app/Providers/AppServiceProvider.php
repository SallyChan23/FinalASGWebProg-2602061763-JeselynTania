<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $unreadMessagesCount = Chat::where('receiver_id', Auth::id())
                    ->where('read', false)
                    ->count();
        
                $friendRequestsCount = Wishlist::where('wishlist_user_id', Auth::id())
                    ->whereDoesntHave('reverseWishlist', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->count();
        
                $notificationCount = $unreadMessagesCount + $friendRequestsCount;
        
                $view->with('notificationCount', $notificationCount);
            }
        });
    }
}
