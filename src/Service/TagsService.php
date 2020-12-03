<?php


namespace App\Service;


use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;

class TagsService
{

    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * @var TagsRepository $tagRepository
     */
    protected $tagRepository;

    public function __construct(EntityManagerInterface $entityManager, TagsRepository $tagRepository)
    {
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
    }

    public function addTag(Tags $tag)
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    }

    public function getTag(int $id)
    {
        return $this->tagRepository->find($id);
    }
}