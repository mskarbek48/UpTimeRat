<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 8:13 AM
	 *
	 **/
	
	namespace App\Service\Monitoring;
	
	
	
	use App\Entity\Monitor;
	use App\Entity\StatusPage;
	
	class StatusPageService
	{
		public function __construct(private \Doctrine\ORM\EntityManagerInterface $entityManager)
		{
		}
		
		public function add(array $data): void
		{
			$statusPage = new StatusPage();
			$statusPage->setName($data['name']);
			foreach($data['monitors'] as $monitor_id)
			{
				$monitor = $this->entityManager->getRepository(Monitor::class)->find($monitor_id);
				$statusPage->addMonitor($monitor);
			}
			$statusPage->setDescription($data['description']);
			$this->entityManager->persist($statusPage);
			$this->entityManager->flush();
		}
		
		public function edit(array $data): void
		{
			
			$statusPage = $this->entityManager->getRepository(StatusPage::class)->find($data['edit_id']);
			$statusPage->setName($data['name']);
			$statusPage->setDescription($data['description']);
			$monitors = $statusPage->getMonitor();
			foreach($data['monitors'] as $monitor_id)
			{
				$monitor = $this->entityManager->getRepository(Monitor::class)->find($monitor_id);
				if(!$monitors->contains($monitor))
				{
					$statusPage->addMonitor($monitor);
				}
			}
			
			foreach($monitors as $monitor)
			{
				if(!in_array($monitor->getId(), $data['monitors']))
				{
					$statusPage->removeMonitor($monitor);
				}
			}
			
			$this->entityManager->persist($statusPage);
			$this->entityManager->flush();
			
		}
	}