<?php

namespace App\DTO;

class TransactionModel
{
    /**
     * @var string|null
     */
    private ?string $bin = null;

    /**
     * @var float
     */
    private float $amount = 0.0;

    /**
     * @var string|null
     */
    private ?string $currency = null;

    /**
     * @return string|null
     */
    public function getBin(): ?string
    {
        return $this->bin;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return $this
     */
    public function makeFromArray(array $transactionArray): self
    {
        if (isset($transactionArray['bin'])) {
            $this->bin = $transactionArray['bin'];
        }

        if (isset($transactionArray['amount'])) {
            $this->amount = floatval($transactionArray['amount']);
        }

        if (isset($transactionArray['currency'])) {
            $this->currency = $transactionArray['currency'];
        }

        return $this;
    }
}
