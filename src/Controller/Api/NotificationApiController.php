<?php

namespace App\Controller\Api;

use App\Service\Notification\NotificationService;
use App\Service\Notification\Validator\ValidatorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/notification/api')]
class NotificationApiController extends AbstractController
{
    #[Route('/add', name: 'app_notification_api_add', methods: ['PUT'])]
    public function add(Request $request, NotificationService $notificationService): Response
    {
	    $data = json_decode($request->getContent(), true);

	    $submittedToken = $data['token'];
	    if (!$this->isCsrfTokenValid('add-notify', $submittedToken)) {
		    return new JsonResponse([
			    "errors" => ['Invalid CSRF token'],
			    "success" => false,
			    "data" => [],
		    ]);
	    }
		
		
		$validator = (new ValidatorFactory($data))->factory();
		
		$errors = $validator->validate($data);
		if(!empty($errors))
		{
			return new JsonResponse([
				"errors" => $errors,
				"success" => false,
				"data" => [],
			]);
		}
		
		$notificationService->add($data);
		
		
		
		return new JsonResponse([
			'errors' => [],
			'success' => true,
			'data' => [],
		]);
    }
}
