<?php

namespace paterni\Behavioral\Mediator\RealExample;

/**
 * The Event Dispatcher class acts as a Mediator and contains the subscription
 * and notification logic. While a classic Mediator often depends on concrete
 * component classes, this one is only tied to their abstract interfaces.
 *
 * We are able to achieve this level of indirection thanks to the way the
 * connections between components are established. The components themselves may
 * subscribe to specific events that they are interested in via the Mediator's
 * subscription interface.
 *
 * Note, we can't use the PHP's built-in Subject/Observer interfaces here
 * because we'll be stretching them too far from what they were designed for.
 */
class EventDispatcher
{
    /**
     * @var array
     */
    private $observers = [];

    public function __construct()
    {
        // The special event group for observers that want to listen to all
        // events.
        $this->observers["*"] = [];
    }

    private function initEventGroup(string &$event = "*"): void
    {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = [];
        }
    }

    private function getEventObservers(string $event = "*"): array
    {
        $this->initEventGroup($event);
        $group = $this->observers[$event];
        $all = $this->observers["*"];

        return array_merge($group, $all);
    }

    public function attach(Observer $observer, string $event = "*"): void
    {
        $this->initEventGroup($event);

        $this->observers[$event][] = $observer;
    }

    public function detach(Observer $observer, string $event = "*"): void
    {
        foreach ($this->getEventObservers($event) as $key => $s) {
            if ($s === $observer) {
                unset($this->observers[$event][$key]);
            }
        }
    }

    public function trigger(string $event, object $emitter, $data = null): void
    {
        echo "EventDispatcher: Broadcasting the '$event' event.\n";
        foreach ($this->getEventObservers($event) as $observer) {
            $observer->update($event, $emitter, $data);
        }
    }
}

/**
 * A simple helper function to provide global access to the event dispatcher.
 */
function events(): EventDispatcher
{
    static $eventDispatcher;
    if (!$eventDispatcher) {
        $eventDispatcher = new EventDispatcher();
    }

    return $eventDispatcher;
}