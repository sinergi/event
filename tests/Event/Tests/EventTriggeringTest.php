<?php
namespace Sinergi\Event\Tests;

use InvalidArgumentException;
use Sinergi\Event\Event;
use PHPUnit_Framework_TestCase;

class EventTriggeringTest extends PHPUnit_Framework_TestCase
{
    public function testEventTriggering()
    {
        $test = false;
        Event::on('test', function() use (&$test) {
            $test = true;
        });
        Event::trigger('test');
        $this->assertTrue($test);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEventTriggeringBadAttribute()
    {
        Event::trigger([]);
    }

    public function testEventTriggeringreturnValue()
    {
        Event::on('test.returnvalue', function() {
            return 999;
        });

        $retval = Event::trigger('test.returnvalue');
        $this->assertTrue(is_array($retval));
        $this->assertEquals(1, count($retval));
        $this->assertEquals(999, current($retval));
    }
}