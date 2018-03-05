<?php

declare(strict_types=1);

namespace Powerbody\Manufacturer\Service;

interface ConfigurationReaderInterface
{
    public function getMinimalMargin() : int;
}
