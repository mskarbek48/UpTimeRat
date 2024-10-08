<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, mskarbek.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://mskarbek.pl
	 *
	 * @created/updated at 10/4/24 12:13 PM
	 *
	 **/
	
	namespace App\Twig;
	
	use App\Entity\Monitor;
	use App\Service\Monitoring\Presenter\MonitorPresenter;
	
	class MonitorStatusExtension extends \Twig\Extension\AbstractExtension
	{
		public function getFunctions()
		{
			return [
				new \Twig\TwigFunction('monitorUptimeTable', [$this, 'monitorUptimeTable']),
				new \Twig\TwigFunction('monitorUptime', [$this, 'monitorUptime']),
				new \Twig\TwigFunction('monitorStatus', [$this, 'monitorStatus']),
			];
		}
		
		public function monitorUptimeTable(Monitor $monitor, int $limit = 70)
		{
			$monitorPresenter = new MonitorPresenter($monitor);
			
			$last_statuses = $monitorPresenter->getLastStatuses($limit);
			
			$html = '<div class="flex gap-1 overflow-auto">';
			foreach(array_reverse($last_statuses) as $once)
			{
				$html .= '<span class="w-1 h-5 rounded-lg block '.$once->getTailwindBlockClass().'"></span>';
			}
			$html .= '</div>';
			
			return $html;
			
			
		}
		
		public function monitorUptime(Monitor $monitor)
		{
			$monitorPresenter = new MonitorPresenter($monitor);
			$statuses = $monitorPresenter->getLastStatuses();
			$total = count($statuses);
			$up = 0;
			foreach($statuses as $status)
			{
				if($status->getStatus() == "UP" || $status->getStatus() == 'UNKNOWN')
				{
					$up++;
				}
			}
			
			$percent = 0;
			if($total > 0)
			{
				$percent = ($up/$total)*100;
			}
			
			if($percent > 95)
			{
				$color = 'text-emerald-500';
			} elseif($percent > 50)
			{
				$color = 'text-yellow-500';
			} else {
				$color = 'text-red-500';
			}
			
			return '<span class="pt-1 pb-1 pl-2 pr-2 text-sm '.$color.' rounded-lg">'.$percent.'%</span>';
		}
		
		public function monitorStatus(Monitor $monitor)
		{
			$monitorPresenter = new MonitorPresenter($monitor);
			
			$status = $monitorPresenter->getCurrentStatus();
			
			switch ($status->getStatus())
			{
				case "UP":
					return '<div class="text-green-500 font-semibold flex flex-row justify-end gap-2 items-center"> Operational <span class="pulse-green h-2 w-2 block"></span></div>';
				case "DOWN":
					return '<div class="text-red-500 font-semibold flex flex-row justify-end gap-2 items-center"> Down <span class="pulse-red h-2 w-2 block"></span></div>';
				case "UNKNOWN":
					return '<div class="text-yellow-500 font-semibold flex flex-row justify-end gap-2 items-center"> Unknown <span class="pulse-yellow h-2 w-2 block"></span></div>';
			}
			
			
		}
	}