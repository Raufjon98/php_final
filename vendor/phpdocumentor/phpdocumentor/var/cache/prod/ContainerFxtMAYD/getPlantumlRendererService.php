<?php

namespace ContainerFxtMAYD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPlantumlRendererService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Transformer\Writer\Graph\PlantumlRenderer' shared autowired service.
     *
     * @return \phpDocumentor\Transformer\Writer\Graph\PlantumlRenderer
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'phpDocumentor'.\DIRECTORY_SEPARATOR.'Transformer'.\DIRECTORY_SEPARATOR.'Writer'.\DIRECTORY_SEPARATOR.'Graph'.\DIRECTORY_SEPARATOR.'PlantumlRenderer.php';

        return $container->privates['phpDocumentor\\Transformer\\Writer\\Graph\\PlantumlRenderer'] = new \phpDocumentor\Transformer\Writer\Graph\PlantumlRenderer(($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')), (\dirname(__DIR__, 4).'/bin/plantuml'));
    }
}
