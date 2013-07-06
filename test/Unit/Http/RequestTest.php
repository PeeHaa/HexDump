<?php

namespace HexDumpTest\Unit\Http;

use HexDump\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $serverVariables;
    protected $getVariables;
    protected $postVariables;
    protected $cookieVariables;

    public function setUp()
    {
        $this->serverVariables = \HexDumpTest\getTestDataFromFile(HEXDUMP_TEST_DATA_DIR . '/Http/server-variables.php');
        $this->getVariables    = \HexDumpTest\getTestDataFromFile(HEXDUMP_TEST_DATA_DIR . '/Http/get-variables.php');
        $this->postVariables   = \HexDumpTest\getTestDataFromFile(HEXDUMP_TEST_DATA_DIR . '/Http/post-variables.php');
        $this->cookieVariables = ['key' => 'value'];
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     */
    public function testConstructCorrectInterface()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertInstanceOf('\\HexDump\\Http\\Request', $request);
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getPath
     */
    public function testGetPath()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('/some/deep/path', $request->getPath());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getGetVariables
     */
    public function testGetGetVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame($this->getVariables, $request->getGetVariables());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getGetVariable
     */
    public function testGetGetVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('value1', $request->getGetVariable('var1'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getGetVariable
     */
    public function testGetGetVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertNull($request->getGetVariable('var99'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getGetVariable
     */
    public function testGetGetVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('nonDefault', $request->getGetVariable('var99', 'nonDefault'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getPostVariables
     */
    public function testGetPostVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame($this->postVariables, $request->getPostVariables());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getPostVariable
     */
    public function testGetPostVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('postvalue1', $request->getPostVariable('postvar1'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getPostVariable
     */
    public function testGetPostVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertNull($request->getPostVariable('postvar99'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getPostVariable
     */
    public function testGetPostVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('nonDefault', $request->getPostVariable('postvar99', 'nonDefault'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getCookieVariables
     */
    public function testGetCookieVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame($this->cookieVariables, $request->getCookieVariables());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getCookieVariable
     */
    public function testGetCookieVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('value', $request->getCookieVariable('key'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getCookieVariable
     */
    public function testGetCookieVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertNull($request->getCookieVariable('cookievar99'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getCookieVariable
     */
    public function testGetCookieVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('nonDefault', $request->getCookieVariable('postvar99', 'nonDefault'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getServerVariables
     */
    public function testGetServerVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame($this->serverVariables, $request->getServerVariables());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getServerVariable
     */
    public function testGetServerVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('example.com', $request->getServerVariable('SERVER_NAME'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getServerVariable
     */
    public function testGetServerVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertNull($request->getServerVariable('unknownservervariable'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getServerVariable
     */
    public function testGetServerVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('nonDefault', $request->getServerVariable('unknownservervariable', 'nonDefault'));
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getMethod
     */
    public function testGetMethod()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('POST', $request->getMethod());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::getHost
     */
    public function testGetHost()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertSame('www.example.com', $request->getHost());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::isSsl
     */
    public function testIsSslWithOn()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertTrue($request->isSsl());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::isSsl
     */
    public function testIsSslWithOff()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = 'off';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertFalse($request->isSsl());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::isSsl
     */
    public function testIsSslWithoutValue()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = '';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertFalse($request->isSsl());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::isSsl
     */
    public function testIsSslWithSomeString()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = 'somerandomstring';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertTrue($request->isSsl());
    }

    /**
     * @covers HexDump\Http\Request::__construct
     * @covers HexDump\Http\Request::setPath
     * @covers HexDump\Http\Request::getBarePath
     * @covers HexDump\Http\Request::isSsl
     */
    public function testIsSslWithoutHttpsKey()
    {
        $serverVariables = $this->serverVariables;
        unset($serverVariables['HTTPS']);

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables, $this->cookieVariables);
        $this->assertFalse($request->isSsl());
    }
}
