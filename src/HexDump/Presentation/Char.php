<?php
/**
 * Formats a character
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
 * Formats a character
 *
 * @category   HexDump
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Char
{
    /**
     * Formats non printable characters
     *
     * @param string $char
     *
     * @return string Formatted string
     */
    public function format($char)
    {
        if (ord($char) >= 0 && ord($char) < 0x21) {
            return '.';
        }

        if (ord($char) >= 0x7E && ord($char) <= 0xFF) {
            return '.';
        }

        return $char;
    }
}
