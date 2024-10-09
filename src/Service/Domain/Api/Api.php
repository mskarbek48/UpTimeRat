<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 11:06 AM
	 *
	 **/
	
	namespace App\Service\Domain\Api;
	
	use Symfony\Component\HttpFoundation\Request;
	
	class Api
	{
		public function __construct(private Request $request)
		{}
		
		public function response(bool $success = false, array $errors = [], array $data = [], string $message = ""): array
		{
			return [
				"success" => $success,
				"errors" => $errors,
				"data" => $data,
				"message" => $message,
				"timestamp" => time()
			];
		}
		
		
	}