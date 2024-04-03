<?php
namespace Services;

use Core\IRepository;

class PaginationService
{
    protected $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate($array_name = 'data', $itemsPerPage)
    {
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $page = max($page, 1);

        $data = $this->repository->getAll($page, $itemsPerPage);
        $totalUsers = $this->repository->getTotal();
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