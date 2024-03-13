<?php

namespace api\athlete\Domain;

final class Athlete extends ORMName
{
    protected $table = 'athlete';
    //* Some extra orm settings */

    private $id;
    private $uuid;

    public function __construct(int $id, string $uuid)
    {
        $this->id             = $id;
        $this->uuid           = $uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

}

