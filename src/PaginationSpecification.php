<?php

namespace Joshbrw\PaginationSpecification;

interface PaginationSpecification
{
    /**
     * Manually set how many items should be on each page.
     * @return PaginationSpecification
     */
    public function setPerPage(int $perPage): PaginationSpecification;

    /**
     * Get how many items should be on each page.
     * @return int
     */
    public function getPerPage(): int;

    /**
     * Manually set the current page.
     * @param int $currentPage
     * @return PaginationSpecification
     */
    public function setCurrentPage(int $currentPage): PaginationSpecification;

    /**
     * Get the current page.
     * @return int
     */
    public function getCurrentPage(): int;

    /**
     * Add to the appendages.
     * You can either set an array of appendages as key/value, or add a single appendage.
     * @param string|array $key
     * @param string|null $value
     * @return PaginationSpecification
     */
    public function addAppends($key, $value = null): PaginationSpecification;

    /**
     * Get the appendages.
     * @return array
     */
    public function getAppends(): array;

    /**
     * Set the desired Page Name
     * @param string $pageName
     * @return PaginationSpecification
     */
    public function setPageName(string $pageName): PaginationSpecification;

    /**
     * Get the desired Page Name
     * @return string
     */
    public function getPageName(): string;
}
