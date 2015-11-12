<?php

namespace Drupal\dino_roar\Jurassic;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

class RoarGenerator
{
    private $keyValueFactory;

    public function __construct(KeyValueFactoryInterface $keyValueFactory)
    {
        $this->keyValueFactory = $keyValueFactory;
    }

    public function getRoar($length)
    {
        $store = $this->keyValueFactory->get('dino');
        $key = 'roar_'.$length;

        if ($store->has($key)) {
            return $store->get($key);
        }

        sleep(2);

        $string = 'R'.str_repeat('O', $length).'AR!';
        $store->set($key, $string);

        return $string;
    }
}
