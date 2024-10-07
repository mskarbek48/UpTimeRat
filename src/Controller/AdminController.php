<?php

namespace App\Controller;

use App\Repository\MonitorRepository;
use App\Repository\StatusPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
	
	private MonitorRepository $monitorRepository;
	
	private StatusPageRepository $statusPageRepository;
	
	public function __construct(MonitorRepository $monitorRepository, StatusPageRepository $statusPageRepository)
	{
		$this->monitorRepository = $monitorRepository;
		$this->statusPageRepository = $statusPageRepository;
	}
	
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
	        'monitors' => $this->monitorRepository->findAll()
        ]);
    }
	
	#[Route('/monitor', name: 'app_admin_monitor_list')]
	public function monitorList(): Response
	{
		return $this->render('admin/monitor_list.html.twig', [
			'controller_name' => 'AdminController',
			'monitors' => $this->monitorRepository->findAll()
		]);
	}
	
	#[Route('/monitor/new', name: 'app_admin_monitor_new')]
	public function monitorNew(): Response
	{
		return $this->render('admin/monitor_new.html.twig', [
			'controller_name' => 'AdminController'
		]);
	}
	
	#[Route('/monitor/{id}', name: 'app_admin_monitor_view')]
	public function monitorView(int $id): Response
	{
		return $this->render('admin/monitor_view.html.twig', [
			'controller_name' => 'AdminController',
			'monitor' => $this->monitorRepository->find($id)
		]);
	}
	

	
	#[Route('/settings', name: 'app_admin_settings')]
	public function settings(): Response
	{
		return $this->render('admin/settings.html.twig', [
			'controller_name' => 'AdminController'
		]);
	}
	
	#[Route('/statuspage', name: 'app_admin_statuspage')]
	public function statuspage(): Response
	{
		return $this->render('admin/statuspage.html.twig', [
			'controller_name' => 'AdminController',
			'pages' => $this->statusPageRepository->findAll()
		]);
	}
	
	#[Route('/statuspage/new', name: 'app_admin_statuspage_new')]
	public function statuspageNew(): Response
	{
		return $this->render('admin/statuspage_new.html.twig', [
			'controller_name' => 'AdminController'
		]);
	}
	
	#[Route('/statuspage/{id}', name: 'app_admin_statuspage_view')]
	public function statuspageView(int $id): Response
	{
		$monitors = $this->monitorRepository->findAll();
		return $this->render('admin/statuspage_view.html.twig', [
			'controller_name' => 'AdminController',
			'page' => $this->statusPageRepository->find($id),
			'monitors' => $monitors
		]);
	}
}
