<?php


namespace App\Search;


use App\Form\Model\Search;
use Doctrine\Common\Collections\ArrayCollection;

class SearchResult
{
    private $results;
    private $searchQuery;

    /**
     * SearchResult constructor.
     * @param ArrayCollection|null $results
     * @param Search|null $searchQuery
     */
    public function __construct(ArrayCollection $results = null, Search $searchQuery = null)
    {
        if ($results !== null) {
            $this->results = $results;
        }
        if ($searchQuery !== null) {
            $this->searchQuery = $searchQuery;
        }
    }

    public function getResults()
    {
        return $this->results;
    }

    public function setResults($results): void
    {
        $this->results = $results;
    }

    public function getSearchQuery(): Search
    {
        return $this->searchQuery;
    }

    public function setSearchQuery(Search $searchQuery): void
    {
        $this->searchQuery = $searchQuery;
    }
}