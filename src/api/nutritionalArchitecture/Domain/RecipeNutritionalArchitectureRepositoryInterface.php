<?php

namespace api\nutritionalArchitecture\Domain;

interface RecipeNutritionalArchitectureRepositoryInterface
{
    public function create(array $items): void;
}
