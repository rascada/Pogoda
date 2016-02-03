<?php

namespace SyntaxError\NotificationBundle\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface NotifyInterface
 * @package SyntaxError\NotificationBundle\Kernel
 */
interface NotifyInterface
{
    /**
     * If return true call to getContent method.
     *
     * @param ContainerInterface $container
     * @return boolean
     */
    public function isActive(ContainerInterface $container);

    /**
     * Return name of notification.
     *
     * @return string
     */
    public function getName();

    /**
     * Return content of notify in HTML.
     *
     * @return string
     */
    public function getContent();
}
