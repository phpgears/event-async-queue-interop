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
use Interop\Queue\PsrContext;
use Interop\Queue\PsrDestination;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProducer;

class QueueInteropEventQueue extends AbstractEventQueue
{
    /**
     * Queue context.
     *
     * @var PsrContext
     */
    protected $context;

    /**
     * @var PsrDestination
     */
    protected $destination;

    /**
     * EnqueueEventBus constructor.
     *
     * @param EventSerializer $serializer
     * @param PsrContext      $context
     * @param PsrDestination  $destination
     */
    public function __construct(EventSerializer $serializer, PsrContext $context, PsrDestination $destination)
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
     * @return PsrMessage
     */
    protected function getMessage(Event $event): PsrMessage
    {
        return $this->context->createMessage($this->getSerializedEvent($event));
    }

    /**
     * Get message producer.
     *
     * @return PsrProducer
     */
    protected function getMessageProducer(): PsrProducer
    {
        return $this->context->createProducer();
    }
}
