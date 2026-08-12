<?php

declare(strict_types=1);

namespace PicoMapper;

class Property
{
    private ?string $joinTable = null;

    private ?string $joinLocalColumn = null;

    private ?string $joinForeignColumn = null;

    /**
     * Property constructor.
     */
    public function __construct(private string $name, private bool $collection, private Definition $definition, private string $localColumn, private string $foreignColumn)
    {
    }

    /**
     * Adds a join to the definition.
     */
    public function join(string $table, string $localColumn, string $foreignColumn): void
    {
        $this->joinTable = $table;
        $this->joinLocalColumn = $localColumn;
        $this->joinForeignColumn = $foreignColumn;
    }

    /**
     * Returns the property's name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns true if the property is a collection.
     */
    public function isCollection(): bool
    {
        return $this->collection;
    }

    /**
     * Returns the definition used to fetch the property.
     */
    public function getDefinition(): Definition
    {
        return $this->definition;
    }

    /**
     * Returns the local column name.
     */
    public function getLocalColumn(): string
    {
        return $this->localColumn;
    }

    /**
     * Returns the foreign column name.
     */
    public function getForeignColumn(): string
    {
        return $this->foreignColumn;
    }

    /**
     * Returns the join table.
     */
    public function getJoinTable(): ?string
    {
        return $this->joinTable;
    }

    /**
     * Returns the join's local column.
     */
    public function getJoinLocalColumn(): ?string
    {
        return $this->joinLocalColumn;
    }

    /**
     * Returns the join's foreign column.
     */
    public function getJoinForeignColumn(): ?string
    {
        return $this->joinForeignColumn;
    }
}
