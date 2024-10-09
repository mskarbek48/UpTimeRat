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
	
	use App\Service\Domain\Validator\ValidatorInterface;
	
	class PortMonitorValidator extends AbstractMonitorValidator implements ValidatorInterface
	{
		public function validate(array $data): array
		{
			$errors = parent::validate($data);
			
			if(empty($data['ip']) || !filter_var($data['ip'], FILTER_VALIDATE_IP)) {
				$errors[] = 'Invalid IP address';
			}
			
			if(empty($data['port']) || !filter_var($data['port'], FILTER_VALIDATE_INT)) {
				$errors[] = 'Invalid port number';
			}
			
			return $errors;
		}
	}