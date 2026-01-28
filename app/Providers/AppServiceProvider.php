<?php

namespace App\Providers;

use App\Repository\CategoryRepository;
use App\Repository\Interfaces\CategoryInterface;
use App\Repository\Interfaces\PostInterface;
use App\Repository\Interfaces\SettingInterface;
use App\Repository\Interfaces\TagInterface;
use App\Repository\Interfaces\UserInterface;
use App\Repository\PostRepository;
use App\Repository\SettingRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(CategoryInterface::class,CategoryRepository::class);
        $this->app->bind(TagInterface::class,TagRepository::class);
        $this->app->bind(PostInterface::class,PostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
