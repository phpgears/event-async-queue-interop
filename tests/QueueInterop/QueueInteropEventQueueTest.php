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
use Interop\Queue\PsrContext;
use Interop\Queue\PsrDestination;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProducer;
use PHPUnit\Framework\TestCase;

class QueueInteropEventQueueTest extends TestCase
{
    public function testQueueSend(): void
    {
        $serializer = $this->getMockBuilder(EventSerializer::class)
            ->getMock();
        $serializer->expects($this->once())
            ->method('serialize')
            ->will($this->returnValue(''));
        /* @var EventSerializer $serializer */

        $producer = $this->getMockBuilder(PsrProducer::class)
            ->getMock();
        $producer->expects($this->once())
            ->method('send');
        /* @var PsrProducer $producer */

        /* @var PsrMessage $message */
        $message = $this->getMockBuilder(PsrMessage::class)
            ->getMock();

        $context = $this->getMockBuilder(PsrContext::class)
            ->getMock();
        $context->expects($this->once())
            ->method('createProducer')
            ->will($this->returnValue($producer));
        $context->expects($this->once())
            ->method('createMessage')
            ->will($this->returnValue($message));
        /* @var PsrContext $context */

        /* @var PsrDestination $destination */
        $destination = $this->getMockBuilder(PsrDestination::class)
            ->getMock();

        /* @var Event $command */
        $command = $this->getMockBuilder(Event::class)
            ->getMock();

        (new QueueInteropEventQueue($serializer, $context, $destination))->send($command);
    }
}
