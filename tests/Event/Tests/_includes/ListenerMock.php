<?php
namespace Sinergi\Event\Tests;

use Sinergi\Event\ListenerInterface;

class ListenerMock implements ListenerInterface
{
    public $subjectUpdated = false;
    public $parameter1;

    public function onUpdate(SubjectMock $subject, $parameter1 = null)
    {
        $this->subjectUpdated = true;
        $this->parameter1 = $parameter1;
    }
}