[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/phpgears/event-async-queue-interop.svg?style=flat-square)](https://packagist.org/packages/phpgears/event-async-queue-interop)
[![License](https://img.shields.io/github/license/phpgears/event-async-queue-interop.svg?style=flat-square)](https://github.com/phpgears/event-async-queue-interop/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/phpgears/event-async-queue-interop.svg?style=flat-square)](https://travis-ci.org/phpgears/event-async-queue-interop)
[![Style Check](https://styleci.io/repos/159408507/shield)](https://styleci.io/repos/159408507)
[![Code Quality](https://img.shields.io/scrutinizer/g/phpgears/event-async-queue-interop.svg?style=flat-square)](https://scrutinizer-ci.com/g/phpgears/event-async-queue-interop)
[![Code Coverage](https://img.shields.io/coveralls/phpgears/event-async-queue-interop.svg?style=flat-square)](https://coveralls.io/github/phpgears/event-async-queue-interop)

[![Total Downloads](https://img.shields.io/packagist/dt/phpgears/event-async-queue-interop.svg?style=flat-square)](https://packagist.org/packages/phpgears/event-async-queue-interop/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/phpgears/event-async-queue-interop.svg?style=flat-square)](https://packagist.org/packages/phpgears/event-async-queue-interop/stats)

# Queue-interop async Event bus

[Queue-interop](https://github.com/queue-interop/queue-interop) async decorator for Event bus

## Installation

### Composer

```
composer require phpgears/event-async-queue-interop
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

### Asynchronous Event Bus

Please review [phpgears/event-async](https://github.com/phpgears/event-async) for more information on async event bus

```php
use Gears\Event\Async\AsyncEventBus;
use Gears\Event\Async\QueueInterop\QueueInteropEventQueue;
use Gears\Event\Async\Serializer\JsonEventSerializer;
use Gears\Event\Async\Discriminator\ParameterEventDiscriminator;

/* @var \Gears\Event\EventBus $eventBus */
/* @var \Interop\Queue\PsrContext $context */
/* @var \Interop\Queue\PsrDestination $destination */

$eventQueue = new QueueInteropEventQueue(new JsonEventSerializer(), $context, $destination);

$asyncEventBus = new AsyncEventBus(
    $eventBus,
    $eventQueue,
    new ParameterEventDiscriminator('async')
);

$asyncEvent = CustomEvent::occurred(['async' => true]);

$asyncEventBus->dispatch($asyncEvent);
```

There are some queue-interop implementations available such as [Enqueue](https://github.com/php-enqueue/enqueue) which supports an incredible number of message queues

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/event-async-queue-interop/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/event-async-queue-interop/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/event-async-queue-interop/blob/master/LICENSE) included with the source code for a copy of the license terms.
