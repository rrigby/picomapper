<?php

declare(strict_types=1);

namespace PicoMapper;

use PHPUnit\Framework\TestCase;
use PicoDb\Database;

class MapperTest extends TestCase
{
    private ?Mapper $mapper;

    private ?Database $db;

    public function setUp(): void
    {
        $this->db = new Database(['driver' => 'sqlite', 'filename' => ':memory:']);
        $this->mapper = new Mapper($this->db);
    }

    public function tearDown(): void
    {
        $this->mapper = null;
        $this->db = null;
    }

    public function testMapping(): void
    {
        $definition = new Definition('posts');
        $mapping = $this->mapper->mapping($definition);

        $this->assertInstanceOf(Mapping::class, $mapping);
    }
}
