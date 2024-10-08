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
	use Doctrine\ORM\EntityManagerInterface;
	
	class StatusCheckerManager
	{
		private MonitorRepository $monitorRepository;
		
		private EntityManagerInterface $entityManager;
		
		public function __construct(MonitorRepository $monitorRepository, EntityManagerInterface $entityManager)
		{
			$this->monitorRepository = $monitorRepository;
			$this->entityManager = $entityManager;
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
					
					$mstatus = new MonitorStatus();
					$mstatus->setStatus($status->getStatusName());
					$mstatus->setStatusCode($status->getStatusCode());
					$mstatus->setDate(new \DateTime());
					$mstatus->setMonitor($monitor);
					$mstatus->setResponseTime($status->getResponseTime());
					
					$this->entityManager->persist($mstatus);
					$this->entityManager->flush();
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