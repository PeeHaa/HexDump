<?php
/**
 * Interface for HTTP request classes
 *
 * PHP version 5.4
 *
 * @category   HexDump
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace HexDump\Http;

/**
 * Interface for HTTP request classes
 *
 * @category   HexDump
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface RequestData
{
    /**
     * Gets the path of the URI
     *
     * @return string The path
     */
    public function getPath();

    /**
     * Gets the get variables
     *
     * @return array The get variables
     */
    public function getGetVariables();

    /**
     * Gets a get variable
     *
     * @return mixed The get variable value (or null if it doesn't exists)
     */
    public function getGetVariable($key, $defaultValue = null);

    /**
     * Gets the post variables
     *
     * @return array The post variables
     */
    public function getPostVariables();

    /**
     * Gets a post variable
     *
     * @return mixed The post variable value (or null if it doesn't exists)
     */
    public function getPostVariable($key, $defaultValue = null);

    /**
     * Gets the cookie variables
     *
     * @return array The cookie variables
     */
    public function getCookieVariables();

    /**
     * Gets a cookie variable
     *
     * @return mixed The cookie variable value (or null if it doesn't exists)
     */
    public function getCookieVariable($key, $defaultValue = null);

    /**
     * Gets the HTTP method
     *
     * @return string The HTTP method
     */
    public function getMethod();

    /**
     * Gets the host
     *
     * @return string The host
     */
    public function getHost();

    /**
     * Check whether the connection is over SSL
     *
     * @return boolean Whether the connection is over SSL
     */
    public function isSsl();
}
