<?php

namespace App\Providers;

use App\Repositories\AccessTokenRepositoryInterface;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\Eloquent\AccessTokenRepository;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\Eloquent\Base\EloquentRepositoryInterface;
use App\Repositories\Eloquent\BlogRepository;
use App\Repositories\Eloquent\ImageRepository;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;


/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }

}
