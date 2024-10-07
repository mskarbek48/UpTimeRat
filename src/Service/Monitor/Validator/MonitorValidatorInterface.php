<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 10:39 AM
	 *
	 **/
	
	namespace App\Service\Monitor\Validator;
	
	interface MonitorValidatorInterface
	{
		public function validate(array $data): array;
	}