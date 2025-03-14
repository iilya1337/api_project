<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class),
        ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?int $user = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private array $items = [];

    #[ORM\ManyToOne(targetEntity: Courier::class),
        ORM\JoinColumn(name: 'courier_id', referencedColumnName: 'id')]
    private ?Courier $courier = null;

    #[ORM\Column(length: 255)]
    private ?string $txn_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getTxnId(): ?string
    {
        return $this->txn_id;
    }

    public function setTxnId(string $txn_id): static
    {
        $this->txn_id = $txn_id;

        return $this;
    }
}
