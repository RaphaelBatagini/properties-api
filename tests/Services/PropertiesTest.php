<?php

use App\Services\Properties;

use PHPUnit\Framework\TestCase;

final class PropertiesTest extends TestCase
{
    public function testShouldHavePropertiesListFormat()
    {
        $properties = Properties::list();
        $this->assertArrayHasKey('pageNumber', $properties);
        $this->assertArrayHasKey('pageSize', $properties);
        $this->assertArrayHasKey('totalCount', $properties);
        $this->assertArrayHasKey('listings', $properties);
    }
}