<?php declare(strict_types=1);

namespace api\events;

use Ramsey\Uuid\Uuid;

abstract class DomainEvent
{
    private $id;
    private $aggregateId;
    private $body;
    private $occurredOn;

    abstract public function name(): string;

    public function __construct(string $aggregateId, string $body) {
        $this->id          = Uuid::uuid4()->toString();
        $this->aggregateId = $aggregateId;
        $this->body        = $body;
        $this->occurredOn  = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    }

    public function id(): string
    {
        return $this->id;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
