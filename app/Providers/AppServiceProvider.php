<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'lesson' => \App\Lesson::class,
            'task' => \App\Task::class,
            'answer' => \App\Answer::class
        ]);
    }
}
