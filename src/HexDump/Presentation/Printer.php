<?php
/**
 * Iterates to show the result
 *
 * PHP version 5.4
 *
 * @category   HexDump
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace HexDump\Presentation;

use HexDump\Presentation\Char;

/**
 * Iterates to show the result
 *
 * @category   HexDump
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Printer implements \Iterator
{
    /**
     * @var int Maximum characters on a line
     */
    const LINE_LENGTH = 23;

    /**
     * @var HexDump\Presentation\Char
     */
    private $charParser;

    /**
     * @var string The data to convert
     */
    private $data;

    /**
     * @var int The current line (state of the iterator)
     */
    private $line = 0;

    /**
     * Creates instance
     *
     * @param HexDump\Presentation\Char $charParser
     * @param string                    $data
     */
    public function __construct(Char $charParser, $data)
    {
        $this->charParser = $charParser;
        $this->data       = $data;
    }

    /**
     * Builds a line with converted values
     *
     * @return array Both the converted as the parsed original characters
     */
    private function buildLine()
    {
        $hex = array_fill(0, self::LINE_LENGTH, '  ');
        $ori = array_fill(0, self::LINE_LENGTH, ' ');

        for ($i = 0; $i < self::LINE_LENGTH; $i++) {
            $position = $i + ($this->line * self::LINE_LENGTH);

            if ($position >= strlen($this->data)) {
                break;
            }

            $hex[$i] = bin2hex($this->data[$position]);
            $ori[$i] = $this->charParser->format($this->data[$position]);
        }

        return [
            'hex' => $hex,
            'ori' => $ori,
        ];
    }

    /**
     * Gets the current output line
     *
     * @return array
     */
    public function current()
    {
        return $this->buildLine();
    }

    /**
     * Gets the current output linenumber
     *
     * @return int
     */
    public function key()
    {
        return $this->line;
    }

    /**
     * Gets the next output line
     *
     * @return array
     */
    public function next()
    {
        $this->line++;

        return $this->current();
    }

    /**
     * Rewinds the output
     */
    public function rewind()
    {
        $this->line = 0;
    }

    /**
     * Rewinds the output
     *
     * @return bool True when valid
     */
    public function valid()
    {
        return ($this->line * self::LINE_LENGTH) < strlen($this->data);
    }
}
