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

namespace Gears\Event\Async\QueueInterop;

use Gears\Event\Async\AbstractEventQueue;
use Gears\Event\Async\Exception\EventQueueException;
use Gears\Event\Async\Serializer\EventSerializer;
use Gears\Event\Event;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;

class QueueInteropEventQueue extends AbstractEventQueue
{
    /**
     * Queue context.
     *
     * @var Context
     */
    protected $context;

    /**
     * @var Destination
     */
    protected $destination;

    /**
     * EnqueueEventBus constructor.
     *
     * @param EventSerializer $serializer
     * @param Context         $context
     * @param Destination     $destination
     */
    public function __construct(EventSerializer $serializer, Context $context, Destination $destination)
    {
        parent::__construct($serializer);

        $this->context = $context;
        $this->destination = $destination;
    }

    /**
     * {@inheritdoc}
     */
    final public function send(Event $event): void
    {
        // @codeCoverageIgnoreStart
        try {
            $this->getMessageProducer()->send($this->destination, $this->getMessage($event));
        } catch (\Exception $exception) {
            throw new EventQueueException('Failure enqueueing event', 0, $exception);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get message from event.
     *
     * @param Event $event
     *
     * @return Message
     */
    protected function getMessage(Event $event): Message
    {
        return $this->context->createMessage($this->getSerializedEvent($event));
    }

    /**
     * Get message producer.
     *
     * @return Producer
     */
    protected function getMessageProducer(): Producer
    {
        return $this->context->createProducer();
    }
}
