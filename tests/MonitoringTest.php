<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 8:26 AM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Service\Monitoring\Monitoring;
	
	class MonitoringTest extends \PHPUnit\Framework\TestCase
	{
		public function test()
		{
		
			$monitoring = new Monitoring();
			
			print_r($monitoring->getTypes());
		
		}
	}