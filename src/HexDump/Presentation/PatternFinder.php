<?php
/**
 * Find patterns in hexdumps
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

/**
 * Find patterns in hexdumps
 *
 * @category   HexDump
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class PatternFinder implements \Iterator
{
    /**
     * @var HexDump\Presentation\Printer
     */
    private $printer;

    /**
     * @var array List of characters
     */
    private $characters = [];

    /**
     * @var array List of matching characters
     */
    private $matches = [];

    /**
     * @var array List of lines to display
     */
    private $lines = [];

    /**
     * @var int The current line (state of the iterator)
     */
    private $line = 0;

    /**
     * Creates instance
     *
     * @param HexDump\Presentation\Printer $printer
     */
    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }

    /**
     * Walks through the characters to find the pattern
     *
     * @param array $pattern
     */
    public function find(array $pattern)
    {
        $pattern = array_reverse($pattern);

        $this->getCharacters();

        $matchedCharacters = [];

        foreach ($this->characters as $lineNumber => $line) {
            foreach ($line['hex'] as $position => $character) {
                if ($pattern[count($matchedCharacters)] == $character) {
                    $matchedCharacters[] = $lineNumber . ':' . $position;

                    if (count($matchedCharacters) === count($pattern)) {
                        $this->matches = array_merge($this->matches, $matchedCharacters);

                        $matchedCharacters = [];
                    }
                } else {
                    $matchedCharacters = [];
                }
            }
        }
    }

    /**
     * Gets all characters from the printer
     */
    private function getCharacters()
    {
        if (!empty($this->characters)) {
            return;
        }

        $characters = [];
        foreach ($this->printer as $lineNumber => $line) {
            $this->lines[] = $line;

            $line['hex'] = array_reverse($line['hex'], true);
            $characters[$lineNumber] = $line;
        }

        $this->characters = array_reverse($characters, true);
    }

    /**
     * Builds a line with converted values
     *
     * @return array Both the converted as the parsed original characters
     */
    private function buildLine()
    {
        $hex = array_fill(0, PRINTER::LINE_LENGTH, '  ');
        $ori = array_fill(0, PRINTER::LINE_LENGTH, ' ');

        if ($this->line === count($this->lines)) {
            return;
        }

        for ($i = 0; $i < PRINTER::LINE_LENGTH; $i++) {

            $wrapper = ['', ''];
            if (array_search($this->line . ':' . $i, $this->matches) !== false) {
                $wrapper = ['<span class="search">', '</span>'];
            }

            $hex[$i] = $wrapper[0] . $this->lines[$this->line]['hex'][$i] . $wrapper[1];
            $ori[$i] = $this->lines[$this->line]['ori'][$i];
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
    {//var_dump(['line' => $this->line, 'valid' => $this->line < count($this->lines)]);
        return $this->line < count($this->lines);
    }
}
