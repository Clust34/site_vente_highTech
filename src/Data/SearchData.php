<?php

namespace App\Data;

class SearchData
{
    /**
     * The content of the query for title posts
     *
     * @var string|null
     */
    private ?string $query = '';

    /**
     * Array of marques for the search article
     *
     * @var array|null
     */
    private ?array $marques = [];

    public function getBlockPrefix(): string
    {
        return '';
    }

    /**
     * Get the value of query
     *
     * @return ?string
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * Set the value of query
     *
     * @param ?string $query
     *
     * @return self
     */
    public function setQuery(?string $query): self
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Get the value of marques
     *
     * @return ?array
     */
    public function getMarques(): ?array
    {
        return $this->marques;
    }
    /**
     * Set the value of marques
     *
     * @param ?array $marques
     *
     * @return self
     */
    public function setMarques(?array $marques): self
    {
        $this->marques = $marques;
        return $this;
    }
}
