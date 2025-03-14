<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Price
{
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $amount;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency;

    public function __construct(float $amount, string $currency = 'RUB')
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Цена не может быть отрицательной');
        }

        $this->amount = $amount;
        $this->currency = strtoupper($currency);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}