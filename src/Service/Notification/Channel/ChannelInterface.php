<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 11:46 AM
	 *
	 **/
	
	namespace App\Service\Notification\Channel;
	
	interface ChannelInterface
	{
		public function send(string $message): void;
		
		public function format(): string;

	}