<?php

/**
 * @see       https://github.com/laminas/laminas-console for the canonical source repository
 * @copyright https://github.com/laminas/laminas-console/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-console/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Console\Char;

use Laminas\Console\Prompt\Select;
use LaminasTest\Console\TestAssets\ConsoleAdapter;

/**
 * @group      Laminas_Console
 */
class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsoleAdapter
     */
    protected $adapter;

    public function setUp()
    {
        $this->adapter = new ConsoleAdapter();
        $this->adapter->stream = fopen('php://memory', 'w+');
    }

    public function tearDown()
    {
        fclose($this->adapter->stream);
    }

    public function testCanSelectOption()
    {
        fwrite($this->adapter->stream, "0");

        $select = new Select('Select an option :', array('foo', 'bar'));
        $select->setConsole($this->adapter);
        ob_start();
        $response = $select->show();
        $text = ob_get_clean();
        $this->assertTrue((bool) preg_match('#0\) foo#', $text));
        $this->assertTrue((bool) preg_match('#1\) bar#', $text));
        $this->assertEquals('0', $response);
    }

    public function testCanSelectOptionWithCustomIndex()
    {
        fwrite($this->adapter->stream, "2");

        $select = new Select('Select an option :', array('2' => 'foo', '6' => 'bar'));
        $select->setConsole($this->adapter);
        ob_start();
        $response = $select->show();
        $text = ob_get_clean();
        $this->assertTrue((bool) preg_match('#2\) foo#', $text));
        $this->assertTrue((bool) preg_match('#6\) bar#', $text));
        $this->assertEquals('2', $response);
    }
}
