<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 7:17 PM
	 *
	 **/
	
	namespace App\Service\Monitoring\Monitor;
	
	use App\Service\Monitoring\Monitor\Status\Status;
	
	class PortMonitor extends AbstractMonitor implements MonitorInterface
	{
		
		private Status $status;
		public function check(): void
		{
			if(isset($this->ip_address) && isset($this->port))
			{
				$start = microtime(true);
				$fp = @fsockopen($this->ip_address, $this->port, $errno, $errstr, 1);
				if($fp)
				{
					fclose($fp);
					$end = microtime(true);
					$execution_time = $end - $start;
					$this->response_time = $execution_time;
					$this->is_reachable = true;
					$this->status_message = "OK";
				} else {
					$this->status_message = "Connection failed ($errstr)";
				}
				$this->status = new Status($this);
			}
		}
		
		public function getStatus(): Status
		{
			return $this->status;
		}
	}