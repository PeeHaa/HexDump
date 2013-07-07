<?php

namespace HexDumpTest\Presentation;

use HexDump\Presentation\Char;

class CharTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers HexDump\Presentation\Char::format
     */
    public function testFormatAscii()
    {
        $char = new Char();

        $this->assertSame('H', $char->format('H'));
    }

    /**
     * @covers HexDump\Presentation\Char::format
     */
    public function testFormatSpace()
    {
        $char = new Char();

        $this->assertSame('.', $char->format(' '));
    }

    /**
     * @covers HexDump\Presentation\Char::format
     */
    public function testFormatLinebreak()
    {
        $char = new Char();

        $this->assertSame('.', $char->format("\n"));
    }

    /**
     * @covers HexDump\Presentation\Char::format
     */
    public function testFormatMultibyte()
    {
        $char = new Char();

        $this->assertSame('.', $char->format('웃'));
    }
}
