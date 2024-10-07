<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/7/24 11:21 AM
	 *
	 **/
	
	namespace App\DataFixtures;
	
	use Doctrine\Bundle\FixturesBundle\Fixture;
	use Doctrine\Persistence\ObjectManager;
	
	class SettingsFixtures extends Fixture
	{
		public function __construct()
		{
		}
		
		public function load(ObjectManager $manager): void
		{
		
			$settings = [
				
				[
					"name" => "How many days keep uptime history",
					"value" => 30,
					"key" => "uptime_history_days",
				],
			];
			
			foreach ($settings as $setting) {
				$settings = new \App\Entity\Settings();
				$settings->setName($setting['name']);
				$settings->setValue($setting['value']);
				$settings->setKey($setting['key']);
				$manager->persist($settings);
			}
			
			$manager->flush();
			
		}
	}