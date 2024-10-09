<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 10:41 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Validator;
	
	use App\Service\Domain\Validator\ValidatorInterface;
	
	abstract class AbstractMonitorValidator implements ValidatorInterface
	{
		public function validate(array $data): array
		{
			$errors = [];
			if(empty($data['name']) || strlen($data['name']) < 3 || strlen($data['name']) > 255) {
				$errors[] = 'Name must be between 3 and 255 characters';
			}
			
			if(empty($data['shortname']) || strlen($data['shortname']) < 3 || strlen($data['shortname']) > 255) {
				$errors[] = 'Shortname must be between 3 and 255 characters';
			}
			
			if(empty($data['interval']) || $data['interval'] % 60 !== 0) {
				$errors[] = 'Interval must be a multiple of 60';
			}
			
			if(empty($data['tries']) || $data['tries'] < 1 || $data['tries'] > 10) {
				$errors[] = 'Tries must be between 1 and 10';
			}
			
			return $errors;
		
		}
	}