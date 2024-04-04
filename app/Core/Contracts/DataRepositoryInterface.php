<?php

namespace App\Core\Contracts;

interface DataRepositoryInterface {
    public function getAll($page, $itemsPerPage);
    public function getTotal();
    public function create(array $data);
}
