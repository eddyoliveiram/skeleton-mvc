<?php

namespace App\Contracts;

interface DataRepositoryInterface {
    public function getAll($page, $itemsPerPage);
    public function countAll();
    public function create(array $data);
}
