<?php

declare(strict_types=1);

namespace PicoMapper;

use PicoDb\Database;
use PicoDb\Table;

class Mapper
{
    /**
     * @var array<string, callable[]>
     */
    private array $hooks = [];

    /**
     * Mapper constructor.
     */
    public function __construct(private Database $db)
    {
    }

    /**
     * Returns a mapping for the provided definition.
     */
    public function mapping(Definition $definition): Mapping
    {
        return new Mapping($this->db, $definition, [], $this->hooks);
    }

    /**
     * Returns a table object.
     */
    public function table(string $table): Table
    {
        return $this->db->table($table);
    }

    /**
     * Begins a database transaction.
     */
    public function startTransaction(): bool
    {
        return $this->db->startTransaction();
    }

    /**
     * Commits a database transaction.
     */
    public function closeTransaction(): bool
    {
        return $this->db->closeTransaction();
    }

    /**
     * Returns database log messages.
     */
    public function getLogMessages(): array
    {
        return $this->db->getLogMessages();
    }

    /**
     * Registers a new hook.
     */
    public function registerHook(string $event, callable $hook): void
    {
        $this->hooks[$event][] = $hook;
    }
}
