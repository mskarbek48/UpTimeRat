<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 6:35 PM
	 *
	 **/
	
	namespace App\Service\Monitoring\Monitor\Status;
	
	use App\Service\Monitoring\Monitor\MonitorInterface;
	
	class Status
	{
		private string $status;
		
		public function __construct(private MonitorInterface $monitor) {}
		
		public function getStatusName(): string
		{
			return $this->status;
		}
		
		public function setStatusName(string $status): void
		{
			$this->status = $status;
		}
		
		public function getResponseTime(): float
		{
			return $this->monitor->getResponseTime();
		}
		
		public function getStatusCode(): int
		{
			return $this->monitor->getStatusCode();
		}
		
		public function getCertInfo(): array
		{
			return $this->monitor->getCertInfo();
		}
		
		
		public function isUp(array $statusCodes = [200]): bool
		{
			if($this->monitor->isReachable() === false)
			{
				return false;
			}
			
			if($this->monitor->haveUrl())
			{
				if(in_array($this->monitor->getStatusCode(), $statusCodes))
				{
					return true;
				}
				return false;
			}
			
			return true;
		}
		
		public function isValidCert(): bool
		{
			if($this->monitor->haveUrl())
			{
				if(isset($this->monitor->getCertInfo()[0]['Expire date']))
				{
					$date = new \DateTime($this->monitor->getCertInfo()[0]['Expire date']);
					$now = new \DateTime();
					if($date > $now)
					{
						return true;
					}
				}
			}
			return false;
		}
	}