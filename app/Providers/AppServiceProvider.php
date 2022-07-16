<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\{AvatarObserver, ProfileObserver, ClassObserver, TaskObserver, SubmissionObserver};
use App\Models\{UserProfile, UserAvatar, OnlineClass, Task, Submission};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UserProfile::observe(ProfileObserver::class);
        UserAvatar::observe(AvatarObserver::class);
        OnlineClass::observe(ClassObserver::class);
        Task::observe(TaskObserver::class);
        Submission::observe(SubmissionObserver::class);
    }
}
