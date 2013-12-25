Dispatch
========

[![Build Status](https://travis-ci.org/sinergi/dispatch.png)](https://travis-ci.org/sinergi/dispatch)

PHP event dispatching library.

## Requirements

This library uses PHP 5.4+.

## Installation

It is recommended that you install the Dispatch library [through composer](http://getcomposer.org/). To do so, add the following lines to your ``composer.json`` file.

```json
{
    "require": {
       "sinergi/dispatch": "dev-master"
    }
}
```

## Usage

Bind events:

```php
Dispatch\Event::on('event.name', function($argument) {
    return strrev($argument);
});
```

Trigger events:

```php
Dispatch\Event::trigger('event.name', ['my arguments']);
```