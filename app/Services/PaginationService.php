<?php
namespace App\Services;

use App\Core\Contracts\DataRepositoryInterface;

class PaginationService
{
    protected $repository;

    public function __construct(DataRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function paginate($variableName = 'data', $itemsPerPage = 10)
    {
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $page = max($page, 1);

        $data = $this->repository->getAll($page, $itemsPerPage);
        $totalUsers = $this->repository->getTotal();
        $totalPages = ceil($totalUsers / $itemsPerPage);

        $_SESSION['pagination'] = [
            $variableName => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];

        return [
            $variableName => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }
}