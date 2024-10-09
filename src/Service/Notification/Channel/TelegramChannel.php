<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 11:48 AM
	 *
	 **/
	
	namespace App\Service\Notification\Channel;
	
	use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
	use Symfony\Component\Notifier\ChatterInterface;
	use Symfony\Component\Notifier\Message\ChatMessage;
	
	class TelegramChannel implements ChannelInterface
	{
		public function __construct(private array $settings, private ChatterInterface $chatter){}
		
		public function format(): string {
			return 'telegram';
		}
		
		public function send(string $message): void
		{
			$chatMessage = new ChatMessage($message);
			$telegramOptions = (new TelegramOptions())
				->chatId($this->settings['chat_id'])
				->parseMode('HTML')
				->disableNotification(false)
				->disableWebPagePreview(false);
			$chatMessage->options($telegramOptions);
			$this->chatter->send($chatMessage);
		}
	}