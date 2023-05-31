<?php

namespace Drupal\sand_type\Query\Bundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service description.
 */
class DateQuery
{

    /**
     * The container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Constructs a QueryDate object.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *   The container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Method description.
     */
    public static function getIds(): array {
        return \Drupal::entityQuery('node')
            ->condition('status', 1)
            ->condition('type', 'date')
            ->execute();
    }

}
