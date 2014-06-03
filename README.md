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

### Listener example

```php
use Sinergi\Event\ListenerInterface;

class MyListener implements ListenerInterface
{
    public function onUpdate(Subject $subject)
    {
        // do something
    }
}
```

### Subject example

```php
class Subject
{
    public $dispatcher;

    public function update()
    {
        $this->dispatcher->trigger($this, 'update');
    }
}
```

### Add listener to dispatcher

```php
use Sinergi\Event\Dispatcher;

$dispatcher = new Dispatcher();
$dispatcher->add(new MyListener());
```

### Bind it all together

```php
$subject = new Subject();
$subject->dispatcher = $dispatcher;
$subject->update();
```
