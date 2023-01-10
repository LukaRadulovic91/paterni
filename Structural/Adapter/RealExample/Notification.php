<?php

namespace paterni\Structural\Adapter\RealExample;

/**
 * The Target interface represents the interface that your application's classes
 * already follow.
 */
interface Notification
{
    /**
     * @param string $title
     * @param string $message
     *
     * @return mixed
     */
    public function send(string $title, string $message);
}
