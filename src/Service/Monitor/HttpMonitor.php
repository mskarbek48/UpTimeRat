<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/3/24 6:36 PM
	 *
	 **/
	
	namespace App\Service\Monitor;
	
	class HttpMonitor extends AbstractMonitor implements MonitorInterface
	{
		
		private Status $status;
		
		
		public function check(): void
		{
			if(isset($this->url))
			{
				try {
					
					$start = microtime(true);
					
					$client = new \GuzzleHttp\Client([
						'verify' => false,
						'curl' => [
							CURLOPT_CERTINFO => true,
						],
						'on_stats' => function (\GuzzleHttp\TransferStats $stats) {
							$this->certInfo = $stats->getHandlerStats()['certinfo'];
							$this->response_time = $stats->getTransferTime();
						}
					]);
					
					$response = $client->request('GET', $this->url);
					$this->status_code = $response->getStatusCode();
					$this->response_time = 0;//microtime(true) - $start;
					$this->response_body = $response->getBody();
					$this->response_headers = $response->getHeaders();
					$this->is_reachable = true;
				} catch (\Exception $e) {
					$this->status_code = $e->getCode();
					$this->response_time = 0;//microtime(true) - $start;
					$this->response_body = $e->getMessage();
					$this->response_headers = [];
					$this->certInfo = [];
					
					if($this->status_code != 0)
					{
						$this->is_reachable = true;
					}
					
				}
				
				$this->status = new Status($this);
			} else {
				throw new \Exception('URL is not set');
			}
		}
		
		public function getStatus(): Status
		{
			return $this->status;
		}
	
	}