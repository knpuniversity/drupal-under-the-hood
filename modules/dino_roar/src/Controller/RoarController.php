<?php

namespace Drupal\dino_roar\Controller;

use Symfony\Component\HttpFoundation\Response;

class RoarController
{
    public function roar()
    {
        return new Response('ROOOOOAR!');
    }
}
