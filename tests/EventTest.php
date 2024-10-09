<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 4:08 PM
	 *
	 **/
	
	namespace App\Tests;
	
	use App\Entity\Monitor;
	use App\Event\MonitorStatusChangedEvent;
	use App\EventListener\MonitorStatusChangedNotification;
	use PHPUnit\Framework\TestCase;
	use Symfony\Component\EventDispatcher\EventDispatcher;

	
	class EventTest extends TestCase {
	
		
		public function testEvent()
		{
			$monitor = new Monitor();
			
			#$logger = new Logger();
			#$eventDispatcher = new EventDispatcher();
			
			$eventDispatcher = $this->createMock(EventDispatcher::class);
			
			$event = new MonitorStatusChangedEvent($monitor);
			#$listener = new MonitorStatusChangedNotification();
			#$eventDispatcher->addListener(MonitorStatusChangedEvent::NAME, [$listener, 'onMonitorStatusChanged']);
			#$logger->info('Dispatching MonitorStatusChangedEvent');
			$eventDispatcher->dispatch($event, "monitor.status.changed");
			
			
		}
	}