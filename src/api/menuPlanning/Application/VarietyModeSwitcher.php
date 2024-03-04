<?php
namespace src\api\planning\Application;

use api\athlete\Domain\Athlete;
use api\menuPlanning\Domain\MenuPlanning;
use api\menuPlanning\Domain\MenuPlanningRepositoryInterface;
use api\nutritionalArchitecture\Domain\RecipeNutritionalArchitectureRepositoryInterface;
use PlanningBlockRepositoryInterface;
use src\api\menuPlanning\Domain\VarietyModeApplicatorService;
use Yii;

class VarietyModeSwitcher
{
    private $varietyModeApplicatorService;
    private $menuPlanningRepository;

    public function __construct(MenuPlanningRepositoryInterface $menuPlanningRepository, PlanningBlockRepositoryInterface $planningBlockRepository, RecipeNutritionalArchitectureRepositoryInterface $recipeNutritionalArchitectureRepository)
    {
        $this->varietyModeApplicatorService  = new VarietyModeApplicatorService($planningBlockRepository, $recipeNutritionalArchitectureRepository);
        $this->menuPlanningRepository        = $menuPlanningRepository;
    }

    /**
     * USE CASE: User select "variedad de recetas" mode in the app, from the menu planning user configuration
     */
    public function switch(Athlete $athlete): array
    {
        $menuPlanning = $this->menuPlanningRepository->findLastActiveByAthleteId($athlete->getId());

        if ($this->canChangeToVarietyMode($menuPlanning)) {
            $this->varietyModeApplicatorService->applyVarietyMode($athlete, $menuPlanning);
        }

        return [];
    }

    private function canChangeToVarietyMode(MenuPlanning $menuPlanning): bool
    {
        $selectedOption            = (string)Yii::$app->request->post('optionSelected');
        $currentPlanificationMode   = $menuPlanning->getMode();

        if ($selectedOption == 'variety' && $currentPlanificationMode != 'variety') {
            return true;
        }

        return false;
    }
}
