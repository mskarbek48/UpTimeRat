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
	
	namespace App\Service\Monitoring\Monitor;
	
	abstract class AbstractMonitor
	{
		protected string $url;
		
		protected string $ip_address;
		
		protected int $port;
		
		protected bool $is_reachable = false;
		
		protected int $response_time = 0;
		
		protected int $status_code = 0;
		
		protected string $status_message = "";
		
		protected array $response_headers;
		
		protected string $response_body;
		
		protected array $certInfo;
		
		public function setUrl(string $url): void
		{
			$this->url = $url;
		}
		
		public function setIpAddress(string $ip_address):void
		{
			$this->ip_address = $ip_address;
		}
		
		public function setPort(int $port):void
		{
			$this->port = $port;
		}
		
		public function getUrl(): string
		{
			return $this->url;
		}
		
		public function getIpAddress(): string
		{
			return $this->ip_address;
		}
		
		public function getPort(): int
		{
			return $this->port;
		}
		
		public function isReachable(): bool
		{
			return $this->is_reachable;
		}
		
		public function getResponseTime(): int
		{
			return $this->response_time;
		}
		
		public function getStatusCode(): int
		{
			return $this->status_code;
		}
		
		public function haveUrl(): bool
		{
			return !empty($this->url);
		}
		
		public function getCertInfo(): array
		{
			return $this->certInfo;
		}
		
		public function getMessage()
		{
			return $this->status_message;
		}
		
		public function setMessage(string $message): void
		{
			$this->status_message = $message;
		}
		
		
	}