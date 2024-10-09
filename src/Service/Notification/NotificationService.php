<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/9/24 10:33 AM
	 *
	 **/
	
	namespace App\Service\Notification;
	
	use App\Entity\NotificationSettings;
	use Doctrine\ORM\EntityManagerInterface;
	
	class NotificationService
	{
		public function __construct(private EntityManagerInterface $entityManager)
		{}
		
		public function add(array $data)
		{
			$filtered_data = $data;
			unset($filtered_data['name'], $filtered_data['type']);
			
			$notification = new NotificationSettings();
			$notification->setName($data['notify_name']);
			$notification->setType($data['type']);
			$notification->setData($filtered_data);
			
			$this->entityManager->persist($notification);
			$this->entityManager->flush();
		}
	}