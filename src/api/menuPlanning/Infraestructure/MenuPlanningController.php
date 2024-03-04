<?php
namespace api\menuPlanning\Infraestructure;


use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\menuPlanning\Domain\MenuPlanningRepositoryInterface;
use api\nutritionalArchitecture\Domain\RecipeNutritionalArchitectureRepositoryInterface;
use PlanningBlockRepositoryInterface;
use src\api\planning\Application\VarietyModeSwitcher;

class MenuPlanningController extends ApiV3BaseController
{
    private $varietyModeSwitcher;

    public function __construct(MenuPlanningRepositoryInterface $menuPlanningRepository, PlanningBlockRepositoryInterface $planningBlockRepository, RecipeNutritionalArchitectureRepositoryInterface $recipeNutritionalArchitectureRepository)
    {
        $this->varietyModeSwitcher = new VarietyModeSwitcher($menuPlanningRepository, $planningBlockRepository, $recipeNutritionalArchitectureRepository);

        parent::__construct();
    }

    public function varietyMode()
    {
        try {
            $athlete = $this->getLoggedAthlete();

            $data = $this->varietyModeSwitcher->switch($athlete);

            // Handling the response through a custom trait
            $this->sendResponse($data);

        } catch(\Exception $e) {
            // Handling possible custom exceptions through a custom trait
            return $this->handleException($e, [
                InvalidAccessException::class
            ], true);
        }
    }
}
