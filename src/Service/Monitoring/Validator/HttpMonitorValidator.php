<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 10:40 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Validator;
	
	class HttpMonitorValidator extends AbstractMonitorValidator implements MonitorValidatorInterface
	{
		public function validate(array $data): array
		{
			$errors = parent::validate($data);
			
			if(empty($data['url']) || !filter_var($data['url'], FILTER_VALIDATE_URL)) {
				$errors[] = 'Invalid URL';
			}
			
			return $errors;
		}
	}