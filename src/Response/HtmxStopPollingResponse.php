<?php

declare(strict_types=1);

namespace Seaworn\HtmxBundle\Response;

class HtmxStopPollingResponse extends HtmxResponse {

    public const HX_STOP_POLLING = 286;

    public function __construct()
    {
        parent::__construct('', self::HX_STOP_POLLING);
    }
}