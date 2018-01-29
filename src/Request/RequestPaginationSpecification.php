<?php

namespace Joshbrw\PaginationSpecification\Request;

use Illuminate\Http\Request;
use Joshbrw\PaginationSpecification\PaginationSpecification;

class RequestPaginationSpecification implements PaginationSpecification
{

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @var int
     */
    protected $perPage = 0;

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var array
     */
    protected $appends = [];

    /**
     * @var string
     */
    protected $pageName = 'page';

    /**
     * Manually set how many items should be on each page.
     * @return PaginationSpecification
     */
    public function setPerPage(int $perPage): PaginationSpecification
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Get how many items should be on each page.
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Manually set the current page.
     * @param int $currentPage
     * @return PaginationSpecification
     */
    public function setCurrentPage(int $currentPage): PaginationSpecification
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get the current page.
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Add to the appendages.
     * You can either set an array of appendages as key/value, or add a single appendage.
     * @param string|array $key
     * @param string|null $value
     * @return PaginationSpecification
     */
    public function addAppends($key, $value = null): PaginationSpecification
    {
        if (is_array($key)) {
            collect($key)
                ->each(function ($value, $key) {
                    $this->addAppends($key, $value);
                });

            return $this;
        }

        $this->appends[$key] = $value;

        return $this;
    }

    protected function getDefaultAppends()
    {
        $appends = [];

        if ($perPage = $this->getPerPage()) {
            $appends['per_page'] = $perPage;
        }

        return $appends;
    }

    /**
     * Get the appendages.
     * @return array
     */
    public function getAppends(): array
    {
        return array_merge($this->getDefaultAppends(), $this->appends);
    }

    /**
     * Set the desired Page Name
     * @param string $pageName
     * @return PaginationSpecification
     */
    public function setPageName(string $pageName): PaginationSpecification
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Get the desired Page Name
     * @return string
     */
    public function getPageName(): string
    {
        return $this->pageName;
    }

    /**
     * Load in pagination data from a HTTP Request
     * @param Request $request
     * @return PaginationSpecification
     */
    public function fromRequest(Request $request): PaginationSpecification
    {
        if ($perPage = $request->get('per_page')) {
            $this->setPerPage($perPage);
        }

        if ($currentPage = $request->get($this->getPageName())) {
            $this->setCurrentPage($currentPage);
        }

        return $this;
    }
}
