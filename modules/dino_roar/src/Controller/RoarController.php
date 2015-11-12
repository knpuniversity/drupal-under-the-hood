<?php

namespace Drupal\dino_roar\Controller;

use Symfony\Component\HttpFoundation\Response;

class RoarController
{
    public function roar($count)
    {
        $roar = 'R'.str_repeat('O', $count).'AR!';
        return new Response($roar);
    }
}
