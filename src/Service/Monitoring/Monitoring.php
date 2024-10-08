<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 8:24 AM
	 *
	 **/
	
	namespace App\Service\Monitoring;
	
	class Monitoring
	{
		public function getTypes()
		{
			$types = [];
			foreach(get_declared_classes() as $class)
			{
				if(in_array('App\Service\Monitoring\Monitor\MonitorInterface', class_implements($class)))
				{
					$types[] = $class;
				}
			}
			return $types;
		}
	}