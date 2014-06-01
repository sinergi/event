<?php
namespace Sinergi\Event\Tests;

use InvalidArgumentException;
use Sinergi\Event\Event;
use PHPUnit_Framework_TestCase;

class EventUnbindingTest extends PHPUnit_Framework_TestCase
{
    public function testEventUnbinding()
    {
        $this->assertTrue(Event::off('test', function() {}));
    }

    public function testEventUnbindingNotTriggering()
    {
        $test = true;
        Event::on('test.nottriggering', function() use (&$test) {
            $test = false;
        });
        Event::trigger('test.nottriggering');
        $this->assertFalse($test);
        $test = true;
        Event::trigger('test.nottriggering');
        $this->assertFalse($test);
        $test = true;
        Event::off('test.nottriggering');
        Event::trigger('test.nottriggering');
        $this->assertTrue($test);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadEventUnbinding()
    {
        Event::off([], function() {});
    }
}