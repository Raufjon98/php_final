<?php

namespace ContainerFxtMAYD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getContainerBuilderService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private '.errored..service_locator.u47of.0.Symfony\Component\DependencyInjection\ContainerBuilder' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    public static function do($container, $lazyLoad = true)
    {
        $container->throw('Cannot autowire service ".service_locator.u47of.0": it references class "Symfony\\Component\\DependencyInjection\\ContainerBuilder" but no such service exists. Try changing the type-hint to one of its parents: interface "Symfony\\Component\\DependencyInjection\\ContainerInterface", or interface "Psr\\Container\\ContainerInterface".');
    }
}
