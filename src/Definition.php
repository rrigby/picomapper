<?php

namespace PicoMapper;

use LogicException;

class Definition
{
    private bool $autoIncrement = false;

    private bool $readOnly = false;

    /**
     * @var string[]
     */
    private array $columns = [];

    /**
     * @var Property[]
     */
    private array $properties = [];

    private ?string $deletionTimestamp = null;

    /**
     * @var mixed[]
     */
    private array $deletionData = [];

    /**
     * @var mixed[]
     */
    private array $creationData = [];

    /**
     * @var mixed[]
     */
    private array $modificationData = [];

    /**
     * Definition constructor.
     *
     * @param string[] $primaryKey
     */
    public function __construct(private string $table, private array $primaryKey = ['id'])
    {
    }

    /**
     * Configures the primary key to use auto increment.
     */
    public function useAutoIncrement(): static
    {
        if (count($this->primaryKey) > 1) {
            throw new LogicException('Auto increment can only be used for non-composite primary keys.');
        }

        $this->autoIncrement = true;
        return $this;
    }

    /**
     * Sets read-only mode to true.
     */
    public function readOnly(): static
    {
        $this->readOnly = true;
        return $this;
    }

    /**
     * Adds columns to be mapped.
     */
    public function withColumns(string ...$columns): static
    {
        $this->columns = array_merge($this->columns, $columns);
        return $this;
    }

    /**
     * Adds a one-to-one relationship.
     */
    public function withOne(Definition $definition, string $name, string $foreignColumn, string $localColumn = 'id'): static
    {
        $this->properties[] = new Property($name, false, $definition, $localColumn, $foreignColumn);
        return $this;
    }

    /**
     * Adds a one-to-many relationship.
     */
    public function withMany(Definition $definition, string $name, string $foreignColumn, string $localColumn = 'id'): static
    {
        $this->properties[] = new Property($name, true, $definition, $localColumn, $foreignColumn);
        return $this;
    }

    /**
     * Adds a one-to-one relationship through a joined table.
     */
    public function withOneByJoin(Definition $definition, string $name, string $foreignColumn, string $localColumn, string $joinTable, string $joinForeignColumn, string $joinLocalColumn): static
    {
        $property = new Property($name, false, $definition, $localColumn, $foreignColumn);
        $property->join($joinTable, $joinLocalColumn, $joinForeignColumn);

        $this->properties[] = $property;
        return $this;
    }

    /**
     * Adds a one-to-many relationship through a joined table.
     */
    public function withManyByJoin(Definition $definition, string $name, string $foreignColumn, string $localColumn, string $joinTable, string $joinForeignColumn, string $joinLocalColumn): static
    {
        $property = new Property($name, true, $definition, $localColumn, $foreignColumn);
        $property->join($joinTable, $joinLocalColumn, $joinForeignColumn);

        $this->properties[] = $property;
        return $this;
    }

    /**
     * Sets the timestamp column used to signify if a record is deleted.
     */
    public function withDeletionTimestamp(string $column): static
    {
        $this->deletionTimestamp = $column;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is removed.
     */
    public function withDeletionData(array $data): self
    {
        $this->deletionData = $data;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is inserted.
     */
    public function withCreationData(array $data): static
    {
        $this->creationData = $data;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is modified.
     */
    public function withModificationData(array $data): static
    {
        $this->modificationData = $data;
        return $this;
    }

    /**
     * Returns the definition's base table.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Returns the base table's primary key.
     *
     * @return string[]
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * Returns the definition's readonly status.
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * Returns true if the primary key is configured for auto increment.
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * Returns the definition's columns.
     *
     * @return string[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Returns the definition's relationships.
     *
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Returns the name of the timestamp column used to signify if a record is deleted,
     * otherwise null.
     */
    public function getDeletionTimestamp(): ?string
    {
        return $this->deletionTimestamp;
    }

    /**
     * Returns an array of table data to be included when a record is removed.
     *
     * @return mixed[]
     */
    public function getDeletionData(): array
    {
        return $this->deletionData;
    }

    /**
     * Returns an array of table data to be included when a record is inserted.
     *
     * @return mixed[]
     */
    public function getCreationData(): array
    {
        return $this->creationData;
    }

    /**
     * Returns an array of table data to be included when a record is modified.
     *
     * @return mixed[]
     */
    public function getModificationData(): array
    {
        return $this->modificationData;
    }
}
