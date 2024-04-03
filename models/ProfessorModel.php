<?php
namespace Models;

use Core\Model;

class ProfessorModel extends Model
{
    protected $table = 'professors';

    public function __construct() {
        parent::__construct($this->table);
    }

}