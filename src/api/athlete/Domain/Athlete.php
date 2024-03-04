<?php

namespace api\athlete\Domain;

final class Athlete extends ORMName
{
    protected $table = 'menu_recipe';
    //* Some extra orm settings */

    private $id;

    public function __construct(int $id, string $mode)
    {
        $this->id             = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }



}

