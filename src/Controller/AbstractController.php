<?php

declare(strict_types=1);

namespace Seaworn\HtmxBundle\Controller;

/**
 * Provides helpers for htmx features in controllers
 */
class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController {
    use HtmxControllerTrait;
}