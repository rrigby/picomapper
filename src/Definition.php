<?php

namespace PicoMapper;

class Definition
{
    /**
     * @var string
     */
    private string $table;

    /**
     * @var string[]
     */
    private array $primaryKey = [];

    /**
     * @var bool
     */
    private bool $autoIncrement = false;

    /**
     * @var bool
     */
    private bool $readOnly = false;

    /**
     * @var string[]
     */
    private array $columns = [];

    /**
     * @var Property[]
     */
    private array $properties = [];

    /**
     * @var string|null
     */
    private ?string $deletionTimestamp;

    /**
     * @var array
     */
    private array $deletionData = [];

    /**
     * @var array
     */
    private array $creationData = [];

    /**
     * @var array
     */
    private array $modificationData = [];

    /**
     * Definition constructor.
     *
     * @param string   $table
     * @param string[] $primaryKey
     */
    public function __construct(string $table, array $primaryKey = ['id'])
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    /**
     * Configures the primary key to use auto increment.
     *
     * @return Definition
     */
    public function useAutoIncrement(): self
    {
        if (count($this->primaryKey) > 1) {
            throw new \LogicException('Auto increment can only be used for non-composite primary keys.');
        }

        $this->autoIncrement = true;
        return $this;
    }

    /**
     * Sets read-only mode to true.
     *
     * @return Definition
     */
    public function readOnly(): self
    {
        $this->readOnly = true;
        return $this;
    }

    /**
     * Adds columns to be mapped.
     *
     * @param string ...$columns
     * @return Definition
     */
    public function withColumns(string ...$columns): self
    {
        $this->columns = array_merge($this->columns, $columns);
        return $this;
    }

    /**
     * Adds a one-to-one relationship.
     *
     * @param Definition $definition
     * @param string     $name
     * @param string     $foreignColumn
     * @param string     $localColumn
     * @return Definition
     */
    public function withOne(Definition $definition, string $name, string $foreignColumn, string $localColumn = 'id'): self
    {
        $this->properties[] = new Property($name, false, $definition, $localColumn, $foreignColumn);
        return $this;
    }

    /**
     * Adds a one-to-many relationship.
     *
     * @param Definition $definition
     * @param string     $name
     * @param string     $foreignColumn
     * @param string     $localColumn
     * @return Definition
     */
    public function withMany(Definition $definition, string $name, string $foreignColumn, string $localColumn = 'id'): self
    {
        $this->properties[] = new Property($name, true, $definition, $localColumn, $foreignColumn);
        return $this;
    }

    /**
     * Adds a one-to-many relationship through a joined table.
     *
     * @param Definition $definition
     * @param string $name
     * @param string $foreignColumn
     * @param string $localColumn
     * @param string $joinTable
     * @param string $joinForeignColumn
     * @param string $joinLocalColumn
     * @return Definition
     */
    public function withManyByJoin(Definition $definition, string $name, string $foreignColumn, string $localColumn, string $joinTable, string $joinForeignColumn, string $joinLocalColumn): self
    {
        $property = new Property($name, true, $definition, $localColumn, $foreignColumn);
        $property->join($joinTable, $joinLocalColumn, $joinForeignColumn);

        $this->properties[] = $property;
        return $this;
    }

    /**
     * Sets the timestamp column used to signify if a record is deleted.
     *
     * @param string $column
     * @return Definition
     */
    public function withDeletionTimestamp(string $column): self
    {
        $this->deletionTimestamp = $column;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is removed.
     *
     * @param array $data
     * @return Definition
     */
    public function withDeletionData(array $data): self
    {
        $this->deletionData = $data;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is inserted.
     *
     * @param array $data
     * @return Definition
     */
    public function withCreationData(array $data): self
    {
        $this->creationData = $data;
        return $this;
    }

    /**
     * Sets an array of table data to be included when a record is modified.
     *
     * @param array $data
     * @return Definition
     */
    public function withModificationData(array $data): self
    {
        $this->modificationData = $data;
        return $this;
    }

    /**
     * Returns the definition's base table.
     *
     * @return string
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
     *
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * Returns true if the primary key is configured for auto increment.
     *
     * @return bool
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
     *
     * @return null|string
     */
    public function getDeletionTimestamp(): ?string
    {
        return $this->deletionTimestamp;
    }

    /**
     * Returns an array of table data to be included when a record is removed.
     *
     * @return array
     */
    public function getDeletionData(): array
    {
        return $this->deletionData;
    }

    /**
     * Returns an array of table data to be included when a record is inserted.
     *
     * @return array
     */
    public function getCreationData(): array
    {
        return $this->creationData;
    }

    /**
     * Returns an array of table data to be included when a record is modified.
     *
     * @return array
     */
    public function getModificationData(): array
    {
        return $this->modificationData;
    }
}
