<?php
namespace App\dto;

class UserDataDTO
{
    public $users;
    public $title;

    public function __construct($users, $title)
    {
        $this->users = $users;
        $this->title = $title;
    }
}


