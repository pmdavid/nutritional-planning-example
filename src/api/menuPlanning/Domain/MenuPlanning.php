<?php

namespace api\menuPlanning\Domain;

final class MenuPlanning extends ORMName
{
    protected $table = 'menu_planning';
    //* Some extra orm settings */

    private $id;
    private $mode;

    public function __construct(int $id, string $mode)
    {
        $this->id   = $id;
        $this->mode = $mode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

}

