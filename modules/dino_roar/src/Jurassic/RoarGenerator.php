<?php

namespace Drupal\dino_roar\Jurassic;

class RoarGenerator
{
    public function getRoar($length)
    {
        return 'R'.str_repeat('O', $length).'AR!';
    }
}
