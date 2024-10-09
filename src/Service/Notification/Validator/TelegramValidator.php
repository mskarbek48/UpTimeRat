<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 10:24 AM
	 *
	 **/
	
	namespace App\Service\Notification\Validator;
	
	use App\Service\Domain\Validator\ValidatorInterface;
	
	class TelegramValidator extends AbstractNotificationValidator implements ValidatorInterface
	{
		public function validate(array $data): array
		{
			$errors = parent::validate($data);
			
		
			if(empty($data['bot_token']))
			{
				$errors[] = 'Bot token is required';
			}
			if(empty($data['chat_id']))
			{
				$errors[] = 'Chat ID is required';
			}
			
			return $errors;
		}
	}