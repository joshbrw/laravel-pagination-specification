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
        $this->app->bind(PaginationSpecification::class, RequestPaginationSpecification::class);
    }

    public function boot(): void
    {
        Builder::macro('paginateToSpecification', function (Builder $builder, RequestPaginationSpecification $paginationSpecification, $columns = ["*"]) {
            return $builder->paginate(
                $paginationSpecification->getPerPage(),
                $columns,
                $paginationSpecification->getPageName(),
                $paginationSpecification->getPerPage()
            );
        });
    }

    public function provides()
    {
        return [
            PaginationSpecification::class
        ];
    }
}
