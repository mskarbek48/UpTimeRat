<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 11:22 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Presenter;
	
	use App\Entity\MonitorStatus;
	
	class StatusPresenter
	{
		public function __construct(private MonitorStatus $monitorStatus)
		{}
		
		public function getStatus(): string
		{
			return $this->monitorStatus->getStatus();
		}
		
		public function getTailwindBlockClass(): string {
			
			switch($this->monitorStatus->getStatus())
			{
				case "UP":
					return "bg-green-500";
				case "DOWN":
					return "bg-red-500";
				case "SEEMS DOWN":
					return "bg-yellow-500";
				case "UNKNOWN":
					return "bg-gray-500";
				default:
					return "bg-white";
			}
			
		}
		
		public function getEmoji(): string
		{
			switch($this->monitorStatus->getStatus())
			{
				case "UP":
					return "🟢";
				case "DOWN":
					return "🔴";
				case "SEEMS DOWN":
					return "🟠";
				case "UNKNOWN":
					return "⚫️";
				default:
					return "⚪️";
			}
		}
		
		public function getTimeElapsed(): int
		{
			return time() - $this->monitorStatus->getDate()->getTimestamp();
		}
		
		public function getFormattedDate(): string
		{
			return $this->monitorStatus->getDate()->format("Y-m-d H:i:s");
		}
		
		
		
	}