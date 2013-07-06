<?php

namespace HexDumpTest\Unit\Core;

use HexDump\Core\Autoloader;

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers HexDump\Core\Autoloader::__construct
     */
    public function testConstructCorrectInstance()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertInstanceOf('\\HexDump\\Core\\Autoloader', $autoloader);
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     */
    public function testRegister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::unregister
     */
    public function testUnregister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
        $this->assertTrue($autoloader->unregister());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadSuccess()
    {
        $autoloader = new Autoloader('FakeProject', __DIR__ . '/../Mocks/Core');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadSuccessExtraSlashedNamespace()
    {
        $autoloader = new Autoloader('\\\\FakeProject', __DIR__ . '/../Mocks/Core');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadSuccessExtraForwardSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', __DIR__ . '/../Mocks/Core//');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadSuccessExtraBackwardSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', __DIR__ . '/../Mocks/Core\\');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadSuccessExtraMixedSlashedPath()
    {
        $autoloader = new Autoloader('FakeProject', __DIR__ . '/../Mocks/Core\\\\/\\//');

        $this->assertTrue($autoloader->register());

        $someClass = new \FakeProject\NS\SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers HexDump\Core\Autoloader::__construct
     * @covers HexDump\Core\Autoloader::register
     * @covers HexDump\Core\Autoloader::load
     */
    public function testLoadUnknownClass()
    {
        $autoloader = new Autoloader('FakeProject', __DIR__ . '/../Mocks/Core\\\\/\\//');

        $this->assertTrue($autoloader->register());

        $this->assertFalse($autoloader->load('IDontExistClass'));
    }
}
