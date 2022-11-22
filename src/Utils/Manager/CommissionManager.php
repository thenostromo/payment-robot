<?php

namespace App\Utils\Manager;

use App\DTO\TransactionModel;
use App\Utils\API\BinAPIService;
use App\Utils\API\ExchangeRateAPIService;
use App\Utils\Calculator\CommissionCalculator;
use App\Utils\Provider\BinAplha2Provider;
use JetBrains\PhpStorm\Pure;

class CommissionManager
{
    /**
     * @var BinAPIService
     */
    private BinAPIService $binAPIService;

    /**
     * @var ExchangeRateAPIService
     */
    private ExchangeRateAPIService $exchangeRateAPIService;

    /**
     * @var array
     */
    private array $exchangesRates = [];

    /**
     * @var CommissionCalculator
     */
    private CommissionCalculator $commissionCalculator;

    /**
     * @param BinAPIService $binAPIService
     * @param ExchangeRateAPIService $exchangeRateAPIService
     * @param CommissionCalculator $commissionCalculator
     */
    public function __construct(
        BinAPIService $binAPIService,
        ExchangeRateAPIService $exchangeRateAPIService,
        CommissionCalculator $commissionCalculator
    ) {
        $this->binAPIService = $binAPIService;
        $this->exchangeRateAPIService = $exchangeRateAPIService;
        $this->commissionCalculator = $commissionCalculator;
    }

    /**
     * @param array $transactionRows
     * @return array
     */
    public function calculateByTransactionJSONRows(array $transactionRows): array
    {
        $this->initExchangeApiRates();

        $commissions = [];

        foreach ($transactionRows as $transactionJSON) {
            if (!is_string($transactionJSON)) {
                continue;
            }

            $transactionRow = json_decode($transactionJSON, true);
            if (!$transactionRow) {
                continue;
            }

            $transactionModel = (new TransactionModel())
                ->makeFromArray($transactionRow);

            if (!$this->validTransactionRequiredFields($transactionModel)) {
                continue;
            }

            $binAPICountry = $this->getBINApiCountry($transactionModel);
            if (!$binAPICountry) {
                continue;
            }

            $binAPICountryAlpha2 = $binAPICountry['alpha2'];

            $isEuroZone = BinAplha2Provider::isEuroZone($binAPICountryAlpha2);

            if (!isset($this->exchangesRates[$transactionModel->getCurrency()])) {
                continue;
            }

            $exchangeTargetRate = $this->exchangesRates[$transactionModel->getCurrency()];

            $amountFixed = $this->commissionCalculator->calculateAmountFixed(
                $transactionModel->getCurrency(),
                $transactionModel->getAmount(),
                $exchangeTargetRate
            );

            $rawCommission = $this->commissionCalculator->calculateCommission($amountFixed, $isEuroZone);
            $commissions[] = $this->commissionCalculator->roundCents($rawCommission);
        }

        return $commissions;
    }

    private function initExchangeApiRates()
    {
        $this->exchangesRates = $this->getExchangeRatesApiList();
    }

    /**
     * @return array
     */
    private function getExchangeRatesApiList(): array
    {
        $exchangeRateAPIContent = $this->exchangeRateAPIService->getItemList();

        return $exchangeRateAPIContent['rates'] ?? [];
    }

    /**
     * @param TransactionModel $transactionModel
     * @return array
     */
    private function getBINApiCountry(TransactionModel $transactionModel): array
    {
        $binAPIContent = $this->binAPIService->getItem($transactionModel->getBin());

        return $binAPIContent['country'] ?? [];
    }

    /**
     * @param TransactionModel $transactionModel
     * @return bool
     */
    #[Pure]
    private function validTransactionRequiredFields(TransactionModel $transactionModel): bool
    {
         return $transactionModel->getBin()
             && $transactionModel->getAmount()
             && $transactionModel->getCurrency();
    }
}
