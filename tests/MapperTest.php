<?php

use PHPUnit\Framework\TestCase;
use Pourbahrami\Mapper\Mapper;

final class MapperTest extends TestCase
{
    private $json_string = '{"id":1,"name":"John","posts":[{"id":2,"title":"foo"},{"id":3,"title":"bar"},{"id":4,"title":"baz"}]}';

    private $xml_string = <<<XML
    <?xml version="1.0"?>
    <person>
        <id>1</id>
        <name>John</name>
        <posts>
            <id>2</id>
            <title>foo</title>
        </posts>
        <posts>
            <id>3</id>
            <title>bar</title>
        </posts>
        <posts>
            <id>4</id>
            <title>baz</title>
        </posts>
    </person>
    XML;

    public function testCanBeCreatedFromJson(): void
    {
        $this->assertInstanceOf(
            Mapper::class,
            Mapper::createFromJson($this->json_string)
        );
    }

    public function testCanBeCreatedFromXml(): void
    {
        $this->assertInstanceOf(
            Mapper::class,
            Mapper::createFromXml($this->xml_string)
        );
    }
}
