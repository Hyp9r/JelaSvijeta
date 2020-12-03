<?php


namespace App\Command;


use App\Entity\Category;
use App\Entity\Ingredients;
use App\Entity\Meal;
use App\Entity\Tags;
use App\Service\CategoryService;
use App\Service\IngredientsService;
use App\Service\MealsService;
use App\Service\TagsService;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class FakerCommand extends Command
{

    protected static $defaultName = 'app:run-faker';

    /**
     * @var Generator $faker
     */
    protected $faker;

    /**
     * @var MealsService $mealService
     */
    protected $mealService;

    protected $ingredientService;

    protected $tagService;

    protected $categoryService;

    /**
     * @var SluggerInterface $slugger
     */
    protected $slugger;

    public function __construct(
        MealsService $mealService,
        CategoryService $categoryService,
        IngredientsService $ingredientService,
        TagsService $tagService,
        SluggerInterface $slugger
    ) {
        $this->faker = Factory::create();
        $this->mealService = $mealService;
        $this->slugger = $slugger;
        $this->categoryService = $categoryService;
        $this->ingredientService = $ingredientService;
        $this->tagService = $tagService;
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Populate database with faker data')->setHelp('This command populates data in database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Tags
        for ($i = 0; $i < 10; $i++) {
            $tag = new Tags();
            $tag->setTitle($this->faker->colorName);
            $tag->setSlug($this->slugger->slug($tag->getTitle())->lower());
            $this->tagService->addTag($tag);
        }

        //Ingredients
        for ($i = 0; $i < 10; $i++) {
            $ingredient = new Ingredients();
            $ingredient->setTitle($this->faker->name);
            $ingredient->setSlug($this->slugger->slug($ingredient->getTitle())->lower());
            $this->mealService->addIngredient($ingredient);
        }

        //Categories
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setTitle($this->faker->name);
            $category->setSlug($this->slugger->slug($category->getTitle())->lower());
            $this->categoryService->addCategory($category);
        }

        //Meals
        for ($i = 0; $i < 10; $i++) {
            $hasCategory = rand(0, 1);
            $meal = new Meal();
            $meal->setName($this->faker->name);
            $meal->setDescription($this->faker->text);
            $meal->setStatus('CREATED');

            if ($hasCategory) {
                $meal->setCategory($this->categoryService->getCategory(rand(1, 9)));
            }

            $meal->addTag($this->tagService->getTag(rand(1, 9)));
            $meal->addIngredient($this->ingredientService->getIngredient(rand(1, 9)));

            $this->mealService->addMeal($meal);
        }

        $output->writeln('Data generated');
        return Command::SUCCESS;
    }
}