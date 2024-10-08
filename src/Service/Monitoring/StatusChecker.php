<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 8:48 AM
	 *
	 **/
	
	namespace App\Service\Monitoring;
	
	use App\Entity\Monitor;
	use App\Service\Monitoring\Monitor\HttpMonitor;
	use App\Service\Monitoring\Monitor\MonitorInterface;
	use App\Service\Monitoring\Monitor\PortMonitor;
	use App\Service\Monitoring\Monitor\Status\Status;
	use App\Service\Monitoring\Status\StatusInterface;
	
	class StatusChecker
	{
		
		private MonitorInterface $monitorService;
		
		private Status $status;
		
		public function __construct(
			private Monitor $monitor
		){}
		
		public function factoryMonitorService()
		{
			switch($this->monitor->getType())
			{
				case "port":
					$this->monitorService = new PortMonitor();
					$this->monitorService->setIpAddress($this->monitor->getIpAddress());
					$this->monitorService->setPort($this->monitor->getPort());
					break;
				case "website":
					$this->monitorService = new HttpMonitor();
					$this->monitorService->setUrl($this->monitor->getUrl());
					break;
			}
			
			return $this->monitorService;
		}
		
		public function check()
		{
			$this->factoryMonitorService();
			$this->monitorService->check();
			$this->status = $this->monitorService->getStatus();
			
			$up = false;
			$issues = false;
			if($this->monitor->getType() == "website")
			{
				if($this->monitor->getAcceptedCodes() != null)
				{
					if($this->status->isUp($this->monitor->getAcceptedCodes()))
					{
						$up = true;
					}
				} else {
					if($this->status->isUp())
					{
						$up = true;
					}
				}
				
				if(!$this->status->isValidCert())
				{
					$issues = true;
				}
			} else {
				if($this->status->isUp())
				{
					$up = true;
				}
			}
			
			if($up && $issues)
			{
				$this->status->setStatusName("SEEMS DOWN");
			} elseif($up)
			{
				$this->status->setStatusName("UP");
			} else {
				$this->status->setStatusName("DOWN");
			}
		}
		
		public function getStatus()
		{
			return $this->status;
		}
		
	}