<?php

namespace App\Contracts;

interface DataRepositoryInterface {
    public function getAll($page, $itemsPerPage);
    public function getTotal();
    public function create(array $data);
}
