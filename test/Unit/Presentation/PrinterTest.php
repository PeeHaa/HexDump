<?php

namespace HexDumpTest\Presentation;

use HexDump\Presentation\Printer,
    HexDump\Presentation\Char;

class PrinterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers HexDump\Presentation\Printer::__construct
     * @covers HexDump\Presentation\Printer::buildLine
     * @covers HexDump\Presentation\Printer::current
     * @covers HexDump\Presentation\Printer::key
     * @covers HexDump\Presentation\Printer::next
     * @covers HexDump\Presentation\Printer::rewind
     * @covers HexDump\Presentation\Printer::valid
     */
    public function testFirstLine()
    {
        $char = new Char();
        $printer = new Printer($char, str_repeat('H', 30));

        $hex = array_fill(0, 23, '48');
        $ori = array_fill(0, 23, 'H');

        foreach ($printer as $line) {
            $this->assertSame($hex, $line['hex']);
            $this->assertSame($ori, $line['ori']);

            break;
        }
    }

    /**
     * @covers HexDump\Presentation\Printer::__construct
     * @covers HexDump\Presentation\Printer::buildLine
     * @covers HexDump\Presentation\Printer::current
     * @covers HexDump\Presentation\Printer::key
     * @covers HexDump\Presentation\Printer::next
     * @covers HexDump\Presentation\Printer::rewind
     * @covers HexDump\Presentation\Printer::valid
     */
    public function testTwoLines()
    {
        $char = new Char();
        $printer = new Printer($char, str_repeat('H', 30));

        $hex = array_fill(0, 23, '48');
        $ori = array_fill(0, 23, 'H');

        $hex2 = array_fill(0, 7, '48');
        $ori2 = array_fill(0, 7, 'H');

        foreach ($printer as $index => $line) {
            $this->assertSame($hex, $line['hex']);
            $this->assertSame($ori, $line['ori']);

            break;
        }
    }
}
