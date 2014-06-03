<?php
namespace Sinergi\Event\Tests;

use PHPUnit_Framework_TestCase;

class ListenerInterfaceTest extends PHPUnit_Framework_TestCase
{
    public function testListenerInterface()
    {
        $listener = new ListenerMock();
        $this->assertInstanceOf('Sinergi\Event\ListenerInterface', $listener);
    }
}