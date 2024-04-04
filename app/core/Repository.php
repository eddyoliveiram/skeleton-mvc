<?php

namespace Core;

abstract class Repository {
    abstract public function getAll($page, $itemsPerPage);
    abstract public function getTotal();
}
