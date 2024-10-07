<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MonitorRepository;

class MonitorController extends AbstractController
{
	public function __construct(private MonitorRepository $monitorRepository)
	{}
	
    #[Route('/monitor/{id}', name: 'app_monitor')]
    public function index(int $id): Response
    {
		
		$monitor = $this->monitorRepository->find($id);
		
        return $this->render('monitor/index.html.twig', [
            'monitor' => $monitor
        ]);
    }
}
