<?php

namespace ContainerFxtMAYD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getParseFileHandlerService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Guides\RestructuredText\Handlers\ParseFileHandler' shared autowired service.
     *
     * @return \phpDocumentor\Guides\RestructuredText\Handlers\ParseFileHandler
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Guides'.\DIRECTORY_SEPARATOR.'RestructuredText'.\DIRECTORY_SEPARATOR.'Handlers'.\DIRECTORY_SEPARATOR.'ParseFileHandler.php';
        include_once \dirname(__DIR__, 6).''.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'event-manager'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'EventManager.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Guides'.\DIRECTORY_SEPARATOR.'Metas.php';

        return $container->privates['phpDocumentor\\Guides\\RestructuredText\\Handlers\\ParseFileHandler'] = new \phpDocumentor\Guides\RestructuredText\Handlers\ParseFileHandler(($container->privates['phpDocumentor\\Guides\\Metas'] ?? ($container->privates['phpDocumentor\\Guides\\Metas'] = new \phpDocumentor\Guides\Metas())), ($container->privates['phpDocumentor\\Guides\\Renderer'] ?? $container->load('getRendererService')), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')), new \Doctrine\Common\EventManager(), new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Code'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Code'] = new \phpDocumentor\Guides\RestructuredText\Directives\Code()));
            yield 1 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\CodeBlock'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\CodeBlock'] = new \phpDocumentor\Guides\RestructuredText\Directives\CodeBlock()));
            yield 2 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Figure'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Figure'] = new \phpDocumentor\Guides\RestructuredText\Directives\Figure()));
            yield 3 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Image'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Image'] = new \phpDocumentor\Guides\RestructuredText\Directives\Image()));
            yield 4 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Meta'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Meta'] = new \phpDocumentor\Guides\RestructuredText\Directives\Meta()));
            yield 5 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Raw'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Raw'] = new \phpDocumentor\Guides\RestructuredText\Directives\Raw()));
            yield 6 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Replace'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Replace'] = new \phpDocumentor\Guides\RestructuredText\Directives\Replace()));
            yield 7 => ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Toctree'] ?? ($container->privates['phpDocumentor\\Guides\\RestructuredText\\Directives\\Toctree'] = new \phpDocumentor\Guides\RestructuredText\Directives\Toctree()));
        }, 8), new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['phpDocumentor\\Guides\\References\\Doc'] ?? ($container->privates['phpDocumentor\\Guides\\References\\Doc'] = new \phpDocumentor\Guides\References\Doc()));
            yield 1 => ($container->privates['phpDocumentor\\Guides\\References\\NamespaceReference'] ?? ($container->privates['phpDocumentor\\Guides\\References\\NamespaceReference'] = new \phpDocumentor\Guides\References\NamespaceReference()));
            yield 2 => ($container->privates['phpDocumentor\\Guides\\References\\PhpClassReference'] ?? ($container->privates['phpDocumentor\\Guides\\References\\PhpClassReference'] = new \phpDocumentor\Guides\References\PhpClassReference()));
            yield 3 => ($container->privates['phpDocumentor\\Guides\\References\\PhpFunctionReference'] ?? ($container->privates['phpDocumentor\\Guides\\References\\PhpFunctionReference'] = new \phpDocumentor\Guides\References\PhpFunctionReference()));
            yield 4 => ($container->privates['phpDocumentor\\Guides\\References\\PhpMethodReference'] ?? ($container->privates['phpDocumentor\\Guides\\References\\PhpMethodReference'] = new \phpDocumentor\Guides\References\PhpMethodReference()));
        }, 5));
    }
}
