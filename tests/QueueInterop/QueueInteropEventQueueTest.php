<?php

/*
 * event-async-queue-interop (https://github.com/phpgears/event-async-queue-interop).
 * Queue-interop async decorator for Event bus.
 *
 * @license MIT
 * @link https://github.com/phpgears/event-async-queue-interop
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\Event\Async\QueueInterop\Tests;

use Gears\Event\Async\QueueInterop\QueueInteropEventQueue;
use Gears\Event\Async\Serializer\EventSerializer;
use Gears\Event\Event;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use PHPUnit\Framework\TestCase;

class QueueInteropEventQueueTest extends TestCase
{
    public function testQueueSend(): void
    {
        $serializer = $this->getMockBuilder(EventSerializer::class)
            ->getMock();
        $serializer->expects(static::once())
            ->method('serialize')
            ->will(static::returnValue(''));
        /* @var EventSerializer $serializer */

        $producer = $this->getMockBuilder(Producer::class)
            ->getMock();
        $producer->expects(static::once())
            ->method('send');
        /* @var Producer $producer */

        /* @var Message $message */
        $message = $this->getMockBuilder(Message::class)
            ->getMock();

        $context = $this->getMockBuilder(Context::class)
            ->getMock();
        $context->expects(static::once())
            ->method('createProducer')
            ->will(static::returnValue($producer));
        $context->expects(static::once())
            ->method('createMessage')
            ->will(static::returnValue($message));
        /* @var Context $context */

        /* @var Destination $destination */
        $destination = $this->getMockBuilder(Destination::class)
            ->getMock();

        /* @var Event $command */
        $command = $this->getMockBuilder(Event::class)
            ->getMock();

        (new QueueInteropEventQueue($serializer, $context, $destination))->send($command);
    }
}
