<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 2:58 PM
	 *
	 **/
	
	namespace App\EventListener;
	
	use App\Event\MonitorStatusChangedEvent;
	use App\Service\Monitoring\Presenter\MonitorPresenter;
	use App\Service\Monitoring\Presenter\NotificationPresenter;
	use App\Service\Notification\Channel\ChannelFactory;
	use Psr\Log\LoggerInterface;
	use Symfony\Component\Notifier\ChatterInterface;
	
	class MonitorStatusChangedNotification
	{
		public function __construct(private LoggerInterface $logger, private ChatterInterface $chatter){}
		
		public function onMonitorStatusChanged(MonitorStatusChangedEvent $event): void
		{
			$notifications = $event->getMonitor()->getNotifications();
			if(!empty($notifications))
			{
				foreach($notifications as $notify)
				{
					$channel = (new ChannelFactory($notify->getType(),$notify->getData(), $this->chatter))->factory();
					$monitorPresenter = new MonitorPresenter($event->getMonitor());
					$notificationPresenter = new NotificationPresenter($monitorPresenter, $channel->format());
					$channel->send(
						$notificationPresenter->getMessage()
					);
				}
			}
			
		
		}
	}