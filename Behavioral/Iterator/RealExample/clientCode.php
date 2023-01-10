<?php

namespace paterni\Behavioral\Iterator\RealExample;


/**
 * The client code.
 */
$csv = new CsvIterator(__DIR__ . '/cats.csv');

foreach ($csv as $key => $row) {
    print_r($row);
}