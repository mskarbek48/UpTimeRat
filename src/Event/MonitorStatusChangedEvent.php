<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 2:53 PM
	 *
	 **/
	
	namespace App\Event;
	
	use App\Entity\Monitor;
	use Symfony\Contracts\EventDispatcher\Event;
	
	class MonitorStatusChangedEvent extends Event
	{
		public const NAME = 'monitor.status.changed';
		
		private Monitor $monitor;
		
		public function __construct(Monitor $monitor)
		{
			echo "MonitorStatusChangedEvent\n";
			$this->monitor = $monitor;
		}
		
		public function getMonitor(): Monitor
		{
			return $this->monitor;
		}
	}