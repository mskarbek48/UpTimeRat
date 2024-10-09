<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 11:47 AM
	 *
	 **/
	
	namespace App\Service\Notification\Channel;
	
	use Symfony\Component\Notifier\Chatter;
	use Symfony\Component\Notifier\ChatterInterface;
	
	class ChannelFactory
	{
		public function __construct(private string $type, private array $settings, private ChatterInterface $chatter){}
		
		public function factory(): ChannelInterface
		{
			switch($this->type)
			{
				case "telegram":
					return new TelegramChannel($this->settings, $this->chatter);
			}
		}
	}