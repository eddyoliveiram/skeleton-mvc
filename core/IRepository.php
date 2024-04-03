<?php

namespace Core;

interface IRepository
{
    public function getAll($page, $itemsPerPage);
    public function getTotal();
}