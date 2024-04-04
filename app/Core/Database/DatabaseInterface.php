<?php

namespace App\Core\Database;

interface DatabaseInterface {
    public function connect();
    public function query($sql);
    public function bind($param, $value, $type = null);
    public function execute();
    public function single();
    public function resultSet();

    public function getPaginationQuery($table, $page, $itemsPerPage);
}
