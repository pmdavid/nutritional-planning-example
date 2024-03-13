<?php declare(strict_types=1);

namespace api\events;

use api\events\DomainEvent;

class EventBus
{
    private $table;

    public function __construct()
    {
        $this->table = 'domain_events';
    }

    public function publish(DomainEvent $event): void
    {
        $sql = "
            INSERT INTO {$this->table} (
                id,
                aggregate_id,
                name,
                body,
                occurred_on,
                retries,
                status
            ) VALUES (:id, :aggregate_id, :name, :body, :occurred_on, :retries, :status)
        ";

        $params = [
            ':id'           => $event->id(),
            ':aggregate_id' => $event->aggregateId(),
            ':name'         => $event->name(),
            ':body'         => $event->body(),
            ':occurred_on'  => $event->occurredOn(),
            ':retries'      => 0,
            ':status'       => 'pending'
        ];

        $this->executeQuery($sql, $params);
    }

    private function executeQuery(string $sql, array $params): void
    {
        $query = \Yii::$app->getDb()->createCommand($sql, $params);
        $query->execute();
    }
}
