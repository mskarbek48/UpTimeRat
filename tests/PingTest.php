<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/10/24 9:19 AM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Service\Monitoring\Monitor\PingMonitor;
	use PHPUnit\Framework\TestCase;
	
	class PingTest extends TestCase
	{
		public function testPing()
		{
			
			$pmonitor = new PingMonitor();
			$pmonitor->setIpAddress('1.1.1.1');
			$pmonitor->check();
			
			$this->assertEquals(true, $pmonitor->getStatus()->isUp());
			
			$pmonitor->setIpAddress('123.121.121.111');
			$pmonitor->check();
			$this->assertEquals(false, $pmonitor->getStatus()->isUp());
			
	
			
		}
	}
