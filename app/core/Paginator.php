<?php

namespace App\Core;

class Paginator
{
    public $items;
    public $totalItems;
    public $itemsPerPage;
    public $currentPage;
    public $totalPages;

    public function __construct($items, $totalItems, $currentPage, $itemsPerPage = 15)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getItems()
    {
        return $this->items;
    }
}
