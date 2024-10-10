<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/10/24 9:14 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Monitor;
	
	use App\Service\Monitoring\Monitor\Status\Status;
	
	class PingMonitor extends AbstractMonitor implements MonitorInterface
	{
		private Status $status;
		
		public function check(): void
		{
			if(isset($this->ip_address))
			{
				$results = $this->ping($this->ip_address);
				$this->is_reachable = $results['success'];
				$this->response_time = $results['time'];
				$this->status_code = $results['success'] ? 1 : 0;
				$this->status = new Status($this);
				
			} else {
				throw new \Exception("No IP address provided");
			}
		}
		
		public function ping(string $ipAddress): array
		{
			if(strtolower(PHP_OS) == "linux")
			{
				$cr = exec("ping -c 4 $ipAddress", $out, $rval);
				
				if(empty($out))
				{
					return array('success' => false, 'ping' => 0, 'time' => 0, 'packet_loss' => 100);
				}
				
				print_r($out);
				$packet_loss = 100;
				$times = [];
				foreach($out as $line)
				{
					if(preg_match("/(\d+) bytes from ([\d.]+): icmp_seq=(\d+) ttl=(\d+) time=([\d.]+) ms/", $line, $matches))
					{
						$times[] = $matches[5];
					}
					if(preg_match("/(\d+) packets transmitted, (\d+) received, (\d+)% packet loss, time (\d+)ms/", $line, $matches))
					{
						$packet_loss = $matches[3];
					}
				}
				
				$ping = 0;
				if(!empty($times))
				{
					$ping = round(array_sum($times) / count($times), 2);
				}
				
				return array('success' => $packet_loss < 100, 'ping' => $ping, 'time' => $ping, 'packet_loss' => $packet_loss);
				
			} elseif(str_contains(strtolower(PHP_OS), "win"))
			{
				// TODO: Implement Windows ping
			}
		}
		
		public function getStatus(): Status
		{
			return $this->status;
		}
	}