<?php
namespace Sinergi\Event\Tests;

use Sinergi\Event\Dispatcher;
use PHPUnit_Framework_TestCase;

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->add($listener = new ListenerMock());
    }

    public function testTrigger()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->add($listener = new ListenerMock());
        $dispatcher->trigger(new SubjectMock(), 'update');

        $this->assertTrue($listener->subjectUpdated);
    }

    public function testTriggerParameters()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->add($listener = new ListenerMock());
        $dispatcher->trigger(new SubjectMock(), 'update', ['test1']);

        $this->assertTrue($listener->subjectUpdated);
        $this->assertEquals('test1', $listener->parameter1);
    }

    public function testWrongSubjectTrigger()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->add($listener = new ListenerMock());
        $dispatcher->trigger(new SubjectMock2(), 'update');

        $this->assertFalse($listener->subjectUpdated);
    }

    public function testWrongEventTrigger()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->add($listener = new ListenerMock());
        $dispatcher->trigger(new SubjectMock(), 'find');

        $this->assertFalse($listener->subjectUpdated);
    }
}