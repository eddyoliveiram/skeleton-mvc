<?php
namespace Services;

use Repositories\UserRepository;

class PaginationService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function paginate($array_name = 'data', $page, $itemsPerPage)
    {
        $data = $this->userRepository->getAllUsers($page, $itemsPerPage);
        $totalUsers = $this->userRepository->getTotalUsers();
        $totalPages = ceil($totalUsers / $itemsPerPage);

        $_SESSION['pagination'] = [
            $array_name => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];

        return [
            $array_name => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }
}