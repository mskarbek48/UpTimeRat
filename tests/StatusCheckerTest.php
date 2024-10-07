<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 8:53 AM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Entity\Monitor;
	use App\Service\Monitor\HttpMonitor;
	use App\Service\Monitor\Status\StatusUp;
	
	class StatusCheckerTest extends \PHPUnit\Framework\TestCase
	{
		public function testWebsite()
		{
		
			$monitor = new Monitor();
			$monitor->setUrl('https://google.com');
			$monitor->setName("Google");
			$monitor->setShortName("Google");
			$monitor->setCreated(new \DateTime());
			$monitor->setType("website");
			$monitor->setIntervalTime(60);
			$monitor->setTries(1);
			$statusChecker = new \App\Service\Monitor\StatusChecker($monitor);
			$this->assertInstanceOf(HttpMonitor::class, $statusChecker->factoryMonitorService());
			$statusChecker->check();
			$results = $statusChecker->getStatus();
			$this->assertEquals($results->getStatusName(), "UP");
			
		}
		
		public function testPort()
		{
			$monitor = new Monitor();
			$monitor->setIpAddress("1.1.1.1");
			$monitor->setPort(80);
			$monitor->setName("CF");
			$monitor->setShortName("CF");
			$monitor->setCreated(new \DateTime());
			$monitor->setType("port");
			$monitor->setIntervalTime(60);
			$monitor->setTries(1);
			$statusChecker = new \App\Service\Monitor\StatusChecker($monitor);
			$this->assertInstanceOf(\App\Service\Monitor\PortMonitor::class, $statusChecker->factoryMonitorService());
		}
	}