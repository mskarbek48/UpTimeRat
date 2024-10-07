<?php

namespace App\DataFixtures;

use App\Entity\Monitor;
use App\Entity\StatusPage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MonitorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
	    $statusPage = new StatusPage();
	    $statusPage->setName('Main Page');
		
		$monitor = new Monitor();
		
		$monitor->setIpAddress('1.1.1.1');
		$monitor->setPort(80);
		$monitor->setType('port');
		$monitor->setName('Cloudflare DNS 80 port');
		$monitor->setShortName("C80P");
		$monitor->setIntervalTime(60);
		$monitor->setTries(1);
		$monitor->setCreated(new \DateTime('now'));
	    
	    $statusPage->addMonitor($monitor);
		$manager->persist($monitor);
		
		$monitor = new Monitor();
		$monitor->setUrl("https://www.google.com");
		$monitor->setType('website');
		$monitor->setName('Google');
		$monitor->setIntervalTime(60);
		$monitor->setTries(1);
		$monitor->setShortName("google");
		$monitor->setCreated(new \DateTime('now'));
		
		$manager->persist($monitor);
		$statusPage->addMonitor($monitor);
		
		$monitor = new Monitor();
		$monitor->setIpAddress('2.3.4.5');
		$monitor->setPort(81);
		$monitor->setType('port');
		$monitor->setName('Test');
		$monitor->setShortName("Test");
		$monitor->setIntervalTime(60);
		$monitor->setTries(1);
		$monitor->setCreated(new \DateTime('now'));
		$manager->persist($monitor);
		
		$statusPage->addMonitor($monitor);
		
		$manager->persist($statusPage);
		
		$manager->flush();
    }
}
