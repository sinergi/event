<?php
namespace Dispatch\Tests;

use PHPUnit_Framework_TestCase;
use Dispatch\Autoloader;

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
    public function testAutoload()
    {
        $declared = get_declared_classes();
        $declaredCount = count($declared);
        Autoloader::autoload('Foo');
        $this->assertEquals($declaredCount, count(get_declared_classes()), 'Dispatch\\Autoloader::autoload() is trying to load classes outside of the Dispatch namespace');
        Autoloader::autoload('Dispatch\\Event');
        $this->assertTrue(in_array('Dispatch\\Event', get_declared_classes()), 'Dispatch\\Autoloader::autoload() failed to autoload the Dispatch\\Daemon class');
    }
}