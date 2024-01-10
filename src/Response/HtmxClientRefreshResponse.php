<?php

declare(strict_types=1);

namespace Seaworn\HtmxBundle\Response;

class HtmxClientRefreshResponse extends HtmxResponse {
    public const HX_REFRESH = 'HX-Refresh';

    public function __construct()
    {
        parent::__construct('', self::HTTP_OK, [self::HX_REFRESH => 'true']);
    }
}