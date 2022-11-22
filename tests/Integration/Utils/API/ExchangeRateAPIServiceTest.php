<?php

namespace App\Tests\Integration\Utils\API;

use App\Utils\API\ExchangeRateAPIService;
use App\Utils\Manager\CommissionManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 */
class ExchangeRateAPIServiceTest extends KernelTestCase
{
    private ExchangeRateAPIService $exchangeRateAPIService;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->exchangeRateAPIService = static::getContainer()->get(ExchangeRateAPIService::class);
    }

    public function testGetItemList(): void
    {
        $result = $this->exchangeRateAPIService->getItemList();

        $this->assertNotEmpty($result);

        $this->assertTrue(isset($result['rates']));

        $this->assertNotEmpty($result['rates']);
    }
}
