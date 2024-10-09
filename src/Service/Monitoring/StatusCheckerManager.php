<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 9:42 AM
	 *
	 **/
	
	namespace App\Service\Monitoring;
	
	use App\Entity\Monitor;
	use App\Entity\MonitorStatus;
	use App\Repository\MonitorRepository;
	use App\Event\MonitorStatusChangedEvent;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\EventDispatcher\EventDispatcherInterface;
	
	class StatusCheckerManager
	{
		private MonitorRepository $monitorRepository;
		
		private EntityManagerInterface $entityManager;
		
		private EventDispatcherInterface $eventDispatcher;
		
		public function __construct(MonitorRepository $monitorRepository, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
		{
			$this->monitorRepository = $monitorRepository;
			$this->entityManager = $entityManager;
			$this->eventDispatcher = $eventDispatcher;
		}
		
		public function checkMonitors()
		{
			foreach ($this->monitorRepository->findAll() as $monitor)
			{
				if($this->needToCheck($monitor))
				{
					$statusChecker = new StatusChecker($monitor);
					$statusChecker->check();
					$status = $statusChecker->getStatus();
					
					$last_status = $monitor->getMonitorStatuses()->last();
					
					$mstatus = new MonitorStatus();
					$mstatus->setStatus($status->getStatusName());
					$mstatus->setStatusCode($status->getStatusCode());
					$mstatus->setDate(new \DateTime());
					$mstatus->setMonitor($monitor);
					$mstatus->setMessage($status->getMessage());
					$mstatus->setResponseTime($status->getResponseTime());
					
					$this->entityManager->persist($mstatus);
					$this->entityManager->flush();
					
					if(!$last_status || $last_status->getStatus() != $status->getStatusName())
					{
						$this->entityManager->refresh($monitor);
						$event = new MonitorStatusChangedEvent($monitor);
						$this->eventDispatcher->dispatch($event, MonitorStatusChangedEvent::NAME);
						
					}
					

				}
			}
		}
		
		public function needToCheck(Monitor $monitor): bool
		{
			$last_status = $monitor->getMonitorStatuses()->last();
			if(!$last_status)
			{
				return true;
			}
			$last_status_time = $last_status->getDate()->getTimestamp();
			
			$now = (new \DateTime())->getTimestamp();
			
			$interval = $monitor->getIntervalTime();
			
			return $now - $last_status_time >= $interval;
		}
	}