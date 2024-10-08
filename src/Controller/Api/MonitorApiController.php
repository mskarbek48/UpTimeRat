<?php

namespace App\Controller\Api;

use App\Entity\Monitor;
use App\Entity\MonitorStatus;
use App\Service\Monitoring\MonitorService;
use App\Service\Monitoring\Validator\MonitorValidatorFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/monitor')]
#[IsGranted('ROLE_ADMIN')]
class MonitorApiController extends AbstractController
{
	
	
    #[Route('/add', name: 'app_monitor_api_add', methods: ['PUT'])]
    public function add(Request $request, MonitorService $monitorService): Response
    {
	   
	    $data = json_decode($request->getContent(), true);
		
		$submittedToken = $data['token'];
		if (!$this->isCsrfTokenValid('add-monitor', $submittedToken)) {
			return new JsonResponse([
				"errors" => ['Invalid CSRF token'],
				"success" => false,
				"data" => [],
			]);
		}
		
		$validator = (new MonitorValidatorFactory($data))->factory();
		$errors = $validator->validate($data);
		if(!empty($errors))
		{
			return new JsonResponse([
				"errors" => $errors,
				"success" => false,
				"data" => [],
			]);
		}
		
		if(array_key_exists('edit_id', $data) && $data['edit_id'] > 0)
		{
			$monitorService->edit($data);
		}
		else
		{
			$monitorService->add($data);
		}
		
		#$monitorService->add($data);
		
		return new JsonResponse([
			'errors' => [],
			'success' => true,
			'data' => [],
		]);

    }
	
	#[Route('/delete/{id}', name: 'app_monitor_api_delete', methods: ['DELETE'])]
	public function delete(int $id, MonitorService $monitorService): Response
	{
		try {
			$monitorService->delete($id);
		} catch (\Exception $e) {
			return new JsonResponse([
				'errors' => [$e->getMessage()],
				'success' => false,
				'data' => [],
			]);
		}
		
		return new JsonResponse([
			'errors' => [],
			'success' => true,
			'data' => [],
		]);
	}
	
}
