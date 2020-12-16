<?php


namespace App\Controller;

use App\Service\MealsService;
use JMS\Serializer\SerializerBuilder;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MealsController extends AbstractController
{
    /**
     * @var MealsService $mealService
     */
    protected $mealService;

    private $serializer;

    /**
     * MealsController constructor.
     * @param MealsService $mealService
     */
    public function __construct(MealsService $mealService)
    {
        $this->mealService = $mealService;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * @Route("/api/meals", name="api_meals_filtered", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getMeals(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page');
        $page = $request->get('page');
        $category = $request->get('category');
        $tags = $request->get('tags');
        $with = $request->get('with');
        $lang = $request->get('lang');
        $diffTime = $request->get('diff_time');

        //Data to return as response
        $filters = ['category' => $category, 'tags' => $tags, 'with' => $with, 'lang' => $lang, 'diff_time' => $diffTime];
        $data = $this->mealService->getMeals($filters);

        //Pagination
        $adapter = new ArrayAdapter($data);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($perPage);
        $pagerfanta->setCurrentPage($page);

        $paginetedData = $pagerfanta->getCurrentPageResults();
        $response = $this->serializer->serialize(
            [
                'meta' => [
                    'currentPage' => intval($page),
                    'totalItems' => count($data),
                    'itemsPerPage' => intval($perPage),
                    'totalPages' => round(count($data) / $perPage)
                ],
                'data' => $paginetedData
            ],
            'json'
        );
        return new JsonResponse($response, 200, [], true);
    }
}