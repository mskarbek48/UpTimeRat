<?php

namespace App\Controller;

use App\Entity\Monitor;
use App\Entity\StatusPage;
use App\Repository\MonitorRepository;
use App\Repository\NotificationSettingsRepository;
use App\Repository\StatusPageRepository;
use App\Service\Monitoring\Presenter\MonitorPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
	
	private MonitorRepository $monitorRepository;
	
	private StatusPageRepository $statusPageRepository;
	
	private NotificationSettingsRepository $notificationSettingsRepository;
	
	public function __construct(MonitorRepository $monitorRepository, StatusPageRepository $statusPageRepository, NotificationSettingsRepository $notificationSettingsRepository)
	{
		$this->monitorRepository = $monitorRepository;
		$this->statusPageRepository = $statusPageRepository;
		$this->notificationSettingsRepository = $notificationSettingsRepository;
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
	public function monitorNew(Request $request): Response
	{
		if($request->isXmlHttpRequest())
		{
			return $this->render('admin/modal/monitor_edit_create.html.twig', [
				'editing' => false,
				'monitor' => new Monitor(),
				'notifications' => $this->notificationSettingsRepository->findAll()
			]);
		}
		return $this->render('admin/monitor_edit_create.html.twig', [
			'editing' => false,
			'monitor' => new Monitor()
		]);
	}
	
	#[Route('/monitor/{id}', name: 'app_admin_monitor_view')]
	public function monitorView(int $id, Request $request): Response
	{
		$notifications = $this->notificationSettingsRepository->findAll();
		if($request->isXmlHttpRequest())
		{
			return $this->render('admin/modal/monitor_edit_create.html.twig', [
				'editing' => true,
				'monitor' => $this->monitorRepository->find($id),
				'notifications' => $notifications
			]);
		}
		return $this->render('admin/monitor_edit_create.html.twig', [
			'editing' => true,
			'monitor' => $this->monitorRepository->find($id)
		]);
	}
	
	#[Route('/uptime/{id}', name: 'app_admin_uptime_view')]
	public function uptimeView(int $id): Response
	{
		$monitor = $this->monitorRepository->find($id);
		$monitorPresenter = new MonitorPresenter($monitor);
		return $this->render('admin/uptime.html.twig', [
			'monitor' => $monitor,
			'monitorPresenter' => $monitorPresenter
			
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
		$monitors = $this->monitorRepository->findAll();
		$statusPage = new StatusPage();
		return $this->render('admin/modal/statuspage_edit_create.html.twig', [
			'monitors' => $monitors,
			'statuspage' => $statusPage
		]);
	}
	
	#[Route('/statuspage/{id}', name: 'app_admin_statuspage_edit')]
	public function statuspageEdit(int $id): Response
	{
		$monitors = $this->monitorRepository->findAll();
		$statusPage = $this->statusPageRepository->find($id);

		return $this->render('admin/modal/statuspage_edit_create.html.twig', [
			'monitors' => $monitors,
			'statuspage' => $statusPage,
		]);
	}
	
	
	
	#[Route('/settings', name: 'app_admin_settings')]
	public function settings(): Response
	{
		$notifications = $this->notificationSettingsRepository->findAll();
		
		return $this->render('admin/settings.html.twig', [
			'controller_name' => 'AdminController',
			'notifications' => $notifications
		]);
	}
	
	#[Route('/settings/components/{type}/{name}', name: 'app_admin_settings_components')]
	public function getComponent(string $type, string $name)
	{
		$path = 'admin/components/' . $type . '/' . $name . '.html.twig';
		return $this->render($path);
	}
}
