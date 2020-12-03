<?php


namespace App\Service;


use App\Entity\Meal;
use App\Repository\MealRepository;
use Doctrine\ORM\EntityManagerInterface;

class MealsService
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    protected $mealRepository;

    public function __construct(EntityManagerInterface $entityManager, MealRepository $mealRepository)
    {
        $this->entityManager = $entityManager;
        $this->mealRepository = $mealRepository;
    }

    public function getMeals(array $filters)
    {
        return $this->mealRepository->filter($filters);
    }

    public function addMeal(Meal $meal)
    {
        $this->entityManager->persist($meal);
        $this->entityManager->flush();
    }

}