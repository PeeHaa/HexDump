<?php
/**
 * This bootstraps the HexDump application
 *
 * PHP version 5.4
 *
 * @category   HexDump
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace HexDump;

use HexDump\Core\Autoloader,
    HexDump\Http\Request;

/**
 * Setup error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

/**
 * Setup timezone
 */
ini_set('date.timezone', 'Europe/Amsterdam');

/**
 * Bootstrap the PitchBlade library
 */
require_once __DIR__ . '/src/HexDump/bootstrap.php';

/**
 * Setup autoloader for the demo
 */
$autoloader = new Autoloader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

/**
 * Setup the request object
 */
$request = new Request($_SERVER, $_GET, $_POST, $_COOKIE);

/**
 * Render the page
 */
require __DIR__ . '/templates/main.phtml';
