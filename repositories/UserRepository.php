<?php
namespace Repositories;
use Core\Repository;
use Models\UserModel;

class UserRepository extends Repository
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAll($page = 1, $itemsPerPage = 15)
    {
        return $this->userModel->allPaginated($page, $itemsPerPage);
    }

    public function getTotal()
    {
        return $this->userModel->getTotalUsers();
    }

    public function createUser(array $userData)
    {
        return $this->userModel->insert($userData);
    }


}


