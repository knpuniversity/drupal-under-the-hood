<?php

namespace Drupal\dino_roar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class RoarController extends ControllerBase
{
    /**
     * @var RoarGenerator
     */
    private $roarGenerator;

    public function __construct(RoarGenerator $roarGenerator)
    {
        $this->roarGenerator = $roarGenerator;
    }

    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('dino_roar.roar_generator');

        return new static($roarGenerator);
    }

    public function roar($count)
    {
        $roar = $this->roarGenerator->getRoar($count);

        return new Response($roar);
    }
}
