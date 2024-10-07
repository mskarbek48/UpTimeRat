<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 6:53 PM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Service\Monitor\HttpMonitor;
	use PHPUnit\Framework\TestCase;
	
	class HttpMonitorTest extends TestCase
	{
		public function test()
		{
		
			$example = new HttpMonitor();
			$example->setUrl("https://google.pl");
			$example->check();
			$status = $example->getStatus();
			$this->assertEquals(true, $status->isUp([200]));
			$this->assertEquals(true, $status->isValidCert());

		}
		
		public function testHttp()
		{
			$example = new HttpMonitor();
			$example->setUrl("http://google.pl");
			$example->check();
			$status = $example->getStatus();

			$this->assertEquals(true, $status->isUp([200]));
			$this->assertEquals(false, $status->isValidCert());
		}
		
		public function testInvalidCert()
		{
			$example = new HttpMonitor();
			$example->setUrl("https://expired.badssl.com/");
			$example->check();
			$status = $example->getStatus();
			$this->assertEquals(false, $status->isValidCert());
			$this->assertEquals(true, $status->isUp([200]));
			$this->assertEquals(false, $status->isUp([404]));
		}
		
		public function testNoUrl()
		{
			$example = new HttpMonitor();
			try {
				$example->check();
				$example->getStatus();
			} catch (\Exception $e) {
				$this->assertEquals("URL is not set", $e->getMessage());
			}
		}
		
		public function testNoExistUrl()
		{
			$example = new HttpMonitor();
			$example->setUrl("https://sadfoirgqwbr.com");
			$example->check();
			$status = $example->getStatus();
			
			
			$this->assertEquals(false, $status->isUp([200]));
			$this->assertEquals(false, $status->isUp([404]));
		}
		
		public function testCustomStatus()
		{
			$example = new HttpMonitor();
			$example->setUrl("https://google.pl/not");
			$example->check();
			$status = $example->getStatus();
			$this->assertEquals(false, $status->isUp([200]));
			$this->assertEquals(true, $status->isUp([404]));
		}
		
	}
