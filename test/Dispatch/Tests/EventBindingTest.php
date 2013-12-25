<?php
namespace Dispatch\Tests;

use InvalidArgumentException;
use Dispatch\Event;
use PHPUnit_Framework_TestCase;

class EventBindingTest extends PHPUnit_Framework_TestCase
{
    public function testEventBinding()
    {
        $this->assertTrue(Event::on('test', function() {}));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadEventBinding()
    {
        Event::on([], function() {});
    }
}