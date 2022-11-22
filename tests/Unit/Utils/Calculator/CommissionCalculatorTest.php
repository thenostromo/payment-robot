<?php

namespace App\Tests\Unit\Utils\Calculator;

use PHPUnit\Framework\TestCase;
use App\Utils\Calculator\CommissionCalculator;

/**
 * @group unit
 */
class CommissionCalculatorTest extends TestCase
{
    private CommissionCalculator $commissionCalculator;

    public function setUp(): void
    {
        parent::setUp();

        $this->commissionCalculator = new CommissionCalculator();
    }

    public function testCalculateAmountFixed(): void
    {
        $result = $this->commissionCalculator->calculateAmountFixed('USD', 50.0, 1.025184);

        self::assertSame(48.77173268408402, $result);
    }

    public function testCalculateCommission(): void
    {
        $result = $this->commissionCalculator->calculateCommission(100.0, false);

        self::assertSame(2.0, $result);
    }

    public function testRoundCents(): void
    {
        $result = $this->commissionCalculator->roundCents(0.97543465368168, 2);

        self::assertSame(0.98, $result);
    }
}
