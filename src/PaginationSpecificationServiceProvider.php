<?php

namespace Joshbrw\PaginationSpecification;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Joshbrw\PaginationSpecification\Request\RequestPaginationSpecification;

class PaginationSpecificationServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = true;

    /**
     * Register any dependencies into the container
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ .'/../config/config.php', 'pagination-specification');

        $this->app->bind(PaginationSpecification::class, RequestPaginationSpecification::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ .'/../config/config.php' => config_path('pagination-specification.php'),
        ]);

        $this->app->resolving(PaginationSpecification::class, function (PaginationSpecification $paginationSpecification, $app) {
            if ($defaultPerPage = $app['config']->get('pagination-specification.default-per-page')) {
                $paginationSpecification->setPerPage($defaultPerPage);
            }
        });

        Builder::macro('paginateToSpecification', function (RequestPaginationSpecification $paginationSpecification, $columns = ["*"]) {
            return $this->paginate(
                $paginationSpecification->getPerPage(),
                $columns,
                $paginationSpecification->getPageName(),
                $paginationSpecification->getCurrentPage()
            )->appends($paginationSpecification->getAppends());
        });
    }

    public function provides()
    {
        return [
            PaginationSpecification::class
        ];
    }
}
