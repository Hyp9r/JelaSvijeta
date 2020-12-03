<?php


namespace App\Service;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{

    protected $entityManager;

    protected $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    public function addCategory(Category $category)
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function getCategory(int $id)
    {
        return $this->categoryRepository->find($id);
    }

}