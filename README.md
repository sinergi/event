# Event

[![Build Status](https://travis-ci.org/sinergi/event.svg)](https://travis-ci.org/sinergi/event)

A smart PHP event dispatching library that does not require your listeners to be aware of your subjects.

<a name="requirements"></a>
## Requirements

This library uses PHP 5.4+.

<a name="installation"></a>
## Installation

It is recommended that you install the Event library [through composer](http://getcomposer.org/). To do so, add the following lines to your ``composer.json`` file.

```json
{
    "require": {
       "sinergi/event": "dev-master"
    }
}
```

<a name="usage"></a>
## Usage

### Listener Example

```php
use Sinergi\Event\ListenerInterface;

class MyListener implements ListenerInterface
{
    public function onUpdate(Subject $subject)
    {
        // to something
    }
}
```

### Add listener

```php
use Sinergi\Event\Dispatcher;

$dispatcher = new Dispatcher();
$dispatcher->add(new MyListener());
```

### Trigger events

```php
class Subject
{
    const UPDATE_EVENT = 'update';

    public $dispatcher;

    public function update()
    {
        $dispatcher->trigger($this, self::UPDATE_EVENT);
    }
}
```