<?php


namespace Tangibledesign\Framework\Widgets\Helpers;


class Pagination
{

    protected $perPage;

    private $pageNumber;

    /**
     * Pagination constructor.
     * @param int $resultsNumber
     * @param int $perPage
     * @param int $currentPage
     * @param string $url
     */
    public function __construct(int $resultsNumber, int $perPage, int $currentPage, string $url)
    {
        $this->pageNumber = $resultsNumber / $perPage;


    }

}