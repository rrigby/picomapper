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
     *
     * @return Table
     */
    public function table(string $table)
    {
        return $this->db->table($table);
    }

    /**
     * Begins a database transaction.
     *
     * @return bool
     */
    public function startTransaction()
    {
        return $this->db->startTransaction();
    }

    /**
     * Commits a database transaction.
     *
     * @return bool
     */
    public function closeTransaction()
    {
        return $this->db->closeTransaction();
    }

    /**
     * Returns database log messages.
     *
     * @return array
     */
    public function getLogMessages()
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
