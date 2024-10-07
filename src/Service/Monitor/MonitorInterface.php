<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 6:34 PM
	 *
	 **/
	
	namespace App\Service\Monitor;
	
	interface MonitorInterface
	{
		public function check(): void;
		
		public function getStatus(): Status;
		
	}