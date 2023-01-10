<?php

namespace paterni\Behavioral\Strategy\Theory;

class ConcreteStrategyB implements Strategy
{
    public function doAlgorithm(array $data): array
    {
        rsort($data);

        return $data;
    }
}
