<?php

namespace Drupal\dino_roar\Controller;

use Drupal\dino_roar\Jurassic\RoarGenerator;
use Symfony\Component\HttpFoundation\Response;

class RoarController
{
    public function roar($count)
    {
        $roarGenerator = new RoarGenerator();
        $roar = $roarGenerator->getRoar($count);

        return new Response($roar);
    }
}
