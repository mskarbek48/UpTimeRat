<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 11:20 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Presenter;
	
	use App\Entity\Monitor;
	use App\Entity\MonitorStatus;
	
	class MonitorPresenter
	{
		
		public function __construct(
			private Monitor $monitor
		){ }
		
		public function getCurrentStatus(): StatusPresenter
		{
			$status = $this->monitor->getMonitorStatuses()->last();
			if(empty($status))
			{
				$status = new MonitorStatus();
				$status->setStatus("UNKNOWN");
				$status->setDate(new \DateTime("now"));
				$status->setStatusCode(0);
				$status->setResponseTime(0);
			}
			
			
			return new StatusPresenter($status);
		}
		
		public function getLastStatuses(int $count = 50)
		{
			$statuses = $this->monitor->getMonitorStatuses()->slice(-$count);
			$statuses = array_reverse($statuses);
			
			$results = [];
			for($x = 0; $x < $count; $x++)
			{
				if(isset($statuses[$x]))
				{
					$results[] = new StatusPresenter($statuses[$x]);
				} else {
					$monitorStatus = new MonitorStatus();
					$monitorStatus->setStatus("UNKNOWN");
					$results[] = new StatusPresenter($monitorStatus);
				}
			}
			return $results;
		}
		
		
		
	}