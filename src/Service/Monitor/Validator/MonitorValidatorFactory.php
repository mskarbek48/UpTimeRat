<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 10:46 AM
	 *
	 **/
	
	namespace App\Service\Monitor\Validator;
	

	
	class MonitorValidatorFactory
	{
		public function __construct(private array $data){}
		
		public function factory(): MonitorValidatorInterface
		{
			if(!empty($this->data['type']))
			{
				switch($this->data['type'])
				{
					case 'website':
						return new HttpMonitorValidator($this->data);
						break;
					case 'ping':
						return new PingMonitorValidator($this->data);
						break;
					case 'port':
						return new PortMonitorValidator($this->data);
						break;
				}
			}
			throw new \Exception('Invalid monitor type');
		}
	}