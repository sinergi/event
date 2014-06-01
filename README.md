# Event

[![Build Status](https://travis-ci.org/sinergi/event.svg)](https://travis-ci.org/sinergi/event)

PHP event dispatching library.

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

Bind events:

```php
Sinergi\Event\Event::on('event.name', function($argument) {
    return strrev($argument);
});
```

Trigger events:

```php
Sinergi\Event\Event::trigger('event.name', ['my arguments']);
```