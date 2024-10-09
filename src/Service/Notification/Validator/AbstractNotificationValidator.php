<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 10:39 AM
	 *
	 **/
	
	namespace App\Service\Notification\Validator;
	
	abstract class AbstractNotificationValidator
	{
		public function validate(array $data): array
		{
			$errors = [];
			if(empty($data['notify_name']))
			{
				$errors[] = 'Name is required';
			}
			return $errors;
		}
	}