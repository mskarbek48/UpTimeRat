<?php
	/**
	 * This file is a part of UpTimeRatv2
	 *
	 * @author Maciej Skarbek <macieqskarbek@gmail.com>
	 * @copyright (c) 2024, dBot.pl
	 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
	 * @link https://dbot.pl
	 *
	 * @created/updated at 10/8/24 8:04 AM
	 *
	 **/
	
	namespace App\Controller\Api;
	
	use App\Service\Monitoring\Validator\StatusPageValidator;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Routing\Attribute\Route;
	use Symfony\Component\Security\Http\Attribute\IsGranted;
	use Symfony\Component\HttpFoundation\Request;
	use App\Service\Monitoring\StatusPageService;
	
	#[Route('/api/statuspage')]
	#[IsGranted('ROLE_ADMIN')]
	class StatusPageApiController  extends AbstractController
	{
		#[Route('/create', name: 'api_statuspage_create', methods: ['PUT'])]
		public function create(Request $request, StatusPageService $statusPageService): JsonResponse
		{
			$data = json_decode($request->getContent(), true);
			
			$submittedToken = $data['token'];
			if (!$this->isCsrfTokenValid('add-statuspage', $submittedToken)) {
				return new JsonResponse([
					"errors" => ['Invalid CSRF token'],
					"success" => false,
					"data" => [],
				]);
			}
			
			$errors = (new StatusPageValidator())->validate($data);
			
			if(!empty($errors))
			{
				return new JsonResponse([
					"errors" => $errors,
					"success" => false,
					"data" => [],
				]);
			}
			
			if(!empty($data['edit_id']))
			{
				$statusPageService->edit($data);
				
				return new JsonResponse([
					"errors" => [],
					"success" => true,
					"data" => [],
				]);
			}
			
			$statusPageService->add($data);
			
			return new JsonResponse([
				"errors" => [],
				"success" => true,
				"data" => [],
			]);
			
		}
	}