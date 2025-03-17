<?php

namespace App\Service;

use App\DTO\Request\Query\MenuRequest;
use App\Repository\DishRepository;
use App\Traits\DTO\Request\PaginationRequestTrait;


class MenuService
{
    use PaginationRequestTrait;

    public function __construct(
        private readonly DishRepository $repository
    ) { }

    public function getMenu(MenuRequest $menuRequest): array
    {
        $queryBuilder = $this->repository->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');

        $this->initPagination($queryBuilder, $menuRequest)
            ->approveLimits()
            ->approveOffset()
            ->getResult();

        return $this->data;
    }
}
