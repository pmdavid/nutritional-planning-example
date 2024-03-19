<?php
namespace api\menuPlanning\Infraestructure;


use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\menuPlanning\Infraestructure\persistence\MenuPlanningMysqlRepository;
use api\nutritionalArchitecture\RecipeNutritionalArchitectureMysqlRepository;
use api\planningBlock\infraestructure\persistence\PlanningBlockMysqlRepository;
use src\api\planning\Application\VarietyModeSwitcher;

class MenuPlanningController extends ApiV3BaseController
{
    public function varietyMode()
    {
        try {
            $menuPlanningRepository                  = new MenuPlanningMysqlRepository();
            $planningBlocRepository                  = new PlanningBlockMysqlRepository();
            $recipeNutritionalArchitectureRepository = new RecipeNutritionalArchitectureMysqlRepository();

            $varietyModeSwitcher = new VarietyModeSwitcher($menuPlanningRepository, $planningBlocRepository, $recipeNutritionalArchitectureRepository);
            $athlete             = $this->getLoggedAthlete();

            $data = $varietyModeSwitcher->switch($athlete);

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
