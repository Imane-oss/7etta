<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function ($view) {
            $settingsFile = 'settings.json';
            $settings = \Illuminate\Support\Facades\Storage::exists($settingsFile) 
                ? json_decode(\Illuminate\Support\Facades\Storage::get($settingsFile), true) 
                : [];
            
            $messagesFile = 'messages.json';
            $messages = \Illuminate\Support\Facades\Storage::exists($messagesFile) 
                ? json_decode(\Illuminate\Support\Facades\Storage::get($messagesFile), true) 
                : [];
            
            $unreadCount = collect($messages)->where('read', false)->count();
            
            $view->with('siteSettings', $settings);
            $view->with('unreadMessagesCount', $unreadCount);
        });
    }
}
