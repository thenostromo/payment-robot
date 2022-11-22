<?php

namespace App\Tests\Integration\Utils\Manager;

use App\Utils\Manager\CommissionManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 */
class CommissionManagerTest extends KernelTestCase
{
    private CommissionManager $commissionManager;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->commissionManager = static::getContainer()->get(CommissionManager::class);
    }

    public function testCalculateByTransactionJSONRows(): void
    {
        $transactionRows = [
            '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
            '{"bin":"516793","amount":"50.00","currency":"USD"}'
        ];

        $result = $this->commissionManager->calculateByTransactionJSONRows($transactionRows);

        $this->assertCount(2, $result);
    }
}
