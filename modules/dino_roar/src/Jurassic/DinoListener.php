<?php

namespace Drupal\dino_roar\Jurassic;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class DinoListener implements EventSubscriberInterface
{
    public function onKernelRequest($event)
    {
        var_dump($event);die;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

}