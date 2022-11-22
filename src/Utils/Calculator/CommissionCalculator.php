<?php

namespace App\Utils\Calculator;

use App\Utils\Provider\RateProvider;
use JetBrains\PhpStorm\Pure;

class CommissionCalculator
{
    /**
     * @param string $currency
     * @param float $amount
     * @param float $exchangeTargetRate
     * @return float
     */
    #[Pure]
    public function calculateAmountFixed(string $currency, float $amount, float $exchangeTargetRate): float
    {
        if (RateProvider::RATE_EUR === $currency) {
            return $amount;
        }

        return ($exchangeTargetRate > 0) ? $amount / $exchangeTargetRate : $amount;
    }

    /**
     * @param float $amountFixed
     * @param bool $isEuroZone
     * @return float
     */
    public function calculateCommission(float $amountFixed, bool $isEuroZone): float
    {
        return $amountFixed * ($isEuroZone ? 0.01 : 0.02);
    }

    /**
     * @param float $amount
     * @param int $precision
     * @return float
     */
    public function roundCents(float $amount, int $precision = 2): float
    {
        $pow = pow(10, $precision);

        return (
            ceil($pow * $amount)
            + ceil($pow * $amount - ceil($pow * $amount))
        ) / $pow;
    }
}
