<?php
	
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 7:19 PM
	 *
	 **/
	class PortMonitorTest extends \PHPUnit\Framework\TestCase
	{
		public function testValidPort()
		{
			
			$portMonitor = new \App\Service\Monitoring\Monitor\PortMonitor();
			$portMonitor->setPort(80);
			$portMonitor->setIpAddress("1.1.1.1");
			$portMonitor->check();
			
			$status = $portMonitor->getStatus();
			
			$this->assertEquals($status->isUp(), true);
			
		}
		
		public function testInvalidPort()
		{
			$portMonitor = new \App\Service\Monitoring\Monitor\PortMonitor();
			$portMonitor->setPort(81);
			$portMonitor->setIpAddress("1.1.1.1");
			$portMonitor->check();
			
			$status = $portMonitor->getStatus();
			
			$this->assertEquals($status->isUp(), false);
		}
	}