<?php

namespace App\Command;

use App\Service\Monitor\MonitorManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:crontab',
    description: 'Check all monitors',
)]
class CrontabCommand extends Command
{
	
	private MonitorManager $monitorManager;
	
    public function __construct(MonitorManager $monitorManager)
    {
		$this->monitorManager = $monitorManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        #$this
        #    ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        #    ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        #;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
		$io->title("Waiting for check all monitors...");
		
		$this->monitorManager->checkMonitors();
		
		$io->success("All monitors checked successfully!");
		
		

        return Command::SUCCESS;
    }
}
