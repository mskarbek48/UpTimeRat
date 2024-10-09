<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 10:36 AM
	 *
	 **/
	
	namespace App\Service\Domain\Validator;
	
	interface ValidatorInterface
	{
		public function validate(array $data): array;
	}