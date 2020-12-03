<?php


namespace App\Service;


use App\Entity\Ingredients;
use App\Repository\IngredientsRepository;
use Doctrine\ORM\EntityManagerInterface;

class IngredientsService
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * @var IngredientsRepository $ingredientRepository
     */
    protected $ingredientRepository;

    public function __construct(EntityManagerInterface $entityManager, IngredientsRepository $ingredientRepository)
    {
        $this->entityManager = $entityManager;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function getIngredient(int $id)
    {
        return $this->ingredientRepository->find($id);
    }

    public function addIngredient(Ingredients $ingredient)
    {
        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();
    }

}