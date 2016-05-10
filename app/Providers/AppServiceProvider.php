<?php

namespace App\Providers;

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
        \Blade::setContentTags('{{{', '}}}');
        \Blade::setEscapedContentTags('{{', '}}');
        \Blade::setEchoFormat('nl2br(e(%s))');
        
        \Form::component('checklist', 'components.form.checklist', ['name', 'options']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
