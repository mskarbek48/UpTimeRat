<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 11:48 AM
	 *
	 **/
	
	namespace App\Service\Monitoring;
	
	use App\Entity\Monitor;
	use App\Entity\MonitorStatus;
	use App\Entity\NotificationSettings;
	use Symfony\Component\HttpFoundation\JsonResponse;
	
	class MonitorService
	{
		public function __construct(private \Doctrine\ORM\EntityManagerInterface $entityManager)
		{
		}
		
		public function add(array $data): void
		{
			$monitor = new Monitor();
			$monitor->setCreated(new \DateTime('now'));
			$monitor->setName($data['name']);
			$monitor->setShortName($data['shortname']);
			$monitor->setUrl(strlen($data['url']) ? $data['url'] : null);
			$monitor->setPort(strlen($data['port']) ? $data['port'] : null);
			$monitor->setTries($data['tries']);
			$monitor->setType($data['type']);
			$monitor->setIntervalTime($data['interval']);
			
			if(isset($data['notifications']))
			{
				foreach ($data['notifications'] as $notification) {
					$notification = $this->entityManager->getRepository(NotificationSettings::class)->find($notification);
					if($notification)
					{
						$monitor->addNotification($notification);
					}
				}
			}
			
			$this->entityManager->persist($monitor);
			$this->entityManager->flush();
		}
		
		public function edit(array $data): void
		{
			$monitor = $this->entityManager->getRepository(Monitor::class)->find($data['edit_id']);
			if(!$monitor)
			{
				throw new \Exception('Monitor not found');
			}
			
			$monitor->setName($data['name']);
			$monitor->setShortName($data['shortname']);
			$monitor->setUrl(strlen($data['url']) ? $data['url'] : null);
			$monitor->setPort(strlen($data['port']) ? $data['port'] : null);
			$monitor->setTries($data['tries']);
			$monitor->setType($data['type']);
			$monitor->setIntervalTime($data['interval']);
			
			if(isset($data['notifications']))
			{
				foreach($data['notifications'] as $notification)
				{
					$notification = $this->entityManager->getRepository(NotificationSettings::class)->find($notification);
					if($notification && !$monitor->getNotifications()->contains($notification))
					{
						$monitor->addNotification($notification);
					}
				}
				foreach($monitor->getNotifications() as $notification)
				{
					if(!in_array($notification->getId(), $data['notifications']))
					{
						$monitor->removeNotification($notification);
					}
				}
			}
			
			$this->entityManager->persist($monitor);
			$this->entityManager->flush();
			
		}
		
		public function delete(int $id): void
		{
			$monitor = $this->entityManager->getRepository(Monitor::class)->find($id);
			if(!$monitor)
			{
				throw new \Exception('Monitor not found');
			}
			
			$monitorStatus = $this->entityManager->getRepository(MonitorStatus::class)->findBy(['monitor' => $monitor]);
			foreach ($monitorStatus as $status) {
				$this->entityManager->remove($status);
			}
			
			$this->entityManager->remove($monitor);
			$this->entityManager->flush();
		}
	}