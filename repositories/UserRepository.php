<?php
namespace Repositories;

use Models\UserModel;

class UserRepository
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAllUsers($page = 1, $itemsPerPage = 15)
    {
        return $this->userModel->allPaginated($page, $itemsPerPage);
    }

    public function getTotalUsers()
    {
        return $this->userModel->getTotalUsers();
    }

    public function createUser(array $userData)
    {
        return $this->userModel->insert($userData);
    }


}


