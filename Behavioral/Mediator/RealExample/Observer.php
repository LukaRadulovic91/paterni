<?php

namespace paterni\Behavioral\Mediator\RealExample;

/**
 * The Observer interface defines how components receive the event
 * notifications.
 */
interface Observer
{
    public function update(string $event, object $emitter, $data = null);
}
