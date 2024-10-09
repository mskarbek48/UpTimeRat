<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 12:07 PM
	 *
	 **/
	
	namespace App\Service\Monitoring\Presenter;
	
	class NotificationPresenter
	{
		public function __construct(private MonitorPresenter $monitorPresenter, private string $format = 'raw')
		{}
		
		public function getMessage(): string
		{
			$status = $this->monitorPresenter->getCurrentStatus();
			$title = "{$status->getEmoji()} Monitor {$this->monitorPresenter->getName()} is {$status->getStatus()}!";
			$msg = "";
			switch($this->format)
			{
				case "raw":
					$msg = "";
					break;
				case "telegram":
					$msg = "<b>{$title}</b>\n\n";
					$msg .= "Checked at: <b>{$status->getFormattedDate()}</b>\n\n";
					$msg .= "{$status->getResponseCode()} - {$status->getResponseMessage()}\n\n";
					break;
			}
			
			return $msg;
			
		
		
		}
	}