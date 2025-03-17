<?php

namespace App\Traits\DTO\Request;

use App\DTO\Request\Query\MenuRequest;
use Doctrine\ORM\QueryBuilder;

trait PaginationRequestTrait
{
    const DEFAULT_LIMIT = 50;

    protected array $data;

    private ?int $limit = null;

    private ?int $offset = null;

    private readonly QueryBuilder $qb;

    public function initPagination(QueryBuilder $qb, ?MenuRequest $criteria = null): self
    {
        if ($criteria) {
            $this->limit = $criteria->limit ?? null;
            $this->offset = $criteria->page ?? null;
        }

        $this->qb = $qb;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit ?? self::DEFAULT_LIMIT;
    }

    public function getOffset(): ?int
    {
        return $this->offset ?? 0;
    }

    public function approveLimits(): self
    {
        $this->qb->setMaxResults($this->limit);

        return $this;
    }

    public function approveOffset(): self
    {
        $this->qb->setFirstResult($this->offset);

        return $this;
    }

    public function getResult(): self
    {
        $this->data = $this->qb->getQuery()->getResult();

        return $this;
    }
}