<?php

namespace App\Controller;

use App\Repository\StatusPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusPageController extends AbstractController
{
	
	private EntityManagerInterface $entityManager;
	private StatusPageRepository $statusPageRepository;
	
	public function __construct(EntityManagerInterface $entityManager, StatusPageRepository $statusPageRepository)
	{
		$this->entityManager = $entityManager;
		$this->statusPageRepository = $statusPageRepository;
	}
	
    #[Route('/status/page/{id}', name: 'app_status_page')]
    public function index(int $id): Response
    {
		$statusPage = $this->statusPageRepository->find($id);
		
		$up = 0;
		$total = 0;
		foreach($statusPage->getMonitor() as $monitor) {
			$total++;
			if($monitor->getMonitorStatuses()->last()->getStatus() == 'UP') {
				$up++;
			}
		}
		
		$issues = false;
		if($up < $total)
		{
			$issues = true;
		}
		
        return $this->render('status_page/index.html.twig', [
            'controller_name' => 'StatusPageController',
	        'statusPage' => $statusPage,
	        'issues' => $issues
        ]);
    }
}
