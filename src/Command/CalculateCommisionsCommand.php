<?php

namespace App\Command;

use App\Utils\FileSystem\FileManager;
use App\Utils\Manager\CommissionManager;
use App\Utils\Parser\FileParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

#[AsCommand(
    name: 'CalculateCommisionsCommand',
    description: 'Add a short description for your command',
)]
class CalculateCommisionsCommand extends Command
{
    /**
     * @var CommissionManager
     */
    private CommissionManager $commissionManager;

    /**
     * @var FileManager
     */
    private FileManager $fileManager;

    /**
     * @param CommissionManager $commissionManager
     * @param FileManager $fileManager
     */
    public function __construct(CommissionManager $commissionManager, FileManager $fileManager)
    {
        parent::__construct();

        $this->commissionManager = $commissionManager;
        $this->fileManager = $fileManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, 'Enter the path to the file')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('filePath');

        try {
            $fileContent = $this->fileManager->getFileContent($filePath);

            if (!$fileContent) {
                $io->error('File is empty');

                return Command::FAILURE;
            }
        } catch (FileNotFoundException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $transactionRows = FileParser::parseByDelimiter(PHP_EOL, $fileContent);

        $commissions = $this->commissionManager->calculateByTransactionJSONRows($transactionRows);

        foreach ($commissions as $commission) {
            $io->info($commission);
        }

        $io->success('Execution completed.');

        return Command::SUCCESS;
    }
}
