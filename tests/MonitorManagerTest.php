<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 9:44 AM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Repository\MonitorRepository;
	use App\Service\Monitor\MonitorManager;
	use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
	
	class MonitorManagerTest extends KernelTestCase
	{
		public function test()
		{
			self::bootKernel();
			
			$monitorRepository = self::getContainer()->get(MonitorRepository::class);
			$entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
		
			$monitorManager = new MonitorManager($monitorRepository, $entityManager);
			
			$monitorManager->checkMonitors();
		
		}
	}