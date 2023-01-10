<?php

namespace paterni\Structural\Adapter\Theory;

/**
 * The Adapter makes the Adaptee's interface compatible with the Target's
 * interface.
 */
class Adapter extends Target
{
    /**
     * @var Adaptee $adaptee
     */
    private $adaptee;

    /**
     * Adapter constructor.
     *
     * @param Adaptee $adaptee
     */
    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    /**
     * @return string
     */
    public function request(): string
    {
        return "Adapter: (TRANSLATED) " . strrev($this->adaptee->specificRequest());
    }
}
