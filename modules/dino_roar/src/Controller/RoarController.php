<?php

namespace Drupal\dino_roar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class RoarController extends ControllerBase
{
    /**
     * @var RoarGenerator
     */
    private $roarGenerator;
    /**
     * @var LoggerChannelFactoryInterface
     */
    private $loggerFactory;

    public function __construct(RoarGenerator $roarGenerator, LoggerChannelFactoryInterface $loggerFactory)
    {
        $this->roarGenerator = $roarGenerator;
        $this->loggerFactory = $loggerFactory;
    }

    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('dino_roar.roar_generator');
        $loggerFactory = $container->get('logger.factory');

        return new static($roarGenerator, $loggerFactory);
    }

    public function roar($count)
    {
        $keyValueStore = $this->keyValue('dino');

        //$roar = $this->roarGenerator->getRoar($count);
        //$keyValueStore->set('roar_string', $roar);
        $roar = $keyValueStore->get('roar_string');
        $this->loggerFactory->get('default')
            ->debug($roar);

        return new Response($roar);
    }
}
