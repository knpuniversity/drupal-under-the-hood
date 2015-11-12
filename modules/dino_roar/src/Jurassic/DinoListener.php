<?php

namespace Drupal\dino_roar\Jurassic;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DinoListener implements EventSubscriberInterface
{
    private $loggerChannel;

    public function __construct(LoggerChannelFactoryInterface $loggerChannel)
    {
        $this->loggerChannel = $loggerChannel;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $shouldRoar = $request->query->get('roar');

        if ($shouldRoar) {
            $channel = $this->loggerChannel->get('default')
                ->debug('ROOOOOOOOAR');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

}