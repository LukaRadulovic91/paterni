<?php

namespace paterni\Behavioral\State\Theory;

/**
 * The client code.
 */
$context = new Context(new ConcreteStateA());
$context->request1();
$context->request2();