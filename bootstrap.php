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
    HexDump\Http\Request,
    HexDump\FileSystem\Storage;

/**
 * Setup error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

/**
 * Setup memory limit because the pattern finder code is sloppy and I am lazy
 */
ini_set('memory_limit', '2048M');

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
 * Setup storage
 */
$storage = new Storage(__DIR__ . '/data');

/**
 * Prevent rendering of templates when on CLI
 */
if(php_sapi_name() === 'cli') {
    return;
}

/**
 * Setup the request object
 */
$request = new Request($_SERVER, $_GET, $_POST, $_COOKIE);

/**
 * Get the template
 */
if ($request->getPath() == '/convert') {
    if ($request->getPostVariable('string') !== '') {
        $hash = $storage->save($request->getPostVariable('string'));
    } else {
        $hash = $storage->save(file_get_contents($_FILES['file']['tmp_name']));
    }

    $resultUrl = $request->isSsl() ? 'https://' : 'http://';
    $resultUrl.= $request->getHost();
    $resultUrl.= '/' . $hash;

    header('Location: ' . $resultUrl);
    exit;
} elseif (strlen($request->getPath()) === 41) {
    $hash = substr($request->getPath(), 1);

    $template = __DIR__ . '/templates/result.phtml';
} else if (preg_match('#^/([a-f0-9]{40})/search#', $request->getPath(), $matches) === 1 && $request->getMethod() === 'POST') {
    $resultUrl = $request->isSsl() ? 'https://' : 'http://';
    $resultUrl.= $request->getHost();
    $resultUrl.= '/' . $matches[1] . '/search/' . str_replace(' ', '', $request->getPostVariable('search'));

    header('Location: ' . $resultUrl);
    exit;
} else if (preg_match('#^/([a-f0-9]{40})/search/([^/]+)#', $request->getPath(), $matches) === 1 && $request->getMethod() === 'GET') {
    $hash   = $matches[1];
    $search = $matches[2];

    $template = __DIR__ . '/templates/result.phtml';
} else {
    $template = __DIR__ . '/templates/main.phtml';
}

/**
 * Render the page
 */
ob_start();
require $template;
$content = ob_get_contents();
ob_end_clean();

require __DIR__ . '/templates/page.phtml';
