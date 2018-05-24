<?php

namespace App\Providers;

use App\PollCategory;

use App\Poll;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $pollCategories = PollCategory::where('is_active', '1')->get();
        $poll           = new Poll();
        $topPolls       = $poll->getTopPolls(10);
        view()->share(['pollCategories' => $pollCategories, 'topPolls' => $topPolls]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        if ($this->app->environment() == 'local') {
//            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
//        }
    }
}
