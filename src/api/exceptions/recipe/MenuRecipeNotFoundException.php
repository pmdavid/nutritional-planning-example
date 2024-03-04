<?php
namespace api\exceptions\recipe;

use api\repositories\AppTextRepository;
use Exception;

class MenuRecipeNotFoundException extends Exception
{
    private $appTextRepository;

    /**
     * MenuRecipeNotFoundException constructor.
     * @param $menuRecipeId
     */
    public function __construct($menuRecipeId)
    {
        $this->appTextRepository = new AppTextRepository();
        parent::__construct($this->appTextRepository->findValueByKey("EXCEPTION_MENU_RECIPE_NOT_FOUND") . $menuRecipeId, 400);
    }
}
