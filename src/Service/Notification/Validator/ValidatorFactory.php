<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 10:25 AM
	 *
	 **/
	
	namespace App\Service\Notification\Validator;
	
	use App\Service\Domain\Validator\ValidatorInterface;
	
	class ValidatorFactory
	{
		public function __construct(private array $data)
		{}
		
		public function factory(): ?ValidatorInterface
		{
			if(!empty($this->data['type']))
			{
				switch($this->data['type'])
				{
					case 'telegram':
						return new TelegramValidator();
						break;
				}
			}
			return null;
		}
	}