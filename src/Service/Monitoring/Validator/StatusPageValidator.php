<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 8:06 AM
	 *
	 **/
	
	namespace App\Service\Monitoring\Validator;
	
	use App\Service\Domain\Validator\ValidatorInterface;
	
	class StatusPageValidator implements ValidatorInterface
	{
		public function validate(array $data): array
		{
			$errors = [];
			if(empty($data['name']) || strlen($data['name']) < 3 || strlen($data['name']) > 255) {
				$errors[] = 'Name must be between 3 and 255 characters';
			}
			
			if(empty($data['description']) || strlen($data['description']) < 3 || strlen($data['description']) > 255) {
				$errors[] = 'Description must be between 3 and 255 characters';
			}
			
			if(empty($data['monitors']))
			{
				$errors[] = 'You must add at least one monitor';
			}
			
			return $errors;
		}
	}